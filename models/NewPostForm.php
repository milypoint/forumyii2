<?php

namespace app\models;

use yii\base\Model;
use Yii;

class NewPostForm extends Model
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $category_id;

    public function rules()
    {
        return [
            [['title', 'content'], 'trim'],
            [['title', 'content', 'category_id'], 'required'],
        ];
    }

    /**
     * @return bool
     */
    public function create()
    {
        $post = new Post();
        $message = new Message();
        if ($this->validate()) {
            $post->title = $this->title;
            $post->category_id = $this->category_id;
            if ($post->save()) {
                $message->content = $this->content;
                $message->post_id = $post->getPrimaryKey();
                if ($message->save()) {
                    return true;
                } else {
                    $post->delete();
                }
            }
        }
        return false;
    }
}
