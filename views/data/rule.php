<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tree');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a(Yii::t('app', 'Create Data'), ['create'], ['class' => 'btn btn-success']) ?> -->
        <code style="font-size: 18px">
    		<?php 
    			$rule->printRules();
    		?>
    	</code>
    </p>

    
    	
   

</div>
