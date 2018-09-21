<?php

use yii\db\Migration;

class m180911_135336_create_table_week extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%week}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull()->unique(),
            'name' => $this->string(100),
            'image' => $this->string(),
            'description' => $this->text(),
            //'status' => $this->integer(1)->notNull()->defaultValue(1),
            
            'date_start' => $this->integer()->notNull(),
            'date_end' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%week}}', ['number', 'date_start', 'date_end'], [
            [1, strtotime('today midnight'), strtotime('today midnight + 1 week')],
            [2, strtotime('today midnight + 1 week'), strtotime('today midnight + 2 week')],
            [3, strtotime('today midnight + 2 week'), strtotime('today midnight + 3 week')],
            [4, strtotime('today midnight + 3 week'), strtotime('today midnight + 4 week')],
            [5, strtotime('today midnight + 4 week'), strtotime('today midnight + 5 week')],
        ]);
    }

    public function safeDown() {

        $this->dropTable('{{%week}}');
    }
}
