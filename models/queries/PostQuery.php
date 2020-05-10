<?php

namespace app\models\queries;

use yii\base\Theme;
use yii\db\ActiveQuery;

class PostQuery extends ActiveQuery
{
    /**
     * @param int $author_id
     * @return PostQuery
     */
    public function byAuthorId($author_id)
    {
        return $this->andWhere(['created_by' => $author_id]);
    }
}