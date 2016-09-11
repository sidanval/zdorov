<?php

use yii\db\Migration;
use common\models\User;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'role' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $admin = new User();
        $admin->load(['User' => [
            'username' => 'Администратор',
            'email' => 'admin@zdorov.dev',
            'password' => 'admin',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN
        ]]);
        $admin->save();

        $manager = new User();
        $manager->load(['User' => [
            'username' => 'Менеджер',
            'email' => 'manager@zdorov.dev',
            'password' => 'manager',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_MANAGER
        ]]);
        $manager->save();
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
