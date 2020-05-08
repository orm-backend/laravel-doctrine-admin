<?php

return [

    'adapters' => [
        App\Model\User::class => ItAces\Admin\Adapters\UserAdapter::class,
        App\Model\Image::class => ItAces\Admin\Adapters\ImageAdapter::class,
    ],

];
