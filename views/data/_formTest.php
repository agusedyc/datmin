<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Data */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php 
    
            // echo '<pre>';
            // print_r($dataList);
            // echo '</pre>';

        foreach ($dataList as $key => $value) {
            
            if (count($value)>=8) {
                $field = $value[0]['value'];
                echo '<h5>'.ucwords(str_replace('_', ' ',$field)).'</h5>';
                echo '<div class="form-group">';
                unset($value[0]);
                echo Html::textInput($field, '', ['class'=>'form-control']);
                echo '</div>';       

            }else{
                // echo '<pre>';
                // print_r($value);
                // echo '</pre>'; 
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
        <?= Html::submitButton(Yii::t('app', 'Hasil'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php 

        if (isset($result)) {
            echo $result;
        }

     ?>

</div>
