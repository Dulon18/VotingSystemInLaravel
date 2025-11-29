<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slug',
        'is_public',
        'is_anonymous',
        'allow_multiple_votes',
        'require_email',
        'show_results_before_vote',
        'randomize_options',
        'password',
        'start_date',
        'end_date',
        'status',
        'max_votes',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_anonymous' => 'boolean',
        'allow_multiple_votes' => 'boolean',
        'require_email' => 'boolean',
        'show_results_before_vote' => 'boolean',
        'randomize_options' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(PollInvitation::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PollComment::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(PollShare::class);
    }
}
