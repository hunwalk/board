<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%keyword}}`.
 */
class m200907_144237_create_keyword_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%keyword}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'color' => $this->string(),
            'textColor' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%keyword}}');
    }
}
