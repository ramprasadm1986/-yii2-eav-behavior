<?php

use yii\db\Migration;

class m220929_020902_update_table_eav_attributes extends Migration
{
    public function safeUp()
    {
       
        $this->addColumn('{{%eav_attributes}}', 'attribute_group', $this->string()->after('attribute'));
        $this->addColumn('{{%eav_attributes}}', 'attribute_type', $this->string()->after('attribute_group'));
        $this->addColumn('{{%eav_attributes}}', 'attribute_label', $this->string()->after('attribute_type'));
        $this->addColumn('{{%eav_attributes}}', 'attribute_options', $this->text()->after('attribute_label'));
        $this->addColumn('{{%eav_attributes}}', 'is_required', $this->tinyInteger(4)->defaultValue('0')->after('attribute_options'));
        $this->addColumn('{{%eav_attributes}}', 'min', $this->integer()->after('attribute_options'));
        $this->addColumn('{{%eav_attributes}}', 'max', $this->integer()->after('min'));  
        $this->addColumn('{{%eav_attributes}}', 'attribute_sub_group', $this->string()->after('attribute_group'));        
        $this->addColumn('{{%eav_attributes}}', 'group_attrib', $this->string()->after('attribute_sub_group'));        

        
    }

    public function safeDown()
    {
       

        $this->dropColumn('{{%eav_attributes}}', 'attribute_group');
        $this->dropColumn('{{%eav_attributes}}', 'attribute_sub_group');
        $this->dropColumn('{{%eav_attributes}}', 'group_attrib');
        $this->dropColumn('{{%eav_attributes}}', 'attribute_type');
        $this->dropColumn('{{%eav_attributes}}', 'attribute_label');
        $this->dropColumn('{{%eav_attributes}}', 'attribute_options');
        $this->dropColumn('{{%eav_attributes}}', 'min');
        $this->dropColumn('{{%eav_attributes}}', 'max');  
        $this->dropColumn('{{%eav_attributes}}', 'is_required');
        

    }
}
