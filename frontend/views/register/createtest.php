<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sertificates */
/* @var $ind common\models\Individuals */
/* @var $legal common\models\LegalEntities */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('test','Ariza qabul qilish');
?>

<div class="sertificates-form">
    <?php
    $lang = Yii::$app->language;
    $lan = 'uz';
    if($lang == 'ru'){
        $ads = 'ru';
        $lan = 'ru';
    }elseif($lang=='oz'){
        $ads = 'cyr';
    }else{
        $ads = 'lot';
    }
    ?>
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'sert_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'sert_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sert_date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vet_site_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\VetSites::find()->all(),'id','name')) ?>

    <?= $form->field($legal,'inn')->textInput()?>
    <?= $form->field($legal, 'contragent_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Contragent::find()->all(),'id','name_'.$lan),['prompt'=>Yii::t('test','Kontragent turi')])?>
    <?= $form->field($legal,'name')->textInput()?>
    <?= $form->field($legal,'director')->textInput()?>

    <?= $form->field($legal,'tshx_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Tshx::find()->all(),'id','name_'.$lan),['class'=>'form-control select2list'])?>

    <?= $form->field($legal,'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_'.$ads))?>
    <?= $form->field($legal,'district')->dropDownList([],['prompt'=>Yii::t('test','Tumanni tanlang')])?>
    <?= $form->field($legal,'soato_id')->dropDownList([],['prompt'=>Yii::t('test','QFYni tanlang')])?>
    <?= $form->field($legal,'address')->textInput()?>

    <?= $form->field($legal,'status_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\StateList::find()->all(),'id','name'))?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cp.sertificates', 'Saqlash'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$url_district = Yii::$app->urlManager->createUrl(['/register/get-district']);
$url_qfi = Yii::$app->urlManager->createUrl(['/register/get-qfi']);
$url_legal = Yii::$app->urlManager->createUrl(['/register/get-legal']);
$this->registerJs("
       $('#legalentities-inn').keyup(function(){
            if($('#legalentities-inn').val()[0] == '3' || $('#legalentities-inn').val()[0] == '2'){
                $('#legalentities-contragent_id').val(2);
            }else{
                $('#legalentities-contragent_id').val(1);
            }
            if($('#legalentities-inn').val().length == 9){
                $.get('{$url_legal}?inn='+$('#legalentities-inn').val()).done(function(data){
                    if(data != -1){
                        data = JSON.parse(data);
                        $('#legalentities-name').val(data.name);
                        $('#legalentities-contragent_id').val(data.contragent_id);
                        $('#legalentities-director').val(data.director);
                        $('#legalentities-tshx').val(data.passport).trigger('change');
                        $('#legalentities-address').val(data.address);
                        $('#legalentities-status_id').val(data.status_id);
                        
                        $('#legalentities-region').val(data.region).trigger('change');
                        setInterval(function () {
                           if($('#legalentities-district').val()){clearInterval();}
                           else{
                            $('#legalentities-district').val(data.district).trigger('change');
                           }
                        }, 500);
                        setInterval(function () {
                           if($('#legalentities-soato_id').val()){clearInterval();}
                           else{
                            $('#legalentities-soato_id').val(data.soato_id);
                           }
                        }, 500);
                    }else{
                        alert('Bunday STIR(INN) topilmadi');
                    }
                    
                    
                })
            }
       })
       
       $('#legalentities-region').change(function(){
            $.get('{$url_district}?id='+$('#legalentities-region').val()).done(function(data){
                $('#legalentities-district').empty();
                $('#legalentities-district').append(data);
            })
       });
       $('#legalentities-district').change(function(){
            $.get('{$url_qfi}?id='+$('#legalentities-district').val()+'&regid='+$('#legalentities-region').val()).done(function(data){
                $('#legalentities-soato_id').empty();
                $('#legalentities-soato_id').append(data);
            })
       })
      
       
    ")
?>