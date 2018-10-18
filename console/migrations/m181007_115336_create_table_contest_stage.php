<?php

use yii\db\Migration;

class m181007_115336_create_table_contest_stage extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contest_stage}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'image' => $this->string(),
            'description' => $this->text(),
            //'status' => $this->integer(1)->notNull()->defaultValue(1),
            
            'date_start' => $this->integer()->notNull(),
            'date_end' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%contest_stage}}', ['number', 'date_start', 'date_end', 'name'], [
            [1, strtotime('2018-10-22 00:00:00'), strtotime('2018-10-28 23:59:59'), 'Первый этап творческого конкурса'],
            [2, strtotime('2018-10-29 00:00:00'), strtotime('2018-11-04 23:59:59'), 'Второй этап творческого конкурса'],
            [3, strtotime('2018-11-05 00:00:00'), strtotime('2018-11-11 23:59:59'), 'Третий этап творческого конкурса'],
            [4, strtotime('2018-11-12 00:00:00'), strtotime('2018-11-18 23:59:59'), 'Четвертый этап творческого конкурса'],
            [5, strtotime('2018-11-19 00:00:00'), strtotime('2018-11-25 23:59:59'), 'Пятый этап творческого конкурса'],
            [6, strtotime('2018-11-26 00:00:00'), strtotime('2018-12-02 23:59:59'), 'Шестой этап творческого конкурса'],
            [7, strtotime('2018-12-03 00:00:00'), strtotime('2018-12-09 23:59:59'), 'Седьмой этап творческого конкурса'],
        ]);
    }

    public function safeDown() {

        $this->dropTable('{{%contest_stage}}');
    }
}