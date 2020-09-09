<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $category app\models\Category */
/* @var $posts app\models\queries\CategoryQuery */
/* @var $form ActiveForm */
?>
<div>
    <h3>Posts in category <?php echo $category->name?></h3>
    <?php foreach ($posts as $post):?>
        <a href="<?php echo '/category/'.$category->path.'/post/'.$post->getPrimaryKey(); ?>"><?php echo $post->title; ?></a>
        <br>
    <?php endforeach;?>
    <?php if (Yii::$app->user->can('user')) {
        echo Html::a('Create', ['/post/create/'.$category->path], ['class'=>'btn btn-primary']);
    }  ?>
</div>