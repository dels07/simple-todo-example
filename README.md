# Simple Todo Example

## Description

Clone of [www.angulartodo.com](http://www.angulartodo.com)

## Requirements

-   PHP 7
-   Composer

## Installation

-   Git clone this repo

```
$ git clone https://github.com/dels07/simple-todo-example.git
```

-   Install dependencies

```
$ cd simple-todo-example
$ composer install
```

-   Setup environment variable in `.env`

```
$ cp .env.example .env
```

> Note: please setup your [database environment](https://laravel.com/docs/6.x/database) if you use mysql/postgre, default using sqlite

-   Run migration

```
$ php artisan migrate
```

-   Run development server

```
$ php artisan serve
```

-   Open browser at [127.0.0.1:8000](http://127.0.0.1:8000/)
