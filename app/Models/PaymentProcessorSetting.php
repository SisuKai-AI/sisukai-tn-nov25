<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProcessorSetting extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    protected $fillable = [
        'processor',
        'is_active',
        'is_default',
        'config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'config' => 'array',
    ];

    public static function getDefault()
    {
        return static::where('is_default', true)->where('is_active', true)->first();
    }

    public static function getActive()
    {
        return static::where('is_active', true)->get();
    }
}
