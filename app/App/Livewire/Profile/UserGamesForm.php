<?php

namespace k1fl1k\truefalsegame\App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;
use Livewire\Component;

class UserGamesForm extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $games = TruthOrLieGame::where('user_id', $this->user->id)
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.profile.user-games-form', [
            'games' => $games,
        ]);
    }
}
