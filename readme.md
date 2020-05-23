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


