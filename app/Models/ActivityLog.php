<?php

namespace k1fl1k\truefalsegame\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'description'
    ];

    /**
     * Відношення до користувача
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
