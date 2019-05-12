<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dataset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a(Yii::t('app', 'Create Data'), ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php 
    	// echo '<pre>';
    	// print_r($attribute);
    	// echo '</pre>';
     ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $attribute,
        // 'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // '0',
            // [
            // 	'attribute' => '1',
            // 	'label' => 'Hum',
            // ],
            // 'id',
            // '',
            // 'file',
            // 'status',

            // ['class' => 'yii\grid\ActionColumn'],
        // ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
