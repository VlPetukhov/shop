<?php

use yii\db\Schema;
use yii\db\Migration;

class m150531_160957_ctalog_item_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_item}}',
            [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . '(60) NOT NULL COMMENT "catalog item name"',
                'list_position' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "catalog item position(over items level)"',
                'parent_id' => Schema::TYPE_INTEGER . ' COMMENT "catalog item parent (NULL if it belongs to root\'s elements)"',
                'active' => Schema::TYPE_BOOLEAN . ' DEFAULT true COMMENT "show/hide catalog item"',
                'deleted' => Schema::TYPE_BOOLEAN . ' DEFAULT false COMMENT "\'item is deleted\' flag"',
                'delete_date' => Schema::TYPE_TIMESTAMP . ' COMMENT "Item\'s deleting date(it will be used for garbage collection)"'
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%catalog_item}}');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
