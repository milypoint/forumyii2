<?php

namespace app\models;

use app\models\queries\UserQuery;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $password_confirm
 * @property string|null $email
 * @property string|null $date
 * @property int|null $is_confirmed
 * @property string|null $confirm_code
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';

    /**
     * @var string
     */
    public $passwordConfirm;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'passwordConfirm', 'email'], 'trim'],
            [['username', 'password', 'email'], 'required'],
            [['passwordConfirm'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['username', 'email'], 'unique'],
            [['is_confirmed'], 'boolean'],
            [['password'], 'string', 'min' => 8],
            [['email'], 'email'],
            [['passwordConfirm'], 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirm',
            'email' => 'Email',
            'created_at' => 'Creation date',
            'is_confirmed' => 'Is Confirmed',
            'confirm_code' => 'Confirm Code',
        ];
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
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

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->confirm_code = Yii::$app->security->generateRandomString(8);
        }
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        if (!$this->hasErrors() && $this->isNewRecord) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::afterValidate();
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    public function getId()
    {
        return $this->primaryKey;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }
}