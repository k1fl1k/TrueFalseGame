<?php

namespace k1fl1k\truefalsegame\App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use k1fl1k\truefalsegame\Models\Like;
use Livewire\Component;

class FavoriteGamesForm extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $likes = Like::where('user_id', $this->user->id)
            ->with('game.user')
            ->latest()
            ->get();

        return view('livewire.profile.favorite-games-form', [
            'likes' => $likes,
        ]);
    }
}
