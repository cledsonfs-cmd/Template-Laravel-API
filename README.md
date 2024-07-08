<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Description


[Template-Laravel-API](https://github.com/cledsonfs-cmd/Template-Laravel-API): TTemplate para o desenvolvimento de APIs com base no framework Laravel.

## Technologies used
- [PHP 8.1](https://www.php.net/)
- [Laravel 10.10](https://laravel.com/)
- [darkaonline/l5-swagger 8.6](https://packagist.org/packages/darkaonline/l5-swagger)
- [guzzlehttp/guzzle 7.2](https://docs.guzzlephp.org/en/stable/overview.html)
- [laravel/sanctum 3.3](https://laravel.com/docs/11.x/sanctum)
- [laravel/tinker 2.8](https://laravel.com/docs/11.x/artisan)
- [php-open-source-saver/jwt-auth 2.5](https://laravel-jwt-auth.readthedocs.io/en/latest/)

## Installation

```bash
$ php artisan serve
```
```bash
$ php artisan make:model Role --migration
```
```bash
$ php artisan migrate
```
```bash
$ php artisan migrate:refresh
```
```bash
$ composer require php-open-source-saver/jwt-auth
```
```bash
$ php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```
```bash
$ php artisan jwt:secret
```
```bash
$ php artisan make:controller AuthController
```
```bash
$ composer require DarkaOnLine/L5-Swagger
```
```bash
$ php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```
```bash
$ php artisan l5:generate
```
```bash
$ composer install --ignore-platform-reqs
```
```bash
$ sudo apt install php8.2-sqlite3
```
```bash
$ php artisan jwt:secret
```

## Running the app

```bash
$ php artisan serve
```

## Debug

```bash
$ sudo apt-get install php8.1-xdebug
```

### Documentation

* Swagger: [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)


## Stay in touch

- Author - [Cledson Francisco Silva](https://www.linkedin.com/in/cledson-francisco-silva-32737a2a/)
- E-mail - [cledsonfs@gmail.com](mailto:cledsonfs@gmail.com)
