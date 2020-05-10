<?php

namespace app\models\queries;

use yii\base\Theme;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    /**
     * @param string $name
     * @return CategoryQuery
     */
    public function byName($name)
    {
        return $this->andWhere(['name' => $name]);
    }

    /**
     * @param int $author_id
     * @return CategoryQuery
     */
    public function byAuthorId($author_id)
    {
        return $this->andWhere(['created_by' => $author_id]);
    }

    public function byPath($categoty_path)
    {
        return$this->andWhere(['path' => $categoty_path]);
    }
}