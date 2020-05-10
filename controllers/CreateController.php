<?php

namespace app\controllers;

use app\models\Category;
use yii\web\Controller;
use Yii;

class CreateController extends Controller
{
    public function actionCategory()
    {
        // Redirect to login if user is not logged in:
        if (Yii::$app->user->identity === null) {
            return $this->redirect('/login');
        }
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(
                'success',
                'Success! Category created.'
            );
            $model = new Category();
        }
        return $this->render('category', ['model' => $model]);
    }
}