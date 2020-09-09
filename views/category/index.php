<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\queries\CategoryQuery */
/* @var $form ActiveForm */

//$this->registerJs(
//    "alert('Button clicked!');",
//    View::POS_READY
//    'my-button-handler'
//);
?>
<div>
    <h3>Categories</h3>
    <?php foreach ($model as $category):?>
        <a href="/category/<?php echo $category->path ?>"><?php echo $category->name; ?></a>
        <?php if (Yii::$app->user->can('admin')) {
            echo Html::a('Delete', ['category/'.$category->path.'/delete'], ['class'=>'btn btn-primary']);
        }?>
        <br>
    <?php endforeach;?>

    <?php if (Yii::$app->user->can('admin')) {
        echo Html::a('Create', ['category/create'], ['class'=>'btn btn-primary']);
    }?>
</div>
