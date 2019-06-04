<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Data */

$this->title = Yii::t('app', 'Testing Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testng'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formTest', [
        'attributes' => $attributes,
        'dataList' => $dataList,
        'result' => $result,
    ]) ?>

</div>
