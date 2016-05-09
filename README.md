# Setting



## Installation

Insert Authorization in your `composer.json` file:

```json
"larapacks/setting": "1.0.*"
```

Then run `composer update`.

Insert the service provider in your `config/app.php` file:

```php
Larapacks\Setting\SettingServiceProvider::class,
```

Once that's complete, publish the migrations using:

```php
php artisan vendor:publish --tag="setting"
```

Then run `php artisan migrate`.

