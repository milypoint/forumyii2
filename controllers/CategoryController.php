<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class CategoryController extends Controller
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

    public function actionIndex()
    {
        $categories = Category::find()->all();
        return $this->render('index', ['model' => $categories]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(
                'success',
                'Success! Category created.'
            );
            return $this->redirect('/category/'.$model->path);
        }
        return $this->render('category_create', ['model' => $model]);
    }
}
