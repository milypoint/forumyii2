<?php

namespace app\models;

use app\models\queries\MessageLikeQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class MessageLike extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'liked_by'], 'required'],
            [['message_id', 'liked_by'], 'integer'],
            [['liked_at'], 'safe'],
            [['message_id', 'liked_by'], 'unique', 'targetAttribute' => ['message_id', 'liked_by']],
            [['liked_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['liked_by' => 'id']],
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
                'createdAtAttribute' => 'liked_at',
                'value' => new Expression('now()')
            ]
        ];
    }

    /**
     * @return MessageLikeQuery
     */
    public static function find()
    {
        return new MessageLikeQuery(get_called_class());
    }
}
