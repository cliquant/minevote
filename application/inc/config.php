<?php


return array(

    'url' => 'http://localhost/',

    'title' => 'MineVote',

    'language' => 'lv',

    'database' => [
        'enabled' => true,
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'name' => 'minevote',
        'port' => '3306',
    ],

    'views' => [
        'home','auth','404',
    ],

    'menu' => [
        [
            'name' => 'home',
            'url' => 'http://localhost/home',
        ],
        [
            'name' => 'sign-in',
            'url' => 'http://localhost/auth/sign-in',
        ],
        [
            'name' => 'sign-up',
            'url' => 'http://localhost/auth/sign-up',
        ]
    ]

);