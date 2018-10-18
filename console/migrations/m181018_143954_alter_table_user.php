<?php

use yii\db\Migration;

class m181018_143954_alter_table_user extends Migration
{
    
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->addColumn('user', 'email', $this->string());
    }

    public function safeDown() {
        $this->dropColumn('user', 'email');
    }
}