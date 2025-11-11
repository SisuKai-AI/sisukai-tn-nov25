<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Facades\Purifier;

class HelpArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'order',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns this article
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'category_id');
    }

    /**
     * Increment the views counter
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Set the content attribute with HTML sanitization
     */
    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = Purifier::clean($value);
    }

    /**
     * Get sanitized content (additional layer of security)
     */
    public function getSanitizedContentAttribute(): string
    {
        return Purifier::clean($this->content);
    }

    /**
     * Get all feedback for this article
     */
    public function feedback()
    {
        return $this->hasMany(HelpArticleFeedback::class, 'help_article_id');
    }

    /**
     * Get helpful feedback count
     */
    public function getHelpfulCountAttribute(): int
    {
        return $this->feedback()->where('is_helpful', true)->count();
    }

    /**
     * Get not helpful feedback count
     */
    public function getNotHelpfulCountAttribute(): int
    {
        return $this->feedback()->where('is_helpful', false)->count();
    }
}
