<?php

namespace Core45\SystemSettingsDb\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'key',
        'value',
        'description',
    ];
}
