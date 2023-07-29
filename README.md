# system-settings-db

Very simple package for storing settings for your Laravel project in the database.

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
After migrating the new table system_settings will be created in the database. The package doesn't provide a UI for managing the settings. You have to add/modify/delete the records on your own.
The important columns are:
- key: the key of the setting
- value: the value of the setting

The other columns are for your convenience. You can also add your own columns to the table if you like.

### Setting a value
In the database you can set a value for a key. The key is a string and the value can be a string, integer or boolean.

To access the value of a key you can use the `config()` helper function.

```php
config('system-settings.some-key');
```
So for example in your blade template you can use your contact email you previously stored in the settings table:
```php
My email is: <a href="mailto:{{ config('system-settings.email') }}">{{ config('system-settings.email') }}</a>
```

## License
MIT
