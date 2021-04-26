<?php

return [
    "token" => "1783279560:AAGQkha59E8VHbiG9Li9Ki5owgbfkdoI8Ls",
    "controllers" => [
        'App\\Http\Controllers\\StartupController',
        'App\\Http\Controllers\\GetPatientDataController',
        'App\\Http\Controllers\\GetSensorsDataController',
    ],
    "goBack" => "Назад",
    "commands" => [
        "start" => [
            "text" => "/start",
            "controller" => 'App\\Http\Controllers\\StartupController',
            "commands" => [
                "getPatientData" => [
                    "text" => "Данные о пациентах",
                    "controller" => "App\\Http\Controllers\\GetPatientDataController",
                    "commands" => [
                        "getSensorsData" => [
                            "text" => "Данные датчиков",
                            "controller" => "App\\Http\Controllers\\GetSensorsDataController",
                            "commands" => []
                        ]
                    ]
                ],
                "test" => [
                    "text" => "Test button",
                    "controller" => "App\\Http\Controllers\\GetPatientDataController",
                    "commands" => []
                ]
            ]
        ]
    ]
];
