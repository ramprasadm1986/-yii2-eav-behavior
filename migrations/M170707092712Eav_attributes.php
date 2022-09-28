<?php

namespace ramprasadm1986\eav\migrations;

use yii\db\Migration;

class M170707092712Eav_attributes extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%eav_entity}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string()
        ]);

        $this->createTable('{{%eav_attributes}}', [
            'id' => $this->primaryKey(),
            'class_id' => $this->integer(),
            'attribute' => $this->string()
        ]);

        $this->createTable('{{%eav_values}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->text()
        ]);

        $this->addForeignKey('{{%attr_val}}', '{{%eav_values}}', ['attribute_id'], '{{%eav_attributes}}', ['id'], 'cascade', 'cascade');
        $this->addForeignKey('{{%ent_attr}}', '{{%eav_attributes}}', ['class_id'], '{{%eav_entity}}', ['id'], 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('{{%eav_values}}');
        $this->dropTable('{{%eav_attributes}}');
        $this->dropTable('{{%eav_entity}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170707092712Eav_attributes cannot be reverted.\n";

        return false;
    }
    */
}
