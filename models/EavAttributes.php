<?php

namespace ramprasadm1986\eav\models;

use Yii;

/**
 * This is the model class for table "eav_attributes".
 *
 * @property int $id
 * @property int|null $class_id
 * @property string|null $attribute
 * @property string|null $attribute_group
 * @property string|null $attribute_sub_group
 * @property string|null $group_attrib
 * @property string|null $attribute_type
 * @property string|null $attribute_label
 * @property string|null $attribute_options
 * @property int|null $min
 * @property int|null $max
 * @property int|null $is_required
 *
 * @property EavEntity $class
 * @property EavValue[] $eavValues
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
            [['class_id', 'min', 'max', 'is_required'], 'integer'],
            [['attribute_options'], 'string'],
            [['attribute', 'attribute_group', 'attribute_sub_group', 'group_attrib', 'attribute_type', 'attribute_label'], 'string', 'max' => 255],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => EavEntity::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'class_id' => Yii::t('app', 'Class ID'),
            'attribute' => Yii::t('app', 'Attribute'),
            'attribute_group' => Yii::t('app', 'Attribute Group'),
            'attribute_sub_group' => Yii::t('app', 'Attribute Sub Group'),
            'group_attrib'=> Yii::t('app', 'Attribute View Group'),
            'attribute_type' => Yii::t('app', 'Attribute Type'),
            'attribute_label' => Yii::t('app', 'Attribute Label'),
            'attribute_options' => Yii::t('app', 'Attribute Options'),
            'min' => Yii::t('app', 'Min'),
            'max' => Yii::t('app', 'Max'),
            'is_required' => Yii::t('app', 'Is Required'),
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
