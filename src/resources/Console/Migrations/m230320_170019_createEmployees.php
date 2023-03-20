<?php

use yii\db\Migration;

/**
 * Class m230320_152919_CreateTables
 */
class m230320_170019_createEmployees extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $faker = \Faker\Factory::create();

        $users = [];
        for ($i = 0; $i < 1000; $i++) {
            $users[] = [
                'uuid' => $faker->uuid(),
                'name' => $faker->name(),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s')
            ];
        }

        $this->db->createCommand()->batchInsert('user', ['uuid', 'name', 'created_at'], $users)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->truncateTable('user');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');

    }
}
