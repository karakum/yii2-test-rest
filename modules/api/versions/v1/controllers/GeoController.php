<?php

namespace app\modules\api\versions\v1\controllers;


use Yii;
use yii\rest\Controller;

class GeoController extends Controller
{

    private function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $lat1 *= M_PI / 180;
        $lat2 *= M_PI / 180;
        $lon1 *= M_PI / 180;
        $lon2 *= M_PI / 180;

        $d_lon = $lon1 - $lon2;

        $slat1 = sin($lat1);
        $slat2 = sin($lat2);
        $clat1 = cos($lat1);
        $clat2 = cos($lat2);
        $sdelt = sin($d_lon);
        $cdelt = cos($d_lon);

        $y = pow($clat2 * $sdelt, 2) + pow($clat1 * $slat2 - $slat1 * $clat2 * $cdelt, 2);
        $x = $slat1 * $slat2 + $clat1 * $clat2 * $cdelt;

        return atan2(sqrt($y), $x) * 6372795;
    }

    public function actionAddressInRadius($address, $lat, $long, $r)
    {
        $api = new \Yandex\Geo\Api();

        $api->setQuery($address);
        $api
            ->setLimit(1)// кол-во результатов
            ->setLang(\Yandex\Geo\Api::LANG_RU)// локаль ответа
            ->load();

        $response = $api->getResponse();
        if ($response->getFoundCount()) {

            // Список найденных точек
            $collection = $response->getList();
            $item = $collection[0];

            $lat1 = (double)$lat;
            $lon1 = (double)$long;
            $lat2 = $item->getLatitude();
            $lon2 = $item->getLongitude();
            $distance = $this->getDistance($lat1, $lon1, $lat2, $lon2);

            return [
                'query' => $response->getQuery(),
                'address' => $item->getAddress(),
                'lat' => $item->getLatitude(),
                'long' => $item->getLongitude(),
                'point' => [
                    'lat' => $lat1,
                    'long' => $lon1,
                ],
                'distance' => ((int)$distance) / 1000.0,
                'result' => (($distance / 1000.0) < (double)$r),
            ];
        } else {
            Yii::$app->response->statusCode = 404;
        }
        return '';
    }
}