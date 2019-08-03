<?php

namespace app\controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\models\Data;
use app\models\DataSearch;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DataController implements the CRUD actions for Data model.
 */
class DataController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','dataset','tree','logout'],
                'rules' => [
                    [
                        'actions' => ['index','dataset','tree','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Data models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Data model.
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

    /**
     * Creates a new Data model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Data();

        if ($model->load(Yii::$app->request->post())) {
            Data::updateAll(['status' => 0]);
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload() && $model->save()) {
                // file is uploaded successfully and data Saved
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Data model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $saved_file = $model->file;
        $request= Yii::$app->request;
        if ($model->load($request->post())) {
            Data::updateAll(['status' => 0]);
            $uploadedFile = UploadedFile::getInstance($model, 'file');
            if (!empty($uploadedFile)) {
                $model->file = $uploadedFile;
                $model->upload();
            }else{
                $model->file = $saved_file;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Data model.
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
     * Finds the Data model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Data the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Data::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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

    public function getAttributeGridView($sheetData='')
    {
        $changeKeyArray[] = ['class' => 'yii\grid\SerialColumn'];
        foreach ($sheetData[0] as $key => $value) {
            $changeKeyArray[] = [
                'attribute' => $key,
                'label' => ucwords($value),
            ];
        }

        // Delete Last Array Attributes cause Its Result
        // $remove_last_array = array_pop($changeKeyArray);
        return $changeKeyArray;
    }

    public function getData($sheetData='')
    {
        // Memisahkan Nama Field pada baris 1 dengan Data pada baris selanjutnya;
        $data = array_splice($sheetData,1);
        return $data;
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

    public function actionDataset()
    {
        $model = Data::find()->where(['status'=>'1'])->one();
        $dataset = $this->loadCsv('/uploads/datasets/'.$model->file);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->getData($dataset),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => $this->getAttributeGridView($dataset),
            ],
        ]);
        // $rows = $provider->getModels();
        return $this->render('dataset', [
            'dataProvider' => $dataProvider,
            'attribute' => $this->getAttributeGridView($dataset),
        ]);
        // echo '<pre>';
        // print_r($dataset);
        // echo '</pre>';

    }

    public function actionTree()
    {
        $model = Data::find()->where(['status'=>'1'])->one();
        $sheetData = $this->loadCsv('/uploads/datasets/'.$model->file);
        // Nama Atribut data
        $attributes = $this->getAttribute($sheetData);
        $data = $this->dataType($sheetData,'string');
        

        $c45 = Yii::$app->c45;

        // Set data dan atribut
        $c45->setData($data)->setAttributes($attributes);
        // Hitung menggunakan data training
        $c45->hitung();
        // $a = ;
        print_r($c45->cetakHitung());

        // Uji Coba dengan menggunakan 1 data testing sebagai berikut:

        // $data_testing = ['rainy', '35', 'high', 'false','yes'];
        // $data_testing = ['s','m','n','s'];
        // $data_testing = ['rainy', 'hot', 'high', 'false'];
        // $data_testing = ["sunny", 'hot', 'high', 'false'];
        // $data_testing = ['27','B','50','12,8','110','80','Wanita','Boleh'];
        // $data_testing = ['27','B','50','12,8','110','80','Wanita'];
        // echo $c45->predictDataTesting($data_testing);
        // Luaran diatas akan menghasilkan jawaban Yes

        // Sedangkan untuk melihat rule yang dihasilkan dari data set yang telah diberikan ialah dengan menggunakan perintah sebagai berikut:
        // $rule = $c45->printRules();
        return $this->render('rule', [
            'rule' => $c45,
            // 'attribute' => $this->getAttributeGridView($dataset),
        ]);
    }

    public function actionHitungTree()
    {
        $model = Data::find()->where(['status'=>'1'])->one();
        $sheetData = $this->loadCsv('/uploads/datasets/'.$model->file);
        // Nama Atribut data
        $attributes = $this->getAttribute($sheetData);
        $data = $this->dataType($sheetData,'string');
        

        $c45 = Yii::$app->c45;

        // Set data dan atribut
        $c45->setData($data)->setAttributes($attributes);
        // Hitung menggunakan data training
        // $c45->hitung();
        $hitung_rule = $c45->cetakHitung();
        
        return $this->render('hitungan', [
            'hitung_rule' => $hitung_rule,
        ]);
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

    public function actionTesting($value='')
    {

        $model = Data::find()->where(['status'=>'1'])->one();
        $sheetData = $this->loadCsv('/uploads/datasets/'.$model->file);
        // Nama Atribut data
        $attributes = $this->getAttribute($sheetData);
        $data = $this->dataType($sheetData,'string');
        

        $formData = $this->formFields($data,$data[0]);
        

        if ($postData = Yii::$app->request->post()) {
            unset($postData['_csrf']);
            $c45 = Yii::$app->c45;
            // Set data dan atribut
            $c45->setData($data)->setAttributes($attributes);
            // Hitung menggunakan data training
            $c45->hitung();
            // $data = array_pop($dataString);
            $values = array_values($postData);
            $result = $c45->predictDataTesting($values);
            // echo '<pre>';
            // print_r($result);
            // echo '<br>';
            // print_r($postData);
            // echo '<br>';
            // print_r(array_values($postData));
            // echo '</pre>';
            return $this->render('testing',[
                'attributes' => $attributes,
                'dataList' => $formData,
                'result' => $result,
            ]);
        }else {
            return $this->render('testing',[
                'attributes' => $attributes,
                'dataList' => $formData,
                'result' => $result='',
            ]);
        }


        // echo '<pre>';
        // print_r($dataList);
        // echo '<br>';
        // print_r($attributes);
        // echo '<br>';
        // print_r($data);
        // echo '</pre>';
        

        
            
    }

}
