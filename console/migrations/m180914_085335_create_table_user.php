<?php

use yii\db\Migration;

class m180914_085335_create_table_user extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'soc' => $this->string(2),
            'sid' => $this->bigInteger(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'image' => $this->string(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'ip' => $this->string(),
            'browser' => $this->string(),
            'score' => $this->integer()->notNull()->defaultValue(0),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%user}}', ['name', 'surname', 'created_at', 'updated_at'], [
            ['ivan', 'ivanov', time(), time()],
        ]);
    }

    public function safeDown() {
        $this->dropTable('{{%user}}');
    }
}
