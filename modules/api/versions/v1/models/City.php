<?php

namespace app\modules\api\versions\v1\models;


class City extends \app\modules\api\common\models\City
{

    public function fields()
    {
        $data = [
            'id',
            'name',
            'country' => function () {
                return [
                    'id' => $this->country_id,
                    'name' => $this->country->name,
                ];
            },
            'region' => function () {
                return [
                    'id' => $this->region_id,
                    'name' => $this->region->name,
                ];
            },
        ];
        return $data;
    }

}