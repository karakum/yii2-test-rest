<?php
namespace app\modules\api;

use app\modules\api\components\ApiErrorHandler;
use Yii;
use yii\base\Module;

class ApiModule extends Module
{
    public function init()
    {
        parent::init();
        Yii::configure(Yii::$app, require(__DIR__ . '/config.php'));
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = false;

        $handler = new ApiErrorHandler();
        Yii::$app->set('errorHandler', $handler);
        //необходимо вызывать register, это обязательный метод для регистрации обработчика
        $handler->register();
    }
}