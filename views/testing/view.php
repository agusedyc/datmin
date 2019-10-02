<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Testing */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cek Donor'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="testing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php 

        // echo '<pre>';
        // print_r($model->data_testing);
        // echo '</pre>';
     ?>
     <table class="table table-striped table-bordered detail-view">
         <!-- <caption>table title and/or explanatory text</caption> -->
     <?php 
     $datas = json_decode($model->data_testing);
     foreach ($datas as $key => $value): ?>
        <tr>
            <td><?php echo '<h5>'.ucwords(str_replace('_', ' ',$key)).'</h5>'; ?></td>
            <td>:</td>
            <td><?= $value ?></td>
        </tr> 
     <?php endforeach ?>
</table>

</div>
