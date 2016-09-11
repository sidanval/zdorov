<?php

use yii\db\Migration;

class m160910_193309_history extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'purchase_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createTable('{{%historyElement}}', [
            'id' => $this->primaryKey(),
            'history_id' => $this->integer()->notNull(),
            'field' => $this->string()->notNull(),
            'oldValue' => $this->string()->notNull(),
            'newValue' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%history}}');
        $this->dropTable('{{%historyElement}}');
    }
}
