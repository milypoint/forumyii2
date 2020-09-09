<?php

use app\models\MessageLike;
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
              var but = $("#button_".concat(value)); //setAttribute('value', data.count)
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
    <h3>Messages in post <?php echo $post->title; ?></h3>
    <?php
    if (Yii::$app->user->getId() == $post->created_by || Yii::$app->user->can('admin')) {
        echo Html::a('Delete', ['/post/'. $post->getPrimaryKey() .'/delete'], ['class'=>'btn btn-primary']);
    }
    ?>
    <?php foreach ($messages as $message):?>
        <p><?php echo $message->content; ?></p>
        <?php
        $count = MessageLike::find()->byMessageId($message->id)->count();
        echo Html::button('Like '. $count,
            [
                'class'=>'btn btn-primary',
                'id' => "button_".$message->id,
                'value' => $message->id,
                'onclick' => 'like('.$message->id.', "'.Url::to(['api/like']).'");'
            ]);
        ?>
        <br>
    <?php endforeach;?>
    <?php echo Html::a('Create', ['/message/create/'.$post->getPrimaryKey()], ['class'=>'btn btn-primary']) ?>
</div>