<?php

namespace app\controllers;

use app\models\Category;
use app\models\Message;
use app\models\Post;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['index']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    /**
     * @param $category_path
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($category_path)
    {
        $category = Category::find()->byPath($category_path)->one();
        if ($category === null) {
            throw new NotFoundHttpException('Category <'.$category_path.'> not found.');
        }
        $posts = Post::find()->byCategoryId($category->getPrimaryKey())->all();
        return $this->render('index', ['category' => $category, 'posts' => $posts]);
    }

    /**
     * @param $category_path
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate($category_path)
    {
        $category = Category::find()->byPath($category_path)->one();
        if ($category === null) {
            throw new NotFoundHttpException('Category <' .$category_path.'> not found.');
        }
        $post = new Post();
        $post_message = new Message();
        if ($post->load(Yii::$app->request->post()) && $post_message->load(Yii::$app->request->post())) {
            $post->category_id = $category->getPrimaryKey();
            $isSucces = false;
            if ($post->save()) {
                $post_message->post_id = $post->getPrimaryKey();
                if ($post_message->save()) {
                    $isSucces = true;
                } else {
                    $post->delete();
                }
            }
            if ($isSucces) {
                Yii::$app->session->setFlash('success', 'Success! Post created.');
                return $this->redirect('/category/'.$category->path.'/post/'.$post->getPrimaryKey());
            } else {
                Yii::$app->session->setFlash('warning', 'Error! Post was not created.');
            }
        }
        return $this->render('post_create', ['post' => $post, 'message' => $post_message]);
    }

    public function actionDelete($post_id)
    {
        $model = Post::find()->byId($post_id)->one();
        if ($model === null) {
            throw new NotFoundHttpException('Post with id <' .$post_id.'> not found.');
        }
        $category = Category::find()->byId($model->category_id)->one();
        if ($category === null) {
            throw new NotFoundHttpException('Category with id <' .$model->category_id.'> not found.');
        }
        try {
            $model->delete();
            return $this->redirect(['category/'. $category->path]);
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
        }
    }
}
