<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'domain_id',
        'name',
        'description',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the domain that owns the topic.
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Get the questions for the topic.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the certification through the domain.
     */
    public function certification()
    {
        return $this->domain->certification();
    }

    /**
     * Scope a query to order topics by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

