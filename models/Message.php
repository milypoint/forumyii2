<?php

namespace app\models;

use app\helpers\MessageHelper;
use app\helpers\TextHelper;
use app\models\queries\CategoryQuery;
use app\models\queries\MessageQuery;
use app\models\queries\PostQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

class Message extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'trim'],
            [['content', 'post_id', 'created_by'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Message content',
            'post_id' => 'Post ID',
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
     * @return MessageQuery
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
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