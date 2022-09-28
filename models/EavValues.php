<?php

namespace ramprasadm1986\eav\models;

use Yii;

/**
 * This is the model class for table "eav_values".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $attribute_id
 * @property string $value
 *
 * @property EavAttributes $attribute
 */
class EavValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%eav_values}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'attribute_id'], 'integer'],
            [['value'], 'string'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => EavAttributes::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'attribute_id' => 'Attribute ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeName()
    {
        return $this->hasOne(EavAttributes::className(), ['id' => 'attribute_id']);
    }
}
