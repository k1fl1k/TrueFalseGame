<?php

namespace k1fl1k\truefalsegame\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }
}
