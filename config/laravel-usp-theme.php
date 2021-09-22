<?php

$submenu1 = [
    [
        'text' => '<i class="fas fa-plus-circle"></i> Novo Pedido',
        'url' => config('app.url') . '/pedidos/create',
        'can' => 'logado',
    ],
    [
        'text' => '<i class="fas fa-list-alt"></i> Listar Pedidos',
        'url' => config('app.url') . '/pedidos',
        'can' => 'servidor',
    ],
];

$menu = [
    [
        'text' => '<i class="fas fa-home"></i> Home',
        'url' => config('app.url') . '/home',
        'can' => 'logado',
    ],
    [
        'text' => '<i class="fas fa-store-alt"></i> Pedidos',
        'submenu' => $submenu1,
        'can' => 'logado',
    ],
    [
        'text' => '<i class="fas fa-check-square"></i> Pedidos a Autorizar',
        'url' => config('app.url') . '/pedidos/visualizar_pedidos_a_autorizar',
        'can' => 'responsavel_centro_despesa',
    ],
];

$right_menu = [
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'target' => '_blank',
        'url' => config('app.url') . '/settings',
        'align' => 'right',
        'can' => 'admin',
    ],
    [
        'text' => '<i class="fas fa-user-shield"></i>',
        'title' => 'Admin',
        'target' => '_blank',
        'url' => config('app.url') . '/loginas',
        'align' => 'right',
        'can' => 'admin',
    ],
    [
        'text' => '<i class="fas fa-hard-hat"></i>',
        'title' => 'Logs',
        'target' => '_blank',
        'url' => config('app.url') . '/logs',
        'align' => 'right',
        'can' => 'admin',
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
