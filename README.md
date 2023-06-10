# system-settings-db

Very simple of storing a settings for your Laravel project in the database.

## Installation

Install the package with composer:
```bash
composer require core45/system-settings-db
```

Publish the package files:
```
php artisan vendor:publish --provider="Core45\SystemSettingsDb\SystemSettingsDbServiceProvider"
```

Migrate the database:
```
php artisan migrate
```

## Usage

### Setting a value
In the database you can set a value for a key. The key is a string and the value can be a string, integer or boolean.

To access the value os a key you can use the `config()` helper function.

```php
config('system-settings-db.key');
```

## License
MIT
