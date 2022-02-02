<?php

namespace frontend\controllers;

use common\models\DistrictView;
use common\models\Individuals;
use common\models\LegalEntities;
use common\models\QfiView;
use common\models\Sertificates;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * Site controller
 */
class RegisterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCreatetest(){
        $user = Yii::$app->user->identity;
        $org = $user->empPosts->org_id;
        $user_id = Yii::$app->user->getId();
        $code = substr(date('Y'),2,2).'-1-'.get3num($org).'-';
        $num = Sertificates::find()->where(['organization_id'=>$org])->max('sert_num');
        if($num==0){
            $num = 1;
        }
        $code .= $num;
        $model = new Sertificates();
        $model->sert_id = $code;
        $legal = new LegalEntities();
        $ind = new Individuals();
        $model->ownertype = 1;
        $model->organization_id = $org;
        $model->operator = $user_id;
        if($model->load(Yii::$app->request->post())){
            if($model->ownertype == 1 and $ind->load(Yii::$app->request->post())){
                if($ind->pnfl and $ind->name and $ind->surname and $ind->middlename and $ind->soato_id){
                    $ind->save();
                    $model->pnfl = $ind->pnfl;
                    $model->save();
                    Yii::$app->session->setFlash('success','Ma\'lumotlar bazaga muvoffaqiyatli yozildi');
                }else{
                    Yii::$app->session->setFlash('error',Yii::t('reg','Maydonlar to\'ldirilmagan'));
                }
            }
        }
        return $this->render('createtest',[
            'model'=>$model,
            'legal'=>$legal,
            'ind'=>$ind
        ]);
    }

    public function actionGetInd($pnfl){
        if($model = Individuals::findOne(['pnfl'=>$pnfl])){
            $res = "{
                \"code\":200,
                \"value\":{\"pnfl\":\"{$pnfl}\",
                    \"name\":\"{$model->name}\",
                    \"surname\":\"{$model->surname}\",
                    \"middlename\":\"{$model->middlename}\",
                    \"region_id\":\"{$model->soato->region_id}\",
                    \"district_id\":\"{$model->soato->district_id}\",
                    \"soato_id\":\"{$model->soato_id}\",
                    \"passport\":\"{$model->passport}\"
                }
            }";
        }else{
            $res = "{'code':404}";
        }
        echo $res;
        exit;
    }


    public function actionGetDistrict($id){
        $model = DistrictView::find()->where(['region_id'=>$id])->all();
        $text = Yii::t('cp.vetsites','- Tumanni tanlang -');
        $res = "<option value=''>{$text}</option>";
        $lang = Yii::$app->language;
        foreach ($model as $item){
            if($lang == 'ru'){
                $name = $item->name_ru;
            }elseif($lang == 'oz'){
                $name = $item->name_cyr;
            }else{
                $name = $item->name_lot;
            }
            $res .= "<option value='{$item->district_id}'>{$name}</option>";
        }
        echo $res;
        exit;
    }
    public function actionGetQfi($id,$regid){
        $model = QfiView::find()->where(['district_id'=>$id])->andWhere(['region_id'=>$regid])->all();
        $text = Yii::t('cp.vetsites','- QFYni tanlang -');
        $res = "<option value=''>{$text}</option>";
        $lang = Yii::$app->language;
        foreach ($model as $item){
            if($lang == 'ru'){
                $name = $item->name_ru;
            }elseif($lang == 'oz'){
                $name = $item->name_cyr;
            }else{
                $name = $item->name_lot;
            }
            $res .= "<option value='{$item->MHOBT_cod}'>{$name}</option>";
        }
        echo $res;
        exit;
    }
}
