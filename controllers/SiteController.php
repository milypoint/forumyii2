<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('empty');
    }

    public function actionCategory($category_path)
    {
        $model = Category::find()->byPath($category_path)->one();
        if ($model === null) {
            Yii::$app->session->setFlash(
                'warning',
                'Category not found.'
            );
            return $this->render('empty');
        }

        //TODO: find all post in category
        return $this->render('empty');
    }

}