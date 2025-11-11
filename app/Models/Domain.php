<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'certification_id',
        'name',
        'description',
        'weight_percentage',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight_percentage' => 'decimal:2',
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the certification that owns the domain.
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get the topics for the domain.
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Get all questions for this domain through topics.
     */
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Topic::class);
    }

    /**
     * Scope a query to order domains by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

