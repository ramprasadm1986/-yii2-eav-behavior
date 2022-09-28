<?php
use yii\db\Migration;

/**
 * Class m220928_140224_eav_behavior
 */
class m220928_140224_eav_behavior extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%eav_entity}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string()
        ],$tableOptions);

        $this->createTable('{{%eav_attributes}}', [
            'id' => $this->primaryKey(),
            'class_id' => $this->integer(),
            'attribute' => $this->string()
        ],$tableOptions);

        $this->createTable('{{%eav_values}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->text()
        ],$tableOptions);

        $this->addForeignKey('{{%attr_val}}', '{{%eav_values}}', ['attribute_id'], '{{%eav_attributes}}', ['id'], 'cascade', 'cascade');
        $this->addForeignKey('{{%ent_attr}}', '{{%eav_attributes}}', ['class_id'], '{{%eav_entity}}', ['id'], 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
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
        echo "m220928_140224_eav_behavior cannot be reverted.\n";

        return false;
    }
    */
}
