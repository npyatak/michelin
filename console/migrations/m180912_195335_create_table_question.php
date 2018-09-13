<?php

use yii\db\Migration;

class m180912_195335_create_table_question extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Вопрос'),
            'image' => $this->string(255)->comment('Изображение'),
            'comment' => $this->text()->comment('Комментарий'),
            'right_answer_points' => $this->integer(2)->notNull()->defaultValue(3)->comment('Баллы за правильный ответ'),
            'status' => $this->integer(1)->notNull()->defaultValue(1)->comment('Статус'),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%question}}');
    }
}