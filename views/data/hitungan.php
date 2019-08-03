<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Perhitungan C45');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a(Yii::t('app', 'Create Data'), ['create'], ['class' => 'btn btn-success']) ?> -->
        <code style="font-size: 18px">
    		<?php 
    			foreach ($hitung_rule as $value) {
    				echo $value;
    			}
    		?>
    	</code>
    </p>

    
    	
   

</div>
