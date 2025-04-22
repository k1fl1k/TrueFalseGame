<?php

namespace k1fl1k\truefalsegame\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;

class LikeController extends Controller
{
    public function toggle(TruthOrLieGame $game)
    {
        $userId = Auth::id();

        $like = Like::where('user_id', $userId)->where('game_id', $game->id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'id' => (string) Str::ulid(),
                'user_id' => $userId,
                'game_id' => $game->id,
                'state' => "like",
            ]);
        }

        return back();
    }
}
