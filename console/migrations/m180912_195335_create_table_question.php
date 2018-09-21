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
            'week_id' => $this->integer()->notNull()->comment('Неделя'),
            'title' => $this->string()->notNull()->comment('Вопрос'),
            'image' => $this->string(255)->comment('Изображение'),
            'comment' => $this->text()->comment('Комментарий'),
            'right_answer_points' => $this->integer(2)->notNull()->defaultValue(3)->comment('Баллы за правильный ответ'),
            'status' => $this->integer(1)->notNull()->defaultValue(1)->comment('Статус'),
        ], $tableOptions);
        
        $this->addForeignKey("{question}_week_id_fkey", '{{%question}}', 'week_id', '{{%week}}', 'id', 'CASCADE', 'CASCADE');

        $this->batchInsert('{{%question}}', ['id', 'week_id', 'title', 'image'], [
            [
                1, 
                1,
                'Выходишь ли ты из дома без макияжа?', 
                '',
            ],
            [
                2, 
                1,
                'Что такое стробинг?', 
                '',
            ],
            [
                3, 
                1,
                'Кто создал оттенки помад для коллаборации L’Oreal Paris x Balmain?', 
                '',
            ],
            [
                4, 
                1,
                'Что держит в руках эта девушка?', 
                '',
            ],
            [
                5, 
                1,
                'КАКОЙ ТВОЙ ДЕВИЗ ПО ЖИЗНИ?', 
                '',
            ],
            [
                6, 
                1,
                'Для чего эти предметы?', 
                '/images/qimg-6.png',
            ],
            [
                7, 
                1,
                'Контуринг с помощью румян и хайлайтера родом из 70х это:', 
                '/images/qimg-7.png',
            ],
            [
                8, 
                1,
                'Что бы ты взяла с собой на необитаемый остров?', 
                '',
            ],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%question}}');
    }
}