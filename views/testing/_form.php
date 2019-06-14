<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Testing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testing-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    
        echo '<h5>'.ucwords(str_replace('_', ' ',$field='data_nama')).'</h5>';
        echo '<div class="form-group">';
        echo Html::textInput($field, '', ['class'=>'form-control']);
        echo '</div>';

        echo '<h5>'.ucwords(str_replace('_', ' ',$field='data_alamat')).'</h5>';
        echo '<div class="form-group">';
        echo Html::textInput($field, '', ['class'=>'form-control']);
        echo '</div>';

        echo '<h5>'.ucwords(str_replace('_', ' ',$field='data_telepon')).'</h5>';
        echo '<div class="form-group">';
        echo Html::textInput($field, '', ['class'=>'form-control']);
        echo '</div>';

        foreach ($dataList as $key => $value) {
            
            if (count($value)>=8) {
                $field = $value[0]['value'];
                echo '<h5>'.ucwords(str_replace('_', ' ',$field)).'</h5>';
                echo '<div class="form-group">';
                unset($value[0]);
                echo Html::textInput($field, '', ['class'=>'form-control']);
                echo '</div>';       

            }else{

                $field = $value[0]['value'];
                echo '<h5>'.ucwords(str_replace('_', ' ',$field)).'</h5>';
                echo '<div class="form-group">';
                unset($value[0]);
                echo Html::dropDownList($field,'',ArrayHelper::map($value,'value','value'),['prompt' => '--- Select ---','class'=>'form-control']);
                echo '</div>';
            }
            
        }

     ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Tampilkan Hasil'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
