<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alert}}`.
 */
class m200907_143945_create_alert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%alert}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'title' => $this->string(),
            'body' => 'LONGTEXT',
            'type' => $this->string(),
            'sender' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%alert}}');
    }
}
