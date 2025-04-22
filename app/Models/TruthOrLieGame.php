<?php

namespace k1fl1k\truefalsegame\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class TruthOrLieGame extends Model
{
    use HasUlids, HasFactory;

    protected $table = 'truth_or_lie_games';

    // Add this line to set the keyType to string for ULIDs
    protected $keyType = 'string';

    // Prevent auto-incrementing if using ULID
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_public', 'image', 'game_data'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'game_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'game_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'game_id');
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}

