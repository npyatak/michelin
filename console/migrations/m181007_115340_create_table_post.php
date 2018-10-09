<?php

use yii\db\Migration;

class m181007_115340_create_table_post extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'contest_stage_id' => $this->integer()->notNull(),
            'yt_id' => $this->string(),
            'media' => $this->string(),
            'score' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'type' => $this->integer(1),
            'text' => $this->text(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey("{post}_user_id_fkey", '{{%post}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("{post}_contest_stage_id_fkey", '{{%post}}', 'contest_stage_id', '{{%contest_stage}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('{post}_contest_stage_id_fkey', '{{%post}}');
        $this->dropForeignKey('{post}_user_id_fkey', '{{%post}}');

        $this->dropTable('{{%post}}');
    }
}
