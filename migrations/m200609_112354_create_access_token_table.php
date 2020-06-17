<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%access_token}}`.
 */
class m200609_112354_create_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%access_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'consumer' => $this->string(),
            'token' => $this->string(32)->notNull()->unique(),
            'access_given' => $this->json(),
            'used_at' => $this->integer(),
            'expire_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%access_token}}');
    }
}
