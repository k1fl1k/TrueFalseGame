<?php

namespace k1fl1k\truefalsegame\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'started_at', 'ended_at'
    ];

    /**
     * Відношення до користувача, який створив гру
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
