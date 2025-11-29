<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_text',
        'order',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function voteCount(): int
    {
        return $this->responses()->count();
    }

    public function votePercentage(): float
    {
        $totalVotes = $this->question->responses()->count();

        if ($totalVotes === 0) {
            return 0;
        }

        return ($this->voteCount() / $totalVotes) * 100;
    }
}
