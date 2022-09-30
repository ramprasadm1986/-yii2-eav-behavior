<?php

namespace ramprasadm1986\eav\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use ramprasadm1986\eav\models\EavEntity;
use ramprasadm1986\eav\models\EavAttributes;
use ramprasadm1986\eav\models\EavValues;

class EavBehavior extends AttributeBehavior
{

    protected $_values;
    public $model_id = 'id';
    public $_classname;
    private $_entity;
    private $_attributesObjList;
    private $_attributes;
    public $_attributesLabels =[];
    
    public function init(){
     
        $entity = EavEntity::find()->where(['class' => $this->_classname])->one();
        if(!$entity){
            $entity = new EavEntity();
            $entity->class = $this->_classname;
            $entity->save();
        }
        $this->_attributesObjList = $entity->getEavAttributes()->all();
    }
    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'eavAfterFind',
            ActiveRecord::EVENT_INIT => 'eavInit',
            ActiveRecord::EVENT_AFTER_INSERT => 'eavAfterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'eavAfterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'eavAfterDelete'
        ];
    }
    
    public function eavInit() {
        $this->_entity = EavEntity::find()->where(['class' => $this->_classname])->one(); 
        $this->_attributesObjList = $this->_entity->getEavAttributes()->all();
        foreach ($this->_attributesObjList as $attribute){
            $this->_attributes[]=$attribute->attribute;
            $this->_attributesLabels[$attribute->attribute]=$attribute->attribute_label;
            if(in_array($attribute->attribute_type,['number','int','integer','float','decimal','numeric','double']))
                $this->_values[$attribute->attribute] = 0;
            else
                $this->_values[$attribute->attribute] = null;
            
            if(get_class($this->owner)===$this->_classname){
                if($attribute->is_required)
                $this->owner->addRule([$attribute->attribute],'required');
            }
            
        }
        
    }
    
    public function EavAttributeLabels(){
        return $this->_attributesLabels;
    }
   
    public function canGetProperty($name, $checkVars = true) {
        return in_array($name, $this->_attributes);
    }

    public function canSetProperty($name, $checkVars = true) {
        return in_array($name, $this->_attributes);
    }
    public function eavAfterFind(){
        if($this->_entity) {
            $attributes = $this->_entity->getEavAttributes()->all();
            foreach ($attributes as $attribute) {
                $value = EavValues::find()->where(['attribute_id' => $attribute->id, 'model_id' => $this->owner->{$this->model_id}])->one();
                $this->_values[$attribute->attribute] = $value?$value->value:'';
            }
        }
    }

    public function __get($name) {
        if(array_key_exists($name, $this->_values)){
            return $this->_values[$name]    ;
        }
    }

    public function __set($name, $value) {
        if(array_key_exists($name, $this->_values)){
            $this->_values[$name] = $value;
        }
    }

    public function eavAfterInsert(){
        $entity = $this->_entity;
        if(!$entity){
            $entity = new EavEntity();
            $entity->class = $this->_classname;
            $entity->save();
        }

        foreach ($this->_attributes as $attribute){
            $attr_model = EavAttributes::find()->where(['class_id' => $entity->id, 'attribute' => $attribute])->one();
            if(!$attr_model){
                $attr_model = new EavAttributes();
                $attr_model->class_id = $entity->id;
                $attr_model->attribute = $attribute;
                $attr_model->save();
            }

            $val_model = EavValues::find()->where(['attribute_id' => $attr_model->id, 'model_id' => $this->owner->{$this->model_id}])->one();
            if(!$val_model){
                $val_model = new EavValues();
                $val_model->model_id = $this->owner->{$this->model_id};
                $val_model->attribute_id = $attr_model->id;
            }
            $val_model->value = $this->owner->$attribute;
            $val_model->save();
        }

    }

    public function eavAfterDelete(){
        foreach ($this->_attributes as $attribute){
            $attr_model = EavAttributes::find()->where(['class_id' => $this->_entity->id, 'attribute' => $attribute])->one();
            if($attr_model){
                $val_model = EavValues::find()->where(['attribute_id' => $attr_model->id, 'model_id' => $this->owner->{$this->model_id}])->one();
                if($val_model){
                    $val_model->delete();
                }
            }
        }
    }
    
    public function AllEavAttributes($condition=[],$group=[],$order=[]){
        
        return $this->_entity->getEavAttributesWithCondition($condition,$group,$order)->all();
    }

}