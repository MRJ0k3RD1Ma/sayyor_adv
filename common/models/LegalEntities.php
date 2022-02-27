<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "legal_entities".
 *
 * @property string $inn
 * @property string|null $name
 * @property integer $tshx_id
 * @property integer $contragent_id
 * @property string|null $soogu
 * @property string|null $director
 * @property string|null $address
 * @property int $soato_id
 * @property int $region
 * @property int $district
 * @property int|null $status_id
 *
 * @property Soato $soato
 */
class LegalEntities extends \yii\db\ActiveRecord
{
    public $region,$district;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'legal_entities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['inn'], 'required'],
            [['soato_id', 'status_id','region','tshx_id','district','contragent_id'], 'integer'],
            [['inn', 'name', 'soogu','director','address'], 'string', 'max' => 255],
            [['inn'], 'unique'],
            [['soato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Soato::className(), 'targetAttribute' => ['soato' => 'MHOBT_cod']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inn' => Yii::t('model.legal_entities', 'STIR(INN)'),
            'name' => Yii::t('model.legal_entities', 'Nomi'),
            'tshx_id' => Yii::t('model.legal_entities', 'TSHX'),
            'soogu' => Yii::t('model.legal_entities', 'Soogu'),
            'soato_id' => Yii::t('model.legal_entities', 'Soato'),
            'region' => Yii::t('model.legal_entities', 'Viloyat'),
            'district' => Yii::t('model.legal_entities', 'Tuman'),
            'status_id' => Yii::t('model.legal_entities', 'Status'),
            'director' => Yii::t('model.legal_entities', 'Direktor'),
            'contragent_id' => Yii::t('model.legal_entities', 'Kontragent'),
        ];
    }

    /**
     * Gets query for [[Soato]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSoato()
    {
        return $this->hasOne(Soato::className(), ['MHOBT_cod' => 'soato_id']);
    }
    public function getStatus(){
        return $this->hasOne(StateList::className(),['status_id'=>'id']);
    }
}
