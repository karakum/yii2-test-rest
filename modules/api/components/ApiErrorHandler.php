<?php

namespace app\modules\api\components;


use Yii;
use yii\web\Response;

class ApiErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheridoc
     */

    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
        } else {
            $response = new Response();
        }

        $response->data = $this->convertExceptionToArray($exception);
        if (isset($exception->statusCode)) {
            $response->setStatusCode($exception->statusCode);
        } else {
            $response->setStatusCode(500);
        }

        $response->send();
    }

    /**
     * @inheritdoc
     */
    protected function convertExceptionToArray($exception)
    {
        $error = ['message' => $exception->getMessage()];
        if (isset($exception->statusCode)) {
            $error['code'] = $exception->statusCode;
        }
        return [
            'status' => 'error',
            'errors' => [
                $error,
            ],
        ];
    }
}