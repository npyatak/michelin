<?php

use yii\db\Migration;

class m181016_115345_create_table_post_action extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post_action}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'type' => $this->integer(1)->notNull(),
            'score' => $this->integer()->notNull()->defaultValue(0),

            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey("{post_action}_user_id_fkey", '{{%post_action}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("{post_action}_post_id_fkey", '{{%post_action}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('{post_action}_user_id_fkey', '{{%post_action}}');
        $this->dropForeignKey('{post_action}_post_id_fkey', '{{%post_action}}');

        $this->dropTable('{{%post_action}}');
    }
}