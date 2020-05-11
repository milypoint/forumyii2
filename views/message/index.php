<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $messages app\models\queries\MessageQuery */
/* @var $form ActiveForm */
?>
<div>
    <h3>Messages in post <?php echo $post->title; ?></h3>
    <?php foreach ($messages as $message):?>
        <p><?php echo $message->content; ?></p>
        <br>
    <?php endforeach;?>
    <?php echo Html::a('Create', ['/message/create/'.$post->getPrimaryKey()], ['class'=>'btn btn-primary']) ?>
</div>