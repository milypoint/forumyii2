<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m200506_155817_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'email' => $this->string(),
            'created_at' => $this->timestamp(),
            'is_confirmed' => $this->boolean()->defaultValue(false)->notNull(),
            'confirm_code' => $this->string()
        ]);

        $this->createIndex(
            'uk_users_username',
            'user',
            'username',
            true
        );
        $this->createIndex(
            'uk_users_email',
            'user',
            'email',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
