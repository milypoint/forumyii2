<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m200510_005033_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'path' => $this->string()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'fk-category-created_by',
            'category',
            'created_by',
            'user',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-category-name',
            'category',
            'name',
            true
        );

        $this->createIndex(
            'idx-category-path',
            'category',
            'path',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
