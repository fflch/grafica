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
            'url'  => '/orcamento/create',
        ],
        [
            'text' => 'Consultar',
            'url'  => '/orcamento/consulta',
            'can'  => '',
        ],
        [
            'text' => 'Criar CS',
            'url'  => '/orcamento/criarCs',
            'can'  => '',
        ],
    ]
];
