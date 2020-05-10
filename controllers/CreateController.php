<?php

namespace app\controllers;

use app\models\Category;
use app\models\Message;
use app\models\NewPostForm;
use app\models\Post;
use yii\web\Controller;
use Yii;

class CreateController extends Controller
{
    public function actionCategory()
    {
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

    public function actionPost($category_path)
    {
        $model = new NewPostForm();
        if ($model->load(Yii::$app->request->post())) {
            $category = Category::find()->byPath($category_path)->one();
            if ($category !== null) {
                $model->category_id = $category->getPrimaryKey();
            }
            if ($model->create()) {
                Yii::$app->session->setFlash(
                    'success',
                    'Success! Post created.'
                );
                $model = new NewPostForm();
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Error! Post was not created.'
                );
            }
        }
        return $this->render('newpost', ['model' => $model]);
    }

    public function actionMessage($post_id)
    {
        $model = new Message();
        if ($model->load(Yii::$app->request->post())) {
            $post = Post::findOne($post_id);
            if ($post !== null) {
                $model->post_id = $post->getPrimaryKey();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    'Success! Message created.'
                );
                $model = new NewPostForm();
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Error! Message was not created.'
                );
            }
        }
        return $this->render('message', ['model' => $model]);
    }

    public function beforeAction($action)
    {
        // Redirect to login if user is not logged in:
        if (Yii::$app->user->identity === null) {
            return $this->redirect('/login');
        }
        return parent::beforeAction($action);
    }
}