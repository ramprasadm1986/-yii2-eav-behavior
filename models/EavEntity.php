<?php

namespace ramprasadm1986\eav\models;

use Yii;

/**
 * This is the model class for table "eav_entity".
 *
 * @property integer $id
 * @property string $class
 *
 * @property EavAttributes[] $eavAttributes
 */
class EavEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%eav_entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class' => 'Class',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavAttributes()
    {
        return $this->hasMany(EavAttributes::className(), ['class_id' => 'id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavAttributesWithCondition($condition)
    {
        return $this->hasMany(EavAttributes::className(), ['class_id' => 'id'])->andOnCondition($condition);;
    }
}
