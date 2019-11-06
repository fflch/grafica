<?php

return [
    'title'=> 'Gráfica',
    'dashboard_url' => '/',
    'logout_method' => 'GET',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'menu' => [
        [
            'text' => 'Fazer Orçamento',
            'url'  => '/item1',
        ],
        [
            'text' => 'Consultar',
            'url'  => '/item2',
            'can'  => '',
        ],
        [
            'text' => 'Criar CS',
            'url'  => '/item3',
            'can'  => '',
        ],
    ]
];
