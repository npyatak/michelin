<?php

use yii\db\Migration;

class m181002_103954_alter_table_week extends Migration
{
    
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->addColumn('week', 'winner_id', $this->integer());
    }

    public function safeDown() {
        $this->dropColumn('week', 'winner_id');
    }
}