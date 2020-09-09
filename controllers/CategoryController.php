<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                        'roles' => ['user'],
                        'actions' => ['index']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                        'actions' => ['create', 'delete']
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

    public function actionDelete($category_path)
    {
        $model = Category::find()->byPath($category_path)->one();

        if ($model === null) {
            throw new NotFoundHttpException('Category with path <' .$category_path.'> not found.');
        }

        try {
            $model->delete();
            return $this->redirect(['index']);
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
        }

    }
}
