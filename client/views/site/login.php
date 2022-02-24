<?php
use yii\widgets\ActiveForm;
$this->title = Yii::t('login',"Tizimga kirish");
/* @var $model \client\models\InnForm*/
/* @var $ind \common\models\Individuals*/
/* @var $legal \common\models\LegalEntities*/
?>

<div class="login-page">
    <div class="login">
        <div class="logos">
            <div class="img">
                <img src="/design/assets/images/vet.png" alt="img" style="float: right; width: 50px;" class="img-responsive">
            </div>
            <div class="text">
                <?= Yii::t('login','Hayvon kasalliklari tashhisi va oziq-ovqat xavfsizligiga oid laboratoriya tekshiruvlari Yagona elektron ma\'lumotlar bazasini yurishish tizimi (VIS-Sayyor)')?>
            </div>

        </div>
        <div class="login-form">
            <h3><?= Yii::t('login','Tizimga kirish')?></h3>
            <p><?= Yii::t('login','Boshqaruv tizimiga xush kelibsiz!')?></p>
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]); ?>
            <div class="form">
                <div class="input">

                    <?= $form->field($model, 'type')->radioList(['inn'=>'Yuridik shaxs','pnfl'=>'Jismoniy shaxs'],['autofocus' => true,'class'=>'']) ?>

                </div>
                <div class="all" style="display: none">


                    <div class="ind" style="display: none">

                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'passport')->textInput(['class'=>'','placeholder'=>Yii::t('login','Pasport seriya raqami')]) ?>
                        </div>

                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'pnfl')->textInput(['class'=>'','placeholder'=>Yii::t('login','JSH SHIR(PINFL)')]) ?>
                        </div>
                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'name')->textInput(['class'=>'','placeholder'=>Yii::t('login','Ism')]) ?>
                        </div>
                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'surname')->textInput(['class'=>'','placeholder'=>Yii::t('login','Familya')]) ?>
                        </div>
                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'middlename')->textInput(['class'=>'','placeholder'=>Yii::t('login','Otasining ismi')]) ?>
                        </div>

                        <div class="input">

                            <?= $form->field($ind, 'region')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionsView::find()->all(),'region_id','name_lot')) ?>
                        </div>

                        <div class="input">

                            <?= $form->field($ind, 'district')->dropDownList([]) ?>
                        </div>

                        <div class="input">

                            <?= $form->field($ind, 'soato_id')->dropDownList([]) ?>
                        </div>
                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($ind, 'adress')->textInput(['class'=>'','placeholder'=>Yii::t('login','Manzil')]) ?>
                        </div>
                    </div>


                    <div class="yur" style="display: none">

                        <div class="input">
                            <span class="fas fa-lock"></span>
                            <?= $form->field($legal, 'inn')->textInput(['class'=>'','placeholder'=>Yii::t('login','STIR(INN)')]) ?>
                        </div>

                    </div>

                    <a href="/site/">Login parol yordamida kirish</a>

                    <div class="sign">
                        <div>
                            <button class="btn btn-primary"><?= Yii::t('login','Kirish')?> </button>
                        </div>
                    </div>

                </div>


            </div>
            <?php ActiveForm::end()?>
        </div>
        <div class="logos">
            <div class="img">
                <img src="/design/assets/images/bank.jpg" alt="img" style="float: right; width: 50px;" class="img-responsive">
            </div>
            <div class="text"><?= Yii::t('login','Axborot tizimini yaratish Yevropa Ittifoqi tomonidan moliyalashtirilgan')?></div>

        </div>



    </div>


</div>


<style>
    .login::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .login {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        overflow-y: scroll;
    }
    .sign{
        display: flex;
        justify-content: flex-end;
    }
    .sign button{
        text-transform: capitalize;
    }
    .sign div{
        display: inline-block;
    }
    .login-form .form{
        width: 100%;
    }
    .login-form .form .input{
        width: 100%;
        position: relative;

    }
    .logos .text{
        font-size: 18px;
        color: black;
    }
    .login-form .form .input input{
        padding-left: 50px;
        font-size: .96rem;
        font-weight: 400;
        line-height: 1.25;
        color: #4e5154;
        background-color: transparent !important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 5px

    }
    .login-form .form .input input:focus{
        outline: none;
    }
    .login-form .form .input span{
        top: 50%;
        transform: translate(-50%, -50%);
        left: 30px;
        position: absolute;
        font-size: 20px;

    }
    .login-page{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: flex;
        height: 100vh;
        background: #cfd2e1;
        justify-content: center;
        background: url("/design/assets/images/background.jpg") no-repeat;
        background-size: cover;
    }
    .login{
        margin-top: 100px;
        width: 700px;

    }
    .logos{
        display: flex;
        align-items: center;
        margin-bottom: 50px;

    }
    .logos .img{
        width: 100px;
        margin-right: 20px;
    }
    .logos .img img{
        width: 100px !important;
        object-fit: cover;
    }
    .login-form{
        margin-bottom: 50px;
        padding: 20px;
        background: #fff;
        text-align: center;
    }

</style>


<?php
$getind = Yii::$app->urlManager->createUrl(['/site/getind']);
$url_district = Yii::$app->urlManager->createUrl(['/site/get-district']);
$url_qfi = Yii::$app->urlManager->createUrl(['/site/get-qfi']);
$this->registerJs("

    function setind(data){
        if(data == -1){
            alert('Pasport ma\'lumotlari topilmadi. Pasport ma\'lumotlaringizni qayta tekshirib ko\'ring.')
        }else{
            data = JSON.parse(data);
            $('#individuals-name').val(data.data.inf.name);
            $('#individuals-name').attr('disabled',true);
            $('#individuals-surname').val(data.data.inf.surname);
            $('#individuals-surname').attr('disabled',true);
            $('#individuals-middlename').val(data.data.inf.middlename);
            $('#individuals-middlename').attr('disabled',true);
            $('#individuals-adress').val(data.data.inf.adress);
            if(data.data.inf.soato_id!=-1){
                $('#individuals-region').val(data.data.inf.region_id).trigger('change');
                setInterval(function () {
                   if($('#individuals-district').val()){clearInterval();}
                   else{
                    $('#individuals-district').val(data.data.inf.district_id).trigger('change');
                   }
                }, 500);
                setInterval(function () {
                   if($('#individuals-soato_id').val()){clearInterval();}
                   else{
                    $('#individuals-soato_id').val(data.data.inf.soato_id);
                   }
                }, 500);
            }
        }
    }
    
    $('#individuals-region').change(function(){
        $.get('{$url_district}?id='+$('#individuals-region').val()).done(function(data){
            $('#individuals-district').empty();
            $('#individuals-district').append(data);
        })        
    });
    $('#individuals-district').change(function(){
        $.get('{$url_qfi}?id='+$('#individuals-district').val()+'&regid='+$('#individuals-region').val()).done(function(data){
            $('#individuals-soato_id').empty();
            $('#individuals-soato_id').append(data);
        })        
    });
    
    $('#individuals-passport').keyup(function(){
        if($('#individuals-passport').val().length == 9 && $('#individuals-pnfl').val().length == 14){
            $.get('{$getind}?passport='+$('#individuals-passport').val()+'&pnfl='+$('#individuals-pnfl').val()).done(function(data){
                setind(data);
            })
        }
    });
    
    $('#individuals-pnfl').keyup(function(){
        if($('#individuals-passport').val().length == 9 && $('#individuals-pnfl').val().length == 14){
            $.get('{$getind}?passport='+$('#individuals-passport').val()+'&pnfl='+$('#individuals-pnfl').val()).done(function(data){
                setind(data);
            })
        }
    });

    $('input[type=radio][name=\"InnForm[type]\"]').change(function(){
    
        $('.all').show();
        if($('input[type=radio][name=\"InnForm[type]\"]:checked').val() == 'inn'){
//        if(this.value == 'inn'){
            $('.ind').hide();
            $('.yur').show();
//            $('#innform-name').attr('placeholder','Tashkilot nomi')
        }else{
//            $('#innform-name').attr('placeholder','FIO')
            $('.yur').hide();
            $('.ind').show();
        }
    })
")
?>