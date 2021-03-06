<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_list".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $def_role Лавозимнинг ҳуқуқи (Default role)
 *
 * @property Roles $defRole
 * @property EmpPosts[] $empPosts
 */
class PostList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['def_role'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['def_role'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['def_role' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Bo\'lim'),
            'def_role' => Yii::t('app', 'Huquqi'),
        ];
    }

    /**
     * Gets query for [[DefRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'def_role']);
    }

    /**
     * Gets query for [[EmpPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpPosts()
    {
        return $this->hasMany(EmpPosts::className(), ['post_id' => 'id']);
    }
}
