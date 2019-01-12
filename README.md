# Cotton Road
&#x1f48a; Inventory management system for drugs &#x1f489;

## Initial setup

```bash
$ cp .env.example .env
$ composer install
$ php artisan key:generate
$ touch database/database.sqlite
$ php artisan migrate --seed
$ php artisan serve
```

## DB Rebuilding

```bash
$ php artisan migrate:fresh --seed
```

## Dev account information

|Type|User ID|Password|
|:--|:--|:--|
|admin|admin|password|
|employee|employee|password|
|seller|seller|password|
|customer|customer|password|

* Employee has some of the authority of admin.