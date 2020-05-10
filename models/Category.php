<?php

namespace app\models;

use app\helpers\MessageHelper;
use app\helpers\TextHelper;
use app\models\queries\CategoryQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'trim'],
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'match', 'pattern' => '~^[a-zA-Z0-9 -]{3,60}$~']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $this->id;

        return [
            'id' => 'ID',
            'name' => 'Category name',
            'description' => 'Description',
            'created_by' => 'Author',
            'created_at' => 'Creation date'
        ];
    }

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
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public function beforeValidate()
    {
        $user = Yii::$app->user->identity;
        if ($user !== null) {
            $this->created_by = $user->getId();
        }
        $this->path = TextHelper::textToPath($this->name);
        return parent::beforeValidate();
    }
}