<?php

return [

    'adapters' => [
        'app-model-role' => ItAces\Admin\Adapters\RoleAdapter::class,
        'app-model-user' => ItAces\Admin\Adapters\UserAdapter::class,
        'app-model-image' => ItAces\Admin\Adapters\ImageAdapter::class,
    ],

    'icons' => [
        'dashboard' => 'flaticon2-architecture-and-city',
        'entity' => 'flaticon2-menu-4',
        'oauth' => 'flaticon2-shield',
        'file' => 'flaticon2-file',
        'user' => 'flaticon2-user',
    ],

    'views' => [
        'app-model-role' => [
            'edit' => 'itaces::admin.role.edit',
            'create' => 'itaces::admin.role.create'
        ],
        'it_aces-oauth-entities-client' => [
            'create' => 'oauth::client.create'
        ],
    ]
    
];
