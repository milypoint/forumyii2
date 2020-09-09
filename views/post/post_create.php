<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $message app\models\Message */
/* @var $form ActiveForm */
?>
<div>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($post, 'title')->textarea() ?>
    <?= $form->field($message, 'content')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>