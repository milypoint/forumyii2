<?php

namespace app\models\queries;

use yii\base\Theme;
use yii\db\ActiveQuery;

class MessageQuery extends ActiveQuery
{
    /**
     * @param int $author_id
     * @return MessageQuery
     */
    public function byAuthorId($author_id)
    {
        return $this->andWhere(['created_by' => $author_id]);
    }
}