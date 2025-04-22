<?php

namespace k1fl1k\truefalsegame\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;
use App\Http\Requests\Storetruth_or_lie_gameRequest;
use App\Http\Requests\Updatetruth_or_lie_gameRequest;

class TruthOrLieGameController extends Controller
{
    public function index()
    {
        $games = TruthOrLieGame::with('user')->latest()->get();

        return view('truth-or-lie.gamehub', compact('games'));
    }

    // Показ форми створення
    public function create()
    {
        return view('truth-or-lie.create');
    }

    // Обробка створення гри
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'statements' => 'required|array|min:1',
            'statements.*.statement' => 'required|string',
            'statements.*.is_true' => 'required|boolean',
        ]);

        $game = TruthOrLieGame::create([
            'id' => Str::ulid(),
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_public' => $validated['is_public'] ?? false,
            'game_data' => json_encode($validated['statements']), // Laravel сам кастує в JSON
        ]);

        return redirect()->route('truth-or-lie.show', $game->id)
            ->with('success', 'Гру створено!');
    }

    // Показ конкретної гри
    public function show($id)
    {
        // Отримати бали перед очищенням
        $score = session("score_$id");
        $questionIndex = session("question_index_$id");

        // Очистити
        session()->forget("score_$id");
        session()->forget("question_index_$id");

        $game = TruthOrLieGame::findOrFail($id);

        $comments = $game->comments()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('truth-or-lie.show', compact('game', 'comments', 'score', 'questionIndex'));
    }


    public function play($id)
    {
        $game = TruthOrLieGame::findOrFail($id);
        $questions = json_decode($game->game_data);

        $index = session("question_index_{$id}", 0);
        $score = session("score_{$id}", 0);

        // Перевірка виходу за межі
        if ($index >= count($questions)) {
            return redirect()->route('truth-or-lie.show', $id)
                ->with('success', "Гру завершено. Ваш бал: $score");
        }

        $question = $questions[$index];

        return view('truth-or-lie.play', compact('game', 'question', 'index', 'score'));
    }

    public function submitAnswer(Request $request, TruthOrLieGame $game)
    {
        $request->validate([
            'answer' => 'required|boolean',
        ]);

        $index = session("question_index_{$game->id}", 0);
        $questions = json_decode($game->game_data);

        $question = $questions[$index];

        if ($question->is_true == $request->answer) {
            session(["score_{$game->id}" => session("score_{$game->id}", 0) + 1]);
        }

        session(["question_index_{$game->id}" => $index + 1]);

        return redirect()->route('truth-or-lie.play', $game->id);
    }

    public function togglePublic($id)
    {
        $game = TruthOrLieGame::findOrFail($id);

        if (auth()->id() !== $game->user_id) {
            abort(403, 'У вас немає прав для цієї дії.');
        }

        $game->is_public = !$game->is_public;
        $game->save();

        return back()->with('success', 'Статус публічності оновлено!');
    }

}
