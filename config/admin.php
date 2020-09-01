<?php

return [

    'adapters' => [
        'app-model-role' => OrmBackend\Admin\Adapters\RoleAdapter::class,
        'app-model-user' => OrmBackend\Admin\Adapters\UserAdapter::class,
        'app-model-image' => OrmBackend\Admin\Adapters\ImageAdapter::class,
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
            'edit' => 'ormbackend::admin.role.edit',
            'create' => 'ormbackend::admin.role.create'
        ],
        'it_aces-oauth-entities-client' => [
            'create' => 'oauth::client.create'
        ],
    ]
    
];
