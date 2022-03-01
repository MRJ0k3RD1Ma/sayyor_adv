<?php

namespace frontend\controllers;

use common\models\Animals;
use common\models\DistrictView;
use common\models\Emlash;
use common\models\Individuals;
use common\models\LegalEntities;
use common\models\Organizations;
use common\models\QfiView;
use common\models\Samples;
use common\models\Sertificates;
use common\models\Vaccination;
use frontend\models\search\registr\SertificatesSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\web\NotFoundHttpException;

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
        }else{
            $num = $num+1;
        }
        $code .= $num;
        $model = new Sertificates();
        $model->sert_id = $code;
        $legal = new LegalEntities();
        $ind = new Individuals();
        $model->organization_id = $org;

        if($model->load(Yii::$app->request->post())){
            $model->sert_id = "$num";
            if($legal->load(Yii::$app->request->post())){
                if($l = LegalEntities::findOne($legal->inn)){
                    $legal = $l;
                }else{
                    if(!$legal->save()){
                        Yii::$app->session->set('error',Yii::t('test','Ma\'lumotlarni to\'dirishda xatolik'));
                        return $this->render('createtest',[
                            'model'=>$model,
                            'legal'=>$legal,
                            'ind'=>$ind
                        ]);
                    }
                }
                $model->inn = $legal->inn;
                if($model->save()){
                    Yii::$app->session->set('success',Yii::t('test','Muvoffaqiyatli saqlandi'));
                    return $this->redirect(['viewtest','id'=>$model->id]);
                }else{
                    Yii::$app->session->set('error',Yii::t('test','Ma\'lumotlarni to\'dirishda xatolik'));
                    return $this->render('createtest',[
                        'model'=>$model,
                        'legal'=>$legal,
                        'ind'=>$ind
                    ]);
                }
            }

        }
        $model->sert_id = $code;
        return $this->render('createtest',[
            'model'=>$model,
            'legal'=>$legal,
            'ind'=>$ind
        ]);
    }


    public function actionViewtest($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAdd($id){
        $model = $this->findModel($id);

        $animal = new Animals();

        $sample = new Samples();
        $animal->inn = $model->inn;

        $sample->animal_id = -1;
        $sample->sert_id = intval($id);
        if(Yii::$app->request->isPost){

            if($animal->load(Yii::$app->request->post())){
                $animal->inn = "{$animal->inn}";
                if($animal->save()){}
                if($sample->load(Yii::$app->request->post())){
                    $sample->animal_id = $animal->id;
                    $sample->sert_id = intval($id);
                    if($sample->save(false)){
                        return $this->redirect(['viewtest','id'=>$id]);
                    }
                }
            }

        }

        return $this->render('add',[
            'model'=>$model,
            'animal'=>$animal,
            'sample'=>$sample
        ]);
    }
    protected function findModel($id)
    {
        if (($model = Sertificates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cp.sertificates', 'The requested page does not exist.'));
    }
    public function actionVaccination($id,$sert_id){

        $model = new Vaccination();
        $model->animal_id = $id;
        $animal = Animals::findOne($id);
        if($model->load(Yii::$app->request->post()) and $model->save()){
            return $this->redirect(['viewtest','id'=>$sert_id]);
        }
        return $this->render('vaccination',['model'=>$model,'animal'=>$animal]);
    }

    public function actionEmlash($id,$sert_id){

        $model = new Emlash();
        $model->animal_id = $id;
        $animal = Animals::findOne($id);
        if($model->load(Yii::$app->request->post()) and $model->save()){
            return $this->redirect(['viewtest','id'=>$sert_id]);
        }
        return $this->render('emlash',['model'=>$model,'animal'=>$animal]);

    }


    public function actionIndextest(){
        $searchModel = new SertificatesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('indextest', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

    public function actionGetLegal($inn){
        if($model = LegalEntities::findOne(['inn'=>$inn])){
            return json_encode([
                'inn'=>$model->inn,
                'contragent_id'=>$model->contragent_id,
                'name'=>$model->name,
                'director'=>$model->director,
                'tshx'=>$model->tshx_id,
                'region'=>$model->soato->region_id,
                'district'=>$model->soato->district_id,
                'soato_id'=>$model->soato_id,
                'address'=>$model->address,
                'status_id'=>$model->status_id
            ]);
        }else{
            return -1;
        }
    }

    public function actionGetbirka($id){
        if($model = Animals::findOne(['bsual_tag'=>$id])){
            return json_encode([
                'code'=>['result'=>'2200'],
                'data'=>[
                    'id'=>$model->id,
                    'birth'=>$model->birthday,
                    'tin'=>$model->inn,
                    'type'=>$model->type_id,
                    'sex'=>$model->gender,
                    'address'=>$model->adress,
                    'owner'=>$model->name,
                ]
            ]);
        }else{
            return get_web_page(Yii::$app->params['hamsa']['url']['getanimalinfo'].'?birka='.$id,'hamsa');
        }
    }

}
