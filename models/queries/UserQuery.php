<?php

namespace app\models\queries;

use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * @param string $username
     * @return UserQuery
     */
    public function byUsername($username)
    {
        return $this->andWhere(['username' => $username]);
    }

    /**
     * @param string $email
     * @return UserQuery
     */
    public function byEmail($email)
    {
        return $this->andWhere(['email' => $email]);
    }
}