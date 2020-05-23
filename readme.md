# Admin Panel for Laravel Framework with Doctrine ORM

## Requirements

* laravel-ui
* it-aces/laravel-doctrine
* it-aces/laravel-doctrine-acl

## Installation

* Add composer repositories

```BASH
"repositories": [
	{
       "type": "vcs",
       "url": "git@bitbucket.org:vitaliy_kovalenko/laravel-doctrine.git"
    },
    {
       "type": "vcs",
       "url": "git@bitbucket.org:vitaliy_kovalenko/laravel-doctrine-acl.git"
    },
    {
       "type": "vcs",
       "url": "git@bitbucket.org:vitaliy_kovalenko/laravel-doctrine-admin.git"
    }
]
```

* Install packages

```BASH
composer require it-aces/laravel-doctrine-admin
```

```BASH
npm install cross-env
npm install bootstrap
```

* Publising

```BASH
php artisan vendor:publish --provider="ItAces\Admin\PackageServiceProvider"
```

## Configuration

config/app.php

```BASH
//Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
LaravelDoctrine\ORM\Auth\Passwords\PasswordResetServiceProvider::class,
```

```BASH
ItAces\ORM\DoctrineServiceProvider::class,
LaravelDoctrine\Extensions\BeberleiExtensionsServiceProvider::class,
```
routes/web.php

```BASH
Auth::routes(['verify' => true])
```

.env

```BASH
DOCTRINE_PROXY_AUTOGENERATE=1
DOCTRINE_CACHE=file
DOCTRINE_RESULT_CACHE=array
DOCTRINE_SECOND_CACHE_TTL=3600
DOCTRINE_RESULT_CACHE_TTL=120
```

## Start

```BASH
npm run dev
php artisan serve
```


