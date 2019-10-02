<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TestingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cek Donor');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testing-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Cek Sekarang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'data_testing:ntext',
             [
                'attribute'=>'data_testing',
                'label'=>'Data Pasien',
                'format'=> 'raw',
                'value' => function($data){
                    $formData = json_decode($data->data_testing);
                    $no=1;
                    foreach ($formData as $key => $value) {
                        $var[] = "(".$no++."). ".ucwords(str_replace('_', ' ',$key))." : ". $value."<br>";
                    }
                    // $format = $formData->data_nama." - ".$formData->data_nama;
                    $format = join(" ",$var);
                    return Html::a($format,['testing/view','id'=>$data->id]);

                }
            ],

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' 
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
