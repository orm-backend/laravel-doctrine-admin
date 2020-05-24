<?php

return [

    'adapters' => [
        App\Model\Role::class => ItAces\Admin\Adapters\RoleAdapter::class,
        App\Model\User::class => ItAces\Admin\Adapters\UserAdapter::class,
        App\Model\Image::class => ItAces\Admin\Adapters\ImageAdapter::class,
    ],

    'icons' => [
        'dashboard' => 'flaticon2-architecture-and-city',
        'entities' => 'flaticon2-menu-4'
    ],

    'views' => [
        'app-model-role' => [
            'edit' => 'itaces::admin.role.edit',
            'create' => 'itaces::admin.role.create'
        ]
    ]
    
];
