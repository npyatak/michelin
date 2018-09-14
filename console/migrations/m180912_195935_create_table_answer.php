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
        
        $this->batchInsert('{{%answer}}', ['question_id', 'text', 'is_right'], [
            [1, 'Нет, настоящая женщина должна блистать всегда!', 1],
            [1, 'Я и дома всегда использую косметику', null],
            [1, 'Это зависит от того, куда и зачем я иду. Тратить дорогой хайлайтер, чтобы ослепить кассиршу в супермаркете – это не мое!', null],
            [1, 'Да, чаще всего так и выхожу, а крашусь только по особым случаям: на выпускной, на свадьбу и на юбилей свекрови', null],

            [2, 'Это мейкап-техника выделения контуров лица с помощью хайлайтера без использования бронзера', 1],
            [2, 'У вас слишком сложные вопросы, я к такому не готовилась!', null],
            [2, 'Это когда добывают биткоины и зарабатывают много денег', null],
            [2, 'Я знаю – это макияж, при котором можно подчеркнуть контуры лица с помощью бронзера и хайлайтера', null],

            [3, 'Pierre BALMAIN', 1],
            [3, 'Olivier Rousteing', null],
            [3, 'Пэрис Хилтон', null],
            [3, 'Какой-то модный обозреватель', null],

            [4, 'Аэрограф', 1],
            [4, 'Прибор для удаления акне', null],
            [4, 'Пистолет для прокола ушей', null],
            [4, 'Ирригатор, что бы это ни значило', null],

            [5, 'Блистать всегда!', 1],
            [5, 'Встречают по одежке', null],
            [5, 'Красота спасет мир', null],
            [5, 'Никогда не отказывайтесь от своей мечты', null],

            [6, 'Это кисти-щетки для нанесения макияжа', 1],
            [6, 'Это щетки для котов и мелких пород собак', null],
            [6, 'Это массажные щетки', null],
            [6, 'Это щетки для прочистки сопел в карбюраторе', null],

            [7, 'Мультимаскинг', 1],
            [7, 'Мультитаскинг', null],
            [7, 'Дрейпинг', null],
            [7, 'Фризинг', null],

            [8, 'Тушь для ресниц Paradise', 1],
            [8, 'Палетка теней La Petite Palette', null],
            [8, 'Матовая помада Color Riche из коллекции Balmain', null],
            [8, 'Консилер для лица Alliance Perfect', null],
            [8, 'Жидкий хайлайтер Glow Mon Amour', null],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%answer}}');
    }
}