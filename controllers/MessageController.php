<?php

namespace app\controllers;

use app\models\Message;
use app\models\Post;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class MessageController extends Controller
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param int $post_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCreate($post_id)
    {
        $post = Post::findOne($post_id);
        if ($post === null) {
            throw new NotFoundHttpException('Post with id <' .$post_id.'> not found.');
        }
        $model = new Message();
        if ($model->load(Yii::$app->request->post())) {
            $model->post_id = $post->getPrimaryKey();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Success! Message created.');
                $model = new Message();
            } else {
                Yii::$app->session->setFlash('warning', 'Error! Message was not created.');
            }
        }
        return $this->render('message', ['model' => $model]);
    }
}
