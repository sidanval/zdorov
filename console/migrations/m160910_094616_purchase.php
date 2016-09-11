<?php

use yii\db\Migration;

class m160910_094616_purchase extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%purchase}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'clientName' => $this->string()->notNull(),
            'phone' => $this->string(50),
            'comment' => $this->text(),
            'product_id' => $this->integer(),
            'cost' => $this->float()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'cost' => $this->float()->notNull(),
        ]);

        $this->batchInsert('{{%product}}', ['name', 'cost'], [
            ['name' => 'Яблоки', 'cost' => '100'],
            ['name' => 'Апельсины', 'cost' => '150'],
            ['name' => 'Мандарины', 'cost' => '75'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%purchase}}');
        $this->dropTable('{{%product}}');
    }
}
