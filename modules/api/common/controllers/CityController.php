<?php

namespace app\modules\api\common\controllers;

use app\modules\api\components\ActiveController;


class CityController extends ActiveController
{
    public $modelClass = '\app\models\City';

    public $updateScenario = 'update_api';
    public $createScenario = 'create_api';

    
}