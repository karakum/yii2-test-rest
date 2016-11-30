<?php

namespace app\modules\api\common\models;

class City extends \app\models\City
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update_api'] = [
            'name',
            'region_id',
        ];
        $scenarios['create_api'] = [
            'name',
            'region_id',
        ];
        return $scenarios;
    }

}
