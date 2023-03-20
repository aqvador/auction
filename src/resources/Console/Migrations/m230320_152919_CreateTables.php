<?php

use yii\db\Migration;

/**
 * Class m230320_152919_CreateTables
 */
class m230320_152919_CreateTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'uuid' => $this->string()->notNull(),
            'name' => $this->string()->null(),
            'created_at' => $this->timestamp()->notNull()
        ]);

        $this->addPrimaryKey('user_PK', 'user', 'uuid');

        $this->createTable('auction_lot', [
            'uuid' => $this->string()->notNull(),
            'name' => $this->string()->null(),
            'step' => $this->json()->notNull(),
            'status' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'finally_at' => $this->timestamp()->defaultValue(null),
            'winner' => $this->string()->defaultValue(null)
        ]);

        $this->addPrimaryKey('lot_PK', 'auction_lot', 'uuid');
        $this->addForeignKey('auction_lot_winner_user_FK', 'auction_lot', 'winner', 'user', 'uuid');

        $this->createTable('auction_step', [
            'uuid' => $this->string()->notNull(),
            'lot_uuid' => $this->string()->null(),
            'user_uuid' => $this->string()->null(),
            'step' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()
        ]);

        $this->addPrimaryKey('auction_step_PK', 'auction_step', 'uuid');
        $this->addForeignKey('auction_step_lot_uuid_FK', 'auction_step', 'lot_uuid', 'auction_lot', 'uuid');
        $this->addForeignKey('auction_step_user_uuid_FK', 'auction_step', 'user_uuid', 'user', 'uuid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auction_step');
        $this->dropTable('auction_lot');
        $this->dropTable('user');
    }
}
