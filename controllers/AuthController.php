<?php

namespace app\controllers;

use app\helpers\MessageHelper;
use app\models\AuthForm;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['login', 'register', 'confirm']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['logout']
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new AuthForm();
        
        if ($model->load(Yii::$app->request->post())  && $model->validate() && $model->login()) {
            Yii::$app->session->setFlash('success', "Success login.");
            $model = new AuthForm();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionRegister()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())  && $model->save()) {
            Yii::$app->session->setFlash(
                'success',
                'Success register! Check your email box for complete registration.'
            );
            $url = \yii\helpers\Url::to(['auth/confirm/'.$model->email.'/'.$model->confirm_code], true);
            $msg = (new MessageHelper('Verify your email by following this link: ' . $url))
                ->urlsToShort()
                ->message;
            Yii::$app->mailer->compose('register') //['model' => $model]
                ->setFrom('noreply@mysite.com')
                ->setTo($model->email)
                ->setSubject($msg)
                ->send();
            $model = null;
        }
        return $this->render('register', ['model' => $model]);
    }

    public function actionConfirm($email, $code)
    {
        $model = User::find()->byEmail($email)->one();
        try {
            if ($model->is_confirmed === 0 && $model->confirm_code === $code) {
                $model->is_confirmed = 1;
                $model->passwordConfirm = $model->password; // for model validation
                if (!$model->save()) {
                    throw new Exception('Cannot save model.');
                }
                Yii::$app->session->setFlash('success', 'Your email confirmed!');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('warning', 'Confirm error.');
        }
        return $this->render('confirm');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}
