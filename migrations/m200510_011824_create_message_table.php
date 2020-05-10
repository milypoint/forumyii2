<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m200510_011824_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'content' => $this->text(),
            'post_id' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'fk-message-post_id',
            'message',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-message-created_by',
            'message',
            'created_by',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('message');
    }
}
