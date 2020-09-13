<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alert_keyword}}`.
 */
class m200907_144343_create_alert_keyword_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%alert_keyword}}', [
            'id' => $this->primaryKey(),
            'alert_id' => $this->integer(),
            'keyword_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%alert_keyword}}');
    }
}
