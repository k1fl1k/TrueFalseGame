<?php

namespace k1fl1k\truefalsegame\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use k1fl1k\truefalsegame\Models\User;

class Like extends Model
{
    /** @use HasFactory<\Database\Factories\LikeFactory> */
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'game_id', 'state'];

    public function likes()
    {
        return $this->hasMany(Like::class, 'game_id'); // або 'truth_or_lie_game_id' якщо так називається колонка
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(TruthOrLieGame::class, 'game_id'); // змінити 'game_id' на правильне ім’я стовпця
    }
}
