<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message_like`.
 */
class m200908_162154_create_message_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message_like', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'liked_by' => $this->integer()->notNull(),
            'liked_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
           'fk-message_like-liked_by',
           'message_like',
           'liked_by',
           'user',
           'id',
           'CASCADE'
        );

        $this->createIndex(
            'idx-message_like-message_id-liked_by',
            'message_like',
            ['message_id', 'liked_by'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-message_like-message_id-liked_by', 'message_like');
        $this->dropForeignKey('fk-message_like-liked_by', 'message_like');
        $this->dropTable('message_like');
    }
}
