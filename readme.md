# Admin Panel from IT Aces team for Laravel Framework with Doctrine ORM

## Dependencies

 * [it-aces/laravel-doctrine](https://bitbucket.org/vitaliy_kovalenko/laravel-doctrine/src/master/)
 * [it-aces/laravel-doctrine-acl](https://bitbucket.org/vitaliy_kovalenko/laravel-doctrine-acl/src/master/)

If you are building an application from scratch you may need to install the [it-aces/laravel-doctrine-web](https://bitbucket.org/vitaliy_kovalenko/laravel-doctrine-web/src/master/). It contains basic controllers and resources for registration and authorization. In other case your application must have implemented login page.

## Install

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

If you have not previously installed the [it-aces/laravel-doctrine-web](https://bitbucket.org/vitaliy_kovalenko/laravel-doctrine-web/src/master/) package, do it now. See the installation instructions for the required packages for how to install and compile them.

```BASH
composer require it-aces/laravel-doctrine-web
```

```BASH
composer require it-aces/laravel-doctrine-admin
```

* Publising

```BASH
php artisan vendor:publish --provider="ItAces\Admin\PackageServiceProvider"
```

## Setting up

config/app.php

```BASH
//Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
LaravelDoctrine\ORM\Auth\Passwords\PasswordResetServiceProvider::class,
```

```BASH
ItAces\ORM\DoctrineServiceProvider::class,
LaravelDoctrine\Extensions\BeberleiExtensionsServiceProvider::class,
```


