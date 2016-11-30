<?php

namespace app\modules\api\components;

class HtmlResponseFormatter extends \yii\web\HtmlResponseFormatter
{
    /**
     * Formats the specified response.
     * @param \yii\web\Response $response the response to be formatted.
     */
    public function format($response)
    {
        parent::format($response);
        if (!is_string($response->content)) {
            $response->content = "<pre>\n" . print_r($response->content, true) . "\n</pre>";
        }
    }
}
