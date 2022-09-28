<?php

namespace ramprasadm1986\eav\models;

use Yii;

/**
 * This is the model class for table "eav_attributes".
 *
 * @property integer $id
 * @property integer $class_id
 * @property string $attribute
 *
 * @property EavEntity $class
 * @property EavValues[] $eavValues
 */
class EavAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%eav_attributes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id'], 'integer'],
            [['attribute'], 'string', 'max' => 255],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => EavEntity::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'attribute' => 'Attribute',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(EavEntity::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavValues()
    {
        return $this->hasMany(EavValues::className(), ['attribute_id' => 'id']);
    }
}
