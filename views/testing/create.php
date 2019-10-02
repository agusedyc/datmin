<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Testing */

$this->title = Yii::t('app', 'Data Cek Donor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cek Donor'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataList' => $dataList,
    ]) ?>

</div>
