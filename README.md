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

Once that's complete, publish the migrations using:

```php
php artisan vendor:publish --tag="setting"
```

Then run `php artisan migrate`.

