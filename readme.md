# Admin Panel from IT Aces team for Laravel Framework with Doctrine ORM

![Screenshot](Screenshot.png)

## Dependencies

 * [vvk/laravel-doctrine](https://github.com/vvk-kolsky/laravel-doctrine)
 * [vvk/laravel-doctrine-acl](https://github.com/vvk-kolsky/laravel-doctrine-acl)

If you are building an application from scratch you may need to install the [vvk/laravel-doctrine-web](https://github.com/vvk-kolsky/laravel-doctrine-web). It contains basic controllers and resources for registration and authorization. In other case your application must have implemented login page.

## Install

* Add composer repositories

```BASH
"repositories": [
	{
       "type": "vcs",
       "url": "git@github.com:vvk-kolsky/laravel-doctrine.git"
    },
    {
       "type": "vcs",
       "url": "git@github.com:vvk-kolsky/laravel-doctrine-acl.git"
    },
    {
       "type": "vcs",
       "url": "git@github.com:vvk-kolsky/laravel-doctrine-web.git"
    },
    {
       "type": "vcs",
       "url": "git@github.com:vvk-kolsky/laravel-doctrine-admin.git"
    }
]
```

* Install packages

If you have not previously installed the [vvk/laravel-doctrine-web](https://github.com/vvk-kolsky/laravel-doctrine-web) package, do it now. See the installation instructions for the required packages for how to install and compile them.

```BASH
composer require vvk/laravel-doctrine-web
```

```BASH
composer require vvk/laravel-doctrine-admin
```

* Publising

```BASH
php artisan vendor:publish --provider="VVK\Admin\PackageServiceProvider"
```

## Setting up

config/app.php

```BASH
//Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
LaravelDoctrine\ORM\Auth\Passwords\PasswordResetServiceProvider::class,
```

```BASH
VVK\ORM\DoctrineServiceProvider::class,
LaravelDoctrine\Extensions\BeberleiExtensionsServiceProvider::class,
```


