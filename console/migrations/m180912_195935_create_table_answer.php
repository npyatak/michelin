<?php

use yii\db\Migration;

class m180912_195935_create_table_answer extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull()->comment('Вопрос'),
            'text' => $this->string(255)->notNull()->comment('Текст'),
            'is_right' => $this->integer(1)->comment('Верный'),
        ], $tableOptions);
        
        $this->addForeignKey("{answer}_question_id_fkey", '{{%answer}}', 'question_id', '{{%question}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%answer}}');
    }
}