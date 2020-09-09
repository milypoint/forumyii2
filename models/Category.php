<?php

namespace app\models;

use app\models\queries\CategoryQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;
use yii\helpers\Inflector;

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
            ],
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
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
        $this->path = Inflector::slug($this->name);
        return parent::beforeValidate();
    }
}