<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
    ];

    /**
     * Get all articles in this category
     */
    public function articles(): HasMany
    {
        return $this->hasMany(HelpArticle::class, 'category_id')->orderBy('order');
    }

    /**
     * Get featured articles in this category
     */
    public function featuredArticles(): HasMany
    {
        return $this->hasMany(HelpArticle::class, 'category_id')
            ->where('is_featured', true)
            ->orderBy('order');
    }
}
