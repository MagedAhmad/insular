# Insular

Insular is a software architecture to build scalable Laravel projects in a modern, clear and modular way. 

**Insular** is latin word which means "_Having a narrow view of the world._" and that is how modules are suppose to be structured. 🔥🔥

## Table of contents 

- [Installation](#Installation) 
- [Snowflake](#snowflake) 
- [Available commands](#available-commands) 
- [Managing Modules](#modules) 
- [Managing Features](#features) 
- [Managing Operations](#operations) 
- [Managing Jobs](#jobs) 
- [Managing Controllers](#controllers) 
- [Managing Migrations](#migrations) 
- [Managing Models](#models) 
- [Managing Resources](#resources) 
- [Managing Requests](#requests) 
- [Managing Types](#types) 
- [Managing Exception](#exception) 

## Installation

You can install the package via composer:

```bash
composer require MagedAhmad/insular
```

## Snowflake

We use snowflake for ids, by default newly created models with the custom command will use the `Snowflake` trait. you can [read more about snowflake here](https://medium.com/m/global-identity?redirectUrl=https%3A%2F%2Fitnext.io%2Fhow-to-use-twitter-snowflake-ids-for-your-database-primary-keys-in-laravel-763a98e78466)

## Available commands

| Target | Command |
|---|---|
| Create new module | php artisan create:module $name |
| Create new feature | php artisan create:feature $name $module |
| Create new operation | php artisan create:operation $name $module |
| Create new job | php artisan create:job $name $module |
| Create new controller | php artisan create:controller $name $module |
| Create new migration | php artisan create:migration $name $module |
| Create new model | php artisan create:model $name $module |
| Create new type | php artisan create:type $name $module |
| Create new resource | php artisan create:resource $name $module |
| Create new request | php artisan create:request $name $module |
| Create new exception | php artisan create:exception $name $module |

## Modules

You start by building the main block in your application which is a `Module`.

Modules are like mini laravel applications where each module contains everything needed to build this module.

```php
php artisan create:module $name 
```

example:

```php
php artisan create:module Auth
```


this will create module structure in `Modules\Auth`

## Features

Feature can be used when you have multiple operations related to some action and you would repeat these operations more than once, so you can create a feature and reuse it later on.

```php
php artisan create:feature $name $module 
```

example:

```php
php artisan create:feature LoginUserFeature Auth
```

this will create feature in `Modules\Auth\Features\LoginUserFeature`

## Operations

Operation is the main building block where most logic would go, it might contain multiple jobs.

```php
php artisan create:operation $name $module
```

example:

```
php artisan create:operation LoginUserOperation Auth
```

this will create file in `Modules\Auth\Operations\LoginUserOperation`

## Jobs

Jobs are the smallest unit on our system. you can use it to avoid duplication of small shrunks of code . you should only use it when you are sure that you would use it multiple times, otherwise operation should be just fine to hold the logic in it.

```php
php artisan create:job $name $module
```

example:

```
php artisan create:job LoginUserJob Auth
```

this will create file in `Modules\Auth\Jobs\LoginUserJob`

## Controllers

```php
php artisan create:controller $name $module
```

example:

```
php artisan create:controller LoginController Auth
```

this will create file in `Modules\Auth\Http\Controllers\LoginController`

## Migrations

you only need to write the migration name like `users`, `products`, `categories`, no need to type `create_users_table` .

```php
php artisan create:migration $name $module
```

example:

```
php artisan create:migration users Auth
```

this will create file in `Modules\Auth\database\migrations\users`

## Models

Models use `snowflake` trait by default

```php
php artisan create:model $name $module
```

example:

```
php artisan create:model User Auth
```

this will create file in `Modules\Auth\Models\User`

## Resources

Resources can be used to map data before sending in the response .

```php
php artisan create:resource $name $module
```

example:

```
php artisan create:resource UserResource Auth
```

this will create file in `Modules\Auth\Http\Controllers\Resource\UserResource`

## Requests

can be used for validating incoming request data .

```php
php artisan create:request $name $module
```

example:

```
php artisan create:request UserRequest Auth
```

this will create file in `Modules\Auth\Http\Controllers\Requests\UserRequest`

## Types

Types can be used for internal handling of data between classes 

```php
php artisan create:type $name $module
```

example:

```
php artisan create:type UserData Auth
```

this will create file in `Modules\Auth\Types\UserData`

## Exception

```php
php artisan create:exception $name $module
```

example:

```
php artisan create:exception UserNotFoundException Auth
```

this will create file in `Modules\Auth\Exceptions\UserNotFoundException`

### Testing

```bash
vendor/bin/pest 
```

### TODO

1- Work on a global response for all requests.
2- Provide easy way to test/view apis.
3- Switch between Pest and phpunit

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Maged Ahmed](https://github.com/MagedAhmad)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
