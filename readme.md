# Admin Panel from IT Aces team for Laravel Framework with Doctrine ORM

## Requirements

* it-aces/laravel-doctrine
* it-aces/laravel-doctrine-acl

If you are building an application from scratch you may need to install the **it-aces/laravel-doctrine-web package**. It contains basic controllers and resources for registration and authorization. In other case your application must have implemented login page.

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
       "url": "git@bitbucket.org:vitaliy_kovalenko/laravel-doctrine-web.git"
    },
    {
       "type": "vcs",
       "url": "git@bitbucket.org:vitaliy_kovalenko/laravel-doctrine-admin.git"
    }
]
```

* Install packages

```BASH
composer require it-aces/laravel-doctrine-web
```

See the installation instructions for the required packages for how to install and compile them.

```BASH
composer require it-aces/laravel-doctrine-admin
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
php artisan serve
```


