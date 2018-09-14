<?php

use yii\db\Migration;

class m180914_095335_create_table_user_test extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/users/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_test}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'week_id' => $this->integer()->notNull()->comment('Неделя'),
            'answers' => $this->string()->comment('Ответы'),
            'score' => $this->integer()->notNull()->defaultValue(0)->comment('Баллы'),
            'is_finished' => $this->integer(),
            'right_answers' => $this->integer()->notNull()->defaultValue(0)->comment('Правильные ответы'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey("{user_test}_user_id_fkey", '{{%user_test}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("{user_test}_week_id_fkey", '{{%user_test}}', 'week_id', '{{%week}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('{{%user_test}}');
    }
}
