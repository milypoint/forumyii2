<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\helpers\Console;

class RbacController extends Controller
{
    /**
     * @return int
     */
    public function actionInit()
    {
        $auth = Yii::$app->AuthManager;

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        return ExitCode::OK;
    }

    /**
     * @param $user_id
     * @return int
     * @throws \Exception
     */
    public function actionAdminAssign($user_id)
    {
        if (!$user_id || is_int($user_id)) {
            $this->stdout("Param 'id' must be set!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = User::find()->byId($user_id)->one();
        if (!$user) {
            $this->stdout("User witch id:'$user_id' is not found!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (BaseConsole::input("Are you sure you are want add 'admin' role for user '$user->username'? <y/n>") == 'y') {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('admin');
            $auth->revokeAll($user_id);
            $auth->assign($role, $user_id);
            $this->stdout("Done!\n", Console::BOLD);
        } else {
            $this->stdout("Canceled!\n", Console::BOLD);
        }
        return ExitCode::OK;
    }

    /**
     * @param $user_id
     * @return int
     * @throws \Exception
     */
    public function actionAdminDisassign($user_id)
    {
        if (!$user_id || is_int($user_id)) {
            $this->stdout("Param 'id' must be set!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = User::find()->byId($user_id)->one();
        if (!$user) {
            $this->stdout("User witch id:'$user_id' is not found!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (BaseConsole::input("Are you sure you are want remove 'admin' role for user '$user->username'? <y/n>") == 'y') {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');
            $auth->revokeAll($user_id);
            $auth->assign($role, $user_id);

            $this->stdout("Done!\n", Console::BOLD);
        } else {
            $this->stdout("Canceled!\n", Console::BOLD);
        }
        return ExitCode::OK;
    }
}