<?php
return [
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
//            'baseUrl' => 'http://site.ru/',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
