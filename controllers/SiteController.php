<?php
// Sumber http://rofilde.web.id/post/84
namespace app\controllers;

use C45\C45;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $dataXA  = [
            ["outlook", "temperature", "humadity", "windy","res"],
            ["sunny", 'hot', 'high', 'false', 'no'],
            ["sunny", 'hot', 'high', 'true', 'no'],
            ["cloudy", 'hot', 'high', 'false', 'yes'],
            ["rainy", 'mild', 'high', 'false', 'yes'],
            ["rainy", 'cool', 'normal', 'false', 'yes'],
            ["rainy", 'cool', 'normal', 'true', 'yes'],
            ["cloudy", 'cool', 'normal', 'true', 'yes'],
            ["sunny", 'mild', 'high', 'false', 'no'],
            ["sunny", 'cool', 'normal', 'false', 'yes'],
            ["rainy", 'mild', 'normal', 'false', 'yes'],
            ["sunny", 'mild', 'normal', 'true', 'yes'],
            ["cloudy", 'mild', 'high', 'true', 'yes'],
            ["cloudy", 'hot', 'normal', 'false', 'yes'],
            ["rainy", 'mild', 'high', 'true', 'no'],

        ];

        $dataX  = [
            ["sunny", 'hot', 'high', 'false', 'no'],
            ["sunny", 'hot', 'high', 'true', 'no'],
            ["cloudy", 'hot', 'high', 'false', 'yes'],
            ["rainy", 'mild', 'high', 'false', 'yes'],
            ["rainy", 'cool', 'normal', 'false', 'yes'],
            ["rainy", 'cool', 'normal', 'true', 'yes'],
            ["cloudy", 'cool', 'normal', 'true', 'yes'],
            ["sunny", 'mild', 'high', 'false', 'no'],
            ["sunny", 'cool', 'normal', 'false', 'yes'],
            ["rainy", 'mild', 'normal', 'false', 'yes'],
            ["sunny", 'mild', 'normal', 'true', 'yes'],
            ["cloudy", 'mild', 'high', 'true', 'yes'],
            ["cloudy", 'hot', 'normal', 'false', 'yes'],
            ["rainy", 'mild', 'high', 'true', 'no'],

        ];

        $data  = [
            ["sunny", '30', 'high', 'false', 'no'],
            ["sunny", '35', 'high', 'true', 'no'],
            ["cloudy", '40', 'high', 'false', 'yes'],
            ["rainy", '25', 'high', 'false', 'yes'],
            ["rainy", '20', 'normal', 'false', 'yes'],
            ["rainy", '22', 'normal', 'true', 'yes'],
            ["cloudy", '15', 'normal', 'true', 'yes'],
            ["sunny", '26', 'high', 'false', 'no'],
            ["sunny", '26', 'normal', 'false', 'yes'],
            ["rainy", '20', 'normal', 'false', 'yes'],
            ["sunny", '25', 'normal', 'true', 'yes'],
            ["cloudy", '30', 'high', 'true', 'yes'],
            ["cloudy", '40', 'normal', 'false', 'yes'],
            ["rainy", '24', 'high', 'true', 'no'],

        ];

        
        // $sheetData = $this->loadCsv('/uploads/datasets/data_donor_darah_tensi.csv');
        $sheetData = $dataXA;
        // Nama Atribut data
        // $attributes = [1 => "outlook", 2 => "temperature", 3 => "humadity", 4 => 'windy'];
        $attributes = $this->getAttribute($sheetData);
        // $datacsv = $this->getData($sheetData);
        // $data = $this->getData($sheetData);
        $data = $this->dataType($sheetData,'string');
        

        $c45 = Yii::$app->c45;

        // Set data dan atribut
        $c45->setData($data)->setAttributes($attributes);
        // Hitung menggunakan data training
        $c45->hitung();

        // Uji Coba dengan menggunakan 1 data testing sebagai berikut:

        // $data_testing = ['rainy', '35', 'high', 'false','yes'];
        $data_testing = ['rainy', 'hot', 'high', 'false'];
        // $data_testing = ['27','B','50','12,8','110','80','Wanita','Boleh'];
        // $data_testing = ['27','B','50','12,8','110','80','Wanita'];
        echo $c45->predictDataTesting($data_testing);
        // Luaran diatas akan menghasilkan jawaban Yes

        // Sedangkan untuk melihat rule yang dihasilkan dari data set yang telah diberikan ialah dengan menggunakan perintah sebagai berikut:
        $c45->printRules();

        // echo '<pre>';
        // print_r($attributes);
        // echo '<br>';
        // print_r(var_dump($dataType));
        // echo '</pre>';




        // $model = new ContactForm();
        // if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        //     Yii::$app->session->setFlash('contactFormSubmitted');

        //     return $this->refresh();
        // }
        // return $this->render('contact', [
        //     'model' => $model,
        // ]);
    }

    function loadCsv($pathCsv='')
    {
        $inputFileName = Yii::$app->basePath.$pathCsv;
        $inputFileType = IOFactory::identify($inputFileName);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet = $reader->load($inputFileName);     
        return $sheetData = $spreadsheet->getActiveSheet()->toArray();
    }

    function getAttribute($sheetData='')
    {
        foreach ($sheetData[0] as $key => $value) {
            $changeKeyArray[$key+1] = $value;
        }
        // Delete Last Array Attributes cause Its Result
        $remove_last_array = array_pop($changeKeyArray);
        return $changeKeyArray;
    }

    function getData($sheetData='')
    {
        // Memisahkan Nama Field pada baris 1 dengan Data pada baris selanjutnya;
        $data = array_splice($sheetData,1);
        return $data;
    }

    function dataType($dataset='',$typeData='')
    {
        foreach ($dataset as $key => $value) {
            $dataType[] = $this->setTipe($value,$typeData);
        }   

        return $dataType;
    }

    function setTipe($arr='',$typeData='')
    {
        for ($i = 0; $i < count($arr); $i++) {
            settype($arr[$i], $typeData);
        }

        return $arr;
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {

        $inputFileName = Yii::$app->basePath.'/uploads/datasets/data_donor_darah_2.csv';
        $inputFileType = IOFactory::identify($inputFileName);

        /** Load $inputFileName to a Spreadsheet Object  **/
        // $reader = IOFactory::createReader($inputFileType);
        // $spreadsheet = $reader->load($inputFileName);
        // $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
 
        $spreadsheet = $reader->load($inputFileName);
     
        $sheetData = $spreadsheet->getActiveSheet()->toArray();



        // return $this->render('about');
        // $filename = Yii::$app->basePath.'/uploads/datasets/whether.csv';
        $c45 = new C45([
                'targetAttribute' => 'play',
                'trainingFile' => $filename,
                'splitCriterion' => C45::SPLIT_GAIN,
            ]);

        // $tree = $c45->buildTree();
        // $treeString = $tree->toString();

        
        // print generated tree

        foreach ($sheetData[0] as $key => $value) {
            $changeKeyArray[ $key+1] = $value;
        }

        echo '<pre>';
        echo 'Title';
        // print_r();
        print_r($changeKeyArray);
        echo '<br>';
        echo 'Data';
        print_r(array_splice($sheetData,1));
        echo '</pre>';
    }
}
