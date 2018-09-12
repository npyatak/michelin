<?php

use yii\db\Migration;

class m180119_105335_create_table_admin extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        //Админ по умолчанию. Пароль adUIYU%23&$
        $this->batchInsert('{{%admin}}', ['login', 'password_hash', 'auth_key', 'email', 'created_at', 'updated_at'], [
            ['admin', '$2y$13$p/KNFsvgjgMnX1HyfdDj6.HlC3Ud29sEQ6kDPYiiBRbIKvgHrhjOq', 'sdsadasd', '', time(), time()],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
    }
}
