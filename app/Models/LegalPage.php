<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'is_published',
        'version',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope to get only published pages
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
