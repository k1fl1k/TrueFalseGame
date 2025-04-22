<?php

namespace k1fl1k\truefalsegame\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TruthOrLieGame $game)
    {
        $request->validate([
            'body' => 'required',
        ]);

        Comment::create([
            'id' => (string) Str::ulid(),
            'user_id' => Auth::id(),
            'game_id' => $game->id,
            'body' => $request->body,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, TruthOrLieGame $game)
    {
        // Перевіряємо, чи коментар належить вказаній роботі
        if ($comment->game_id !== $game->id) {
            return back()->with('error', 'Коментар не належить цій роботі.');
        }

        // Видалення доступне автору коментаря або адміну
        if ($comment->user_id === Auth::id() || Auth::user()->isAdmin()) {
            $comment->delete();
            return back()->with('success', 'Коментар видалено.');
        }

        return back()->with('error', 'Ви не маєте прав для видалення цього коментаря.');
    }
}
