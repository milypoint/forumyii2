<?php

namespace app\models\queries;

use yii\db\ActiveQuery;

class MessageLikeQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return MessageLikeQuery
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param int message_id
     * @return MessageLikeQuery
     */
    public function byMessageId($message_id)
    {
        return $this->andWhere(['message_id' => $message_id]);
    }

    /**
     * @param int $user_id
     * @return MessageLikeQuery
     */
    public function byUserId($user_id)
    {
        return $this->andWhere(['liked_by' => $user_id]);
    }
}