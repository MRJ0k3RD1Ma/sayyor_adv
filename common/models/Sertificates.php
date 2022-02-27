<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sertificates".
 *
 * @property string $sert_id Тизимдаги далолатнома рақами (автоматик генерация қилинади: ХХ-1-ХХХ-ХХХХХ (йил-далолатнома тури-лаборатория коди-тартиб рақами, масалан: 22-1-001-00001 – 2022 йил-касаллик диагностикаси-республика лабораторияси-2022 йилдаги далолатнома тартиб раками)
 * @property string|null $sert_num Далолатнома рақами (коғоздаги ёки РЕГИСТОНдаги)
 * @property string|null $sert_date
 * @property int|null $organization_id Бу ерда асли стир бўлиши керак.
 * @property string $inn
 * @property string|null $owner_name
 * @property int|null $vet_site_id
 * @property int $ownertype
 *
 * @property Organizations $organization
 * @property LegalEntities $inn0
 * @property VetSites $vetSite
 */
class Sertificates extends \yii\db\ActiveRecord
{
    public $ownertype;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sertificates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sert_id'], 'required'],
            [['sert_date'], 'safe'],
            [['organization_id', 'vet_site_id', 'ownertype'], 'integer'],
            [['sert_id', 'sert_num'], 'string', 'max' => 100],
            [['owner_name','inn'], 'string', 'max' => 255],
            [['sert_id'], 'unique'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sert_id' => Yii::t('model.sertificates', 'Dalolatnoma'),
            'sert_num' => Yii::t('model.sertificates', 'Dalolatnoma raqami(Qog\'ozdagi yoki registondagi)'),
            'sert_date' => Yii::t('model.sertificates', 'Sana'),
            'organization_id' => Yii::t('model.sertificates', 'Tashkilot'),
            'owner_name' => Yii::t('model.sertificates', 'Egasi'),
            'vet_site_id' => Yii::t('model.sertificates', 'Vet uchstka'),
            'ownertype' => Yii::t('model.sertificates', 'Kontragent turi'),
            'inn' => Yii::t('model.sertificates', 'INN(STIR)'),
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'organization_id']);
    }


    /**
     * Gets query for [[VetSite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVetSite()
    {
        return $this->hasOne(VetSites::className(), ['id' => 'vet_site_id']);
    }
    public function getInn0(){
        return $this->hasOne(LegalEntities::className(),['inn'=>'inn']);
    }
}
