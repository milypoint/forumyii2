<?php

namespace app\controllers;

use app\helpers\MessageHelper;
use app\models\AuthForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\AccessControl;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
            $return_url = Yii::$app->user->getReturnUrl();
            if($return_url !== NULL){
                $this->redirect($return_url);
            }
            else{
                return $this->goBack();
            }
            $model = new AuthForm();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionRegister()
    {
        $model = new User(['scenario' => User::SCENARIO_REGISTER]);

        if ($model->load(Yii::$app->request->post())  && $model->save()) {

            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');
            $auth->assign($role, $model->id);

            Yii::$app->session->setFlash('success', 'Check your email box for complete registration.');
            $url = Url::to(['auth/confirm/'.$model->email.'/'.$model->confirm_code], true);
            $msg = (new MessageHelper('Verify your email by following this link: ' . $url))
                ->urlsToShort()
                ->message;
            Yii::$app->mailer->compose('register')
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
        $model = User::find()
            ->byEmail($email)
            ->andWhere([
                'is_confirmed' => 0,
                'confirm_code' => $code
            ])
            ->one();
        if ($model !== null) {
            $model->is_confirmed = 1;
            if ($model->update(true, ['is_confirmed'])) {
                Yii::$app->session->setFlash('success', 'Your email confirmed!');
            }
        } else {
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
