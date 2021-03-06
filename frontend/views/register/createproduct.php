<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FoodSamplingCertificate */
/* @var $form yii\widgets\ActiveForm */
/* @var $exp \common\models\ProductExpertise*/
/* @var $legal \common\models\LegalEntities*/
$this->title = Yii::t('test','Mahsulot ekspertizasi');
?>

    <div class="food-sampling-certificate-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'organization_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Organizations::find()->all(),'id','NAME_FULL'),['prompt'=>'Tashkilotni tanlang']) ?>

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

        <?php if($model->sampling_site){

            $model->region  = $model->samplingSite->soato0->region_id;
            $model->district = $model->samplingSite->soato0->district_id;

            ?>
            <?= $form->field($model, 'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_'.$ads),['prompt'=>Yii::t('cp.vetsites','Viloyatni tanlang')]) ?>

            <?= $form->field($model, 'district')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\DistrictView::find()->where(['region_id'=>$model->samplingSite->soato0->region_id])->all(),'district_id','name_'.$ads),['prompt'=>Yii::t('cp.vetsites','Tumanni tanlang')]) ?>
            <?= $form->field($model, 'soato')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\QfiView::find()->where(['district_id'=>$model->samplingSite->soato0->district_id])->andWhere(['region_id'=>$model->samplingSite->soato0->region_id])->all(),'MHOBT_cod','name_'.$ads),['prompt'=>Yii::t('cp.vetsites','QFYni tanlang')]) ?>
            <?= $form->field($model, 'sampling_site')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\VetSites::find()->where(['soato'=>$model->samplingSite->soato0->qfi_id])->all(),'id','name'),['prompt'=>Yii::t('cp.vetsites','Vet uchstkani tanlang')]) ?>

        <?php }else{ ?>
            <?= $form->field($model, 'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_'.$ads),['prompt'=>Yii::t('cp.vetsites','Viloyatni tanlang')]) ?>

            <?= $form->field($model, 'district')->dropDownList([],['prompt'=>Yii::t('cp.vetsites','Tumanni tanlang')]) ?>
            <?= $form->field($model, 'soato')->dropDownList([],['prompt'=>Yii::t('cp.vetsites','QFYni tanlang')]) ?>
            <?= $form->field($model, 'sampling_site')->dropDownList([],['prompt'=>Yii::t('cp.vetsites','Vet uchstkani tanlang')]) ?>

        <?php }?>

        <?= $form->field($model, 'sampling_adress')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sampler_organization_code')->textInput() ?>

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


        <?= $form->field($model, 'unit_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Units::find()->all(),'id','name_uz'),['prompt'=>'Birlikni tanlang']) ?>

        <?= $form->field($model, 'count')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'verification_sample')->dropDownList([1=>'Ha',0=>'Yo\'q']) ?>

        <?= $form->field($model, 'producer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'serial_num')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'manufacture_date')->textInput(['type'=>'date']) ?>

        <?= $form->field($model, 'sell_by')->textInput(['type'=>'date']) ?>

        <?= $form->field($model, 'coments')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'verification_pupose_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\VerificationPurposes::find()->all(),'id','name_uz'),['prompt'=>'Tekshirishdan maqsadni tanlang']) ?>

        <?= $form->field($model, 'sample_box_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\SampleBoxes::find()->all(),'id','name_uz'),['prompt'=>'Namuna o\'ramini tanlang']) ?>

        <?= $form->field($model, 'sample_condition_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\SampleConditions::find()->all(),'id','name_uz'),['prompt'=>'Namuna holati']) ?>

        <?= $form->field($model, 'sampling_date')->textInput(['type'=>'date']) ?>

        <?= $form->field($model, 'send_sample_date')->textInput(['type'=>'date']) ?>

        <?= $form->field($model, 'explanations')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'based_public_information')->dropDownList([0=>'Yo\'q',1=>'Ha']) ?>

        <?= $form->field($model, 'message_number')->textInput() ?>

        <?= $form->field($model, 'laboratory_test_type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\LaboratoryTestType::find()->all(),'id','name_uz'),['prompt'=>'Laboratoriya tadqiqot turini tanlang']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('cp.food_sampling_certificate', 'Saqlash'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$url_district = Yii::$app->urlManager->createUrl(['/register/get-district']);
$url_qfi = Yii::$app->urlManager->createUrl(['/register/get-qfi']);
$url_vetsites = Yii::$app->urlManager->createUrl(['/register/get-vetsites']);
$this->registerJs("
        $('#foodsamplingcertificate-region').change(function(){
            $.get('{$url_district}?id='+$('#foodsamplingcertificate-region').val()).done(function(data){
                $('#foodsamplingcertificate-district').empty();
                $('#foodsamplingcertificate-district').append(data);
            })        
        })
        $('#foodsamplingcertificate-district').change(function(){
            $.get('{$url_qfi}?id='+$('#foodsamplingcertificate-district').val()+'&regid='+$('#foodsamplingcertificate-region').val()).done(function(data){
                $('#foodsamplingcertificate-soato').empty();
                $('#foodsamplingcertificate-soato').append(data);
            })        
        })
        
         $('#foodsamplingcertificate-soato').change(function(){
            $.get('{$url_vetsites}?id='+$('#foodsamplingcertificate-soato').val()).done(function(data){
                $('#foodsamplingcertificate-sampling_site').empty();
                $('#foodsamplingcertificate-sampling_site').append(data);
            })        
        })
    ");


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