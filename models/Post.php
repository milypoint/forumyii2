<?php

namespace app\models;

use app\helpers\MessageHelper;
use app\helpers\TextHelper;
use app\models\queries\CategoryQuery;
use app\models\queries\PostQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

class Post extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['title', 'category_id', 'created_by'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Post title',
            'category_id' => 'Category ID',
            'created_by' => 'Author',
            'created_at' => 'Creation date'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('now()')
            ]
        ];
    }

    /**
     * @return PostQuery
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        $user = Yii::$app->user->identity;
        if ($user !== null) {
            $this->created_by = $user->getId();
        }
        return parent::beforeValidate();
    }
}