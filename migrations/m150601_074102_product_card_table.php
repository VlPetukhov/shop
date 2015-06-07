<?php

use yii\db\Schema;
use yii\db\Migration;

class m150601_074102_product_card_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%product_card}}',
            [
                'id' => Schema::TYPE_PK,
                'catalog_id' =>Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Shop category ID(0-unassigned)"',
                'header' => Schema::TYPE_STRING . ' NOT NULL COMMENT "Product header. It will be shown in shop catalogue."',
                'main_photo' => Schema::TYPE_STRING . '(8) NOT NULL COMMENT "Product\'s main photo filename (8 chars)."',
                'max_price' => Schema::TYPE_DECIMAL . '(9,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT "Sub-product\'s max price multiplied by 1000"',
                'min_price' => Schema::TYPE_DECIMAL . '(9,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT "Sub-product\'s min price multiplied by 1000"',
                'negotiated_price' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0  COMMENT "Flag for negotiable price."',
                'show' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1  COMMENT "Flag shows/hidden product for outer world."',
                'deleted' => Schema::TYPE_BOOLEAN . ' DEFAULT false COMMENT "\'product is deleted\' flag"',
                'delete_date' => Schema::TYPE_TIMESTAMP . ' COMMENT "Product\'s deleting date(it will be used for garbage collection)"'
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%product_card}}');
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
