<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{

    public function actionAddUser($username, $email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->access_token = Yii::$app->security->generateRandomString();
        if ($user->save()) {
            echo 'User created', PHP_EOL;
        } else {
            echo 'Errors:', PHP_EOL, print_r($user->errors, true), PHP_EOL;
        }
    }

}
