<?php

$submenu1 = [
    [
        'text' => '<i class="fas fa-plus-circle"></i> Novo Pedido',
        'url' => config('app.url') . '/pedidos/create',
    ],
    [
        'text' => '<i class="fas fa-list-alt"></i> Listar Pedidos',
        'url' => config('app.url') . '/pedidos',
    ],
];

$menu = [
    [
        'text' => '<i class="fas fa-store-alt"></i> Pedidos',
        'submenu' => $submenu1,
    ],
];

$right_menu = [
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'target' => '_blank',
        'url' => config('app.url') . '/item1',
        'align' => 'right',
    ],
];

# dashboard_url renomeado para app_url
# USP_THEME_SKIN deve ser colocado no .env da aplicação 

return [
    'title' => config('app.name'),
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'menu' => $menu,
    'right_menu' => $right_menu,
];
