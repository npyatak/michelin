<?php

use yii\db\Migration;

class m181030_163954_alter_table_post extends Migration
{
    
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->addColumn('post', 'city', $this->string());
    }

    public function safeDown() {
        $this->dropColumn('post', 'city');
    }
}