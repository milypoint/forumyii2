<?php

namespace app\models;

use yii\base\Model;
use Yii;

class AuthForm extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'trim'],
            [['username', 'password'], 'required'],
        ];
    }

    public function login()
    {
        $model = User::find()->byUsername($this->username)->one();
        if ($model === null) {
            $this->addError('username', 'Username not found.');
            return false;
        }
        if (!$model->is_confirmed) {
            $this->addError('username', 'Account is not confirmed.');
            return false;
        }
        if (!Yii::$app->security->validatePassword($this->password, $model->password)) {
            $this->addError('password', 'Password is not correct.');
            return false;
        }
        Yii::$app->user->login($model);
        return true;
    }
}