<?php

use app\models\MessageLike;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $messages app\models\queries\MessageQuery */
/* @var $form ActiveForm */
?>

<?php
$js = <<< JS
    function like(value, url)
    {
        $.ajax({
          method: 'POST',
          dataType: "json",
          url: url,
          data: {'message_id': value},
          success: function (data) {
              console.log(data);
              var but = $("#button_".concat(value));
              but.text('Like '.concat(data.count));
          },
          error: function () {
          }
        });
    }
JS;
$this->registerJs( $js, $position = yii\web\View::POS_HEAD, $key = null );

?>
<div>
    <h3><small style="color: gray">Post </small><b><?php echo $post->title; ?></b></h3>
    <?php
    if (Yii::$app->user->getId() == $post->created_by || Yii::$app->user->can('admin')) {
        echo Html::a('Delete post', ['/post/'. $post->getPrimaryKey() .'/delete'], ['class'=>'btn btn-primary']);
    }
    ?>
    <?php foreach ($messages as $message):?>
        <p style="background-color: #e6f2ff"><em style="color: gray"><?=User::find()->byId($message->created_by)->one()->username?></em> <?php echo $message->content; ?></p>
        <?php
        $count = MessageLike::find()->byMessageId($message->id)->count();
        echo Html::button('Like '. $count,
            [
                'class'=>'teaser',
                'id' => "button_".$message->id,
                'value' => $message->id,
                'onclick' => 'like('.$message->id.', "'.Url::to(['api/like']).'");',
                'color' => 'white',
                'background-color' => '#4CAF50'
            ]);
        ?>
        <br>
    <?php endforeach;?>
    <?php echo Html::a('Create', ['/message/create/'.$post->getPrimaryKey()], ['class'=>'btn btn-primary']) ?>
</div>