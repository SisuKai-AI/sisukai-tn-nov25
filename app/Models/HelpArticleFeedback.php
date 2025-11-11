<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpArticleFeedback extends Model
{
    use HasFactory;

    protected $table = 'help_article_feedback';

    protected $fillable = [
        'help_article_id',
        'session_id',
        'is_helpful',
        'comment',
        'ip_address',
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    /**
     * Get the article that owns this feedback
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(HelpArticle::class, 'help_article_id');
    }
}
