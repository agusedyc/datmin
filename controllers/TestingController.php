<?php

namespace app\controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\models\Data;
use app\models\Testing;
use app\models\TestingSearch;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TestingController implements the CRUD actions for Testing model.
 */
class TestingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Testing models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testing model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function filterPost($array,$cond)
    {
        $filtered = array();
        foreach ($array as $key => $value) {
            if (strpos($key, $cond) !== 0) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Creates a new Testing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Data::find()->where(['status'=>'1'])->one();
        $sheetData = $this->loadCsv('/uploads/datasets/'.$model->file);
        // Nama Atribut data
        $attributes = $this->getAttribute($sheetData);
        $data = $this->dataType($sheetData,'string');
        $formData = $this->formFields($data,$data[0]);

        $model = new Testing();

        $postData = Yii::$app->request->post();
        if ($postData) {
            unset($postData['_csrf']);
            // echo '<pre>';
            // print_r();
            // echo '</pre>';
            $c45 = Yii::$app->c45;
            // Set data dan atribut
            $c45->setData($data)->setAttributes($attributes);
            // Hitung menggunakan data training
            $c45->hitung();

            // Data nya di filter dulu berdasarkan filed yang berawalan data_* dihapus
            $filterPostData = $this->filterPost($postData,'data_');
            // rubah hanya Value Array
            $values = array_values($filterPostData);
            // Hasil Keputusan
            $result = $c45->predictDataTesting($values);
            // tambahkan Hasil dalam array data
            $data_array = array_merge($postData,['hasil'=>$result]);
            // Convert to json
            $data_json = json_encode($data_array);
            // VarDumper::dump($data_json);
            // var_dump($data);
            $model->data_testing = $data_json;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
            // echo '<pre>';
            // print_r($data_array);
            // echo '</pre>';
        }

        return $this->render('create', [
            'model' => $model,
            'dataList' => $formData,
        ]);
    }

    /**
     * Updates an existing Testing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Testing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Testing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testing::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function dropdownLists($data,$attributes,$field)
    {
        // unset($data[0]);
        foreach ($data as $key => $value) {
           $columb[] = $value[array_search($field, $attributes)];
           $listColumb = array_unique($columb);
       }

       foreach ($listColumb as $key => $valColom) {
           $dataDropdown[] = [
                'id' => $key,
                'value' => $valColom,
           ];
       }

       return $dataDropdown;
    }

    public function formFields($data,$attributes)
    {
        foreach ($attributes as $key => $attrValue) {
            $formFields[] = $this->dropdownLists($data,$attributes,$attrValue);
        }
        // delete Label column
        unset($formFields[count($formFields)-1]);
        return $formFields;
    }

    public function dataType($dataset='',$typeData='')
    {
        foreach ($dataset as $key => $value) {
            $dataType[] = $this->setTipe($value,$typeData);
        }   

        return $dataType;
    }

    public function setTipe($arr='',$typeData='')
    {
        for ($i = 0; $i < count($arr); $i++) {
            settype($arr[$i], $typeData);
        }

        return $arr;
    }

    public function loadCsv($pathCsv='')
    {
        $inputFileName = Yii::$app->basePath.$pathCsv;
        $inputFileType = IOFactory::identify($inputFileName);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet = $reader->load($inputFileName);     
        return $sheetData = $spreadsheet->getActiveSheet()->toArray();
    }

    public function getAttribute($sheetData='')
    {
        foreach ($sheetData[0] as $key => $value) {
            $changeKeyArray[$key+1] = $value;
        }
        // Delete Last Array Attributes cause Its Result
        $remove_last_array = array_pop($changeKeyArray);
        return $changeKeyArray;
    }
}
