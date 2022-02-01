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
        if($model->load(Yii::$app->request->post())){
            echo "<pre>";
            var_dump($model);
            exit;
        }
        return $this->render('createtest',[
            'model'=>$model,
            'legal'=>$legal,
            'ind'=>$ind
        ]);
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
        $model = QfiView::find()->where(['district_id'=>$id,'region_id'=>$regid])->all();
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
