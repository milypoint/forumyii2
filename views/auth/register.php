<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<?php if ($model !== null):?>
    <div>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'passwordConfirm')->passwordInput() ?>
        <?= $form->field($model, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php endif;?>
