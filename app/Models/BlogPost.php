<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BlogPost extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_description',
        'meta_keywords',
        'status',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the category that owns the blog post
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Get the author that owns the blog post
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope to get only published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope to get draft posts
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Get the content as HTML (supports both Markdown and HTML)
     */
    public function getContentHtmlAttribute()
    {
        // Check if content starts with markdown indicators
        if ($this->isMarkdown()) {
            return $this->parseMarkdown($this->content);
        }
        
        // Return as-is if it's HTML
        return $this->content;
    }

    /**
     * Check if content is Markdown
     */
    protected function isMarkdown()
    {
        // Check for common markdown patterns
        $markdownPatterns = [
            '/^#{1,6}\s/',           // Headers
            '/\*\*.*?\*\*/',        // Bold
            '/_.*?_/',               // Italic
            '/\[.*?\]\(.*?\)/',     // Links
            '/^\*\s/',               // Unordered lists
            '/^\d+\.\s/',           // Ordered lists
            '/```/',                 // Code blocks
            '/^>\s/',                // Blockquotes
        ];

        foreach ($markdownPatterns as $pattern) {
            if (preg_match($pattern, $this->content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Parse Markdown to HTML
     */
    protected function parseMarkdown($markdown)
    {
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownConverter($environment);

        return $converter->convert($markdown)->getContent();
    }
}
