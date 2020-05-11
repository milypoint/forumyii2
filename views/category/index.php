<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\queries\CategoryQuery */
/* @var $form ActiveForm */
?>
<div>
    <h3>Categories</h3>
    <?php foreach ($model as $category):?>
        <a href="/category/<?php echo $category->path ?>"><?php echo $category->name; ?></a>
        <br>
    <?php endforeach;?>
    <?php echo Html::a('Create', ['category/create'], ['class'=>'btn btn-primary']) ?>
</div>