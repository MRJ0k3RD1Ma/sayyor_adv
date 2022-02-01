<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sertificates */
/* @var $ind common\models\Individuals */
/* @var $legal common\models\LegalEntities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sertificates-form">
    <?php
    $lang = Yii::$app->language;
    if($lang == 'ru'){
        $ads = 'ru';
    }elseif($lang=='oz'){
        $ads = 'cyr';
    }else{
        $ads = 'lot';
    }
    ?>
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'sert_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sert_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sert_date')->textInput(['type'=>'date']) ?>


    <?= $form->field($model, 'ownertype')->radioList([1=>Yii::t('reg','Jismoniy shaxs'),2=>Yii::t('reg','Yuridik shaxs')]) ?>

    <div class="indiv">
        <?= $form->field($ind, 'pnfl')->textInput(['maxlength' => true]) ?>

        <?= $form->field($ind, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($ind, 'surname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($ind, 'middlename')->textInput(['maxlength' => true]) ?>

        <?php if($ind->soato_id){
            $ind->region  = $ind->soato->region_id;
            $ind->district = $ind->soato->district_id;
            ?>
            <?= $form->field($ind, 'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_'.$ads),['prompt'=>Yii::t('cp.individuals','Viloyatni tanlang')]) ?>

            <?= $form->field($ind, 'district')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\DistrictView::find()->where(['region_id'=>$ind->soato->region_id])->all(),'district_id','name_'.$ads),['prompt'=>Yii::t('cp.individuals','Tumanni tanlang')]) ?>
            <?= $form->field($ind, 'soato_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\QfiView::find()->where(['district_id'=>$ind->soato->district_id])->all(),'MHOBT_cod','name_'.$ads),['prompt'=>Yii::t('cp.individuals','QFYni tanlang')]) ?>
        <?php }else{ ?>
            <?= $form->field($ind, 'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_'.$ads),['prompt'=>Yii::t('cp.individuals','Viloyatni tanlang')]) ?>

            <?= $form->field($ind, 'district')->dropDownList([],['prompt'=>Yii::t('cp.individuals','Tumanni tanlang')]) ?>
            <?= $form->field($ind, 'soato_id')->dropDownList([],['prompt'=>Yii::t('cp.individuals','QFYni tanlang')]) ?>
        <?php }?>

        <?= $form->field($ind, 'adress')->textInput(['maxlength' => true]) ?>

        <?= $form->field($ind, 'passport')->textInput(['maxlength' => true]) ?>

    </div>
    <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vet_site_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\VetSites::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'operator')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Employees::find()->all(),'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cp.sertificates', 'Saqlash'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$url_district = Yii::$app->urlManager->createUrl(['/register/get-district']);
$url_qfi = Yii::$app->urlManager->createUrl(['/register/get-qfi']);
$this->registerJs("
        $('#individuals-region').change(function(){
            $.get('{$url_district}?id='+$('#individuals-region').val()).done(function(data){
                $('#individuals-district').empty();
                $('#individuals-district').append(data);
            })        
        })
        $('#individuals-district').change(function(){
            alert('asdas');
            $.get('{$url_qfi}?id='+$('#individuals-district').val()+'&regid='+$('#individuals-region')).done(function(data){
                $('#individuals-soato').empty();
                $('#individuals-soato').append(data);
            })        
        })
    ")
?>