<?php

namespace app\modules\api\controllers;

use app\models\MessageLike;
use milypoint\urlshortenerclient\NotValidDataException;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class LikeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
                        'actions' => ['like']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?', 'user'],
                        'actions' => ['index']
                    ]
                ],
            ],
        ]);
    }

    /**
     * @return MessageLike|array
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionLike()
    {
        $message_id = Yii::$app->request->post('message_id');
        $liked_by = Yii::$app->user->getId();
        $model = MessageLike::find()->byMessageId($message_id)->byUserId($liked_by)->one();
        if ($model === null) {
            $model = new MessageLike();
            $model->message_id = $message_id;
            $model->liked_by = $liked_by;
            if (!$model->save()) {
                return $model;
            }
        } else {
            $model->delete();
        }
        return ['count' => MessageLike::find()->byMessageId($message_id)->count()];
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        $message_id = Yii::$app->request->get('message_id');
        return ['count' => MessageLike::find()->byMessageId($message_id)->count()];
    }
}