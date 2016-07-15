# Setting

[![Build Status](https://img.shields.io/travis/larapacks/setting/master.svg?style=flat-square)](https://travis-ci.org/larapacks/setting)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/larapacks/setting/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/larapacks/setting/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/larapacks/setting.svg?style=flat-square)](https://packagist.org/packages/larapacks/setting)
[![Latest Stable Version](https://img.shields.io/packagist/v/larapacks/setting.svg?style=flat-square)](https://packagist.org/packages/larapacks/setting)
[![License](https://img.shields.io/packagist/l/larapacks/setting.svg?style=flat-square)](https://packagist.org/packages/larapacks/setting)

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

Insert the facade in your `aliases` array in your `config/app.php` file
(only if you're going to utilize it):

```php
'Setting' => Larapacks\Setting\Facades\Setting::class
```

Once that's complete, publish the migration and configuration file using:

```php
php artisan vendor:publish --tag="setting"
```

Then run `php artisan migrate`.

## Usage

Setting a value:

```php
Setting::set('key', 'value');
```

Setting multiple values:

```php
Setting::set([
    'key.1' => 'value',
    'key.2' => 'value',
    'key.3' => 'value',
]);
```

Retrieving a value:

```php
$value = Setting::get('key.1');

dd($value); // Returns 'value'
```

Retrieving the Setting model for a particular key:

```php
$model = Setting::find('key.1');

dd($model); // Reurns instance of Model (your configured model).
```

Retrieving all keys with values:

```php
Setting::set([
    'key.1' => 'value',
    'key.2' => 'value',
    'key.3' => 'value',
]);

$settings = Setting::all();

dd($settings);

// Returns:
// array [
//  'key.1' => 'value',
//  'key.2' => 'value',
//  'key.3' => 'value',
// ]
```

Retrieving the your configured Setting model:

```php
$model = Setting::model();

$setting = new $model;

$setting->key = 'key';
$setting->value = 'value';

$setting->save();
```

Determining if a setting exists:

```php
if (Setting::has('key')) {
    // The setting exists.
}
```
