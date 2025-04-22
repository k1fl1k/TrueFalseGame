<?php

namespace k1fl1k\truefalsegame\Http\Controllers;

use Illuminate\Http\Request;
use k1fl1k\truefalsegame\Models\ActivityLog;
use k1fl1k\truefalsegame\Models\GameSession;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;
use k1fl1k\truefalsegame\Models\User;

class AdminController extends Controller
{
    /**
     * Діє тільки для адміністраторів
     */
    public function __construct()
    {
        // Middleware для аутентифікації
        $this->middleware('auth');
    }

    /**
     * Відображення панелі адміністратора
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Отримуємо статистику
        $userCount = User::count(); // Кількість користувачів
        $trafficData = 1200; // Трафік (можна замінити реальними даними)
        $activeGames = GameSession::where('status', 'active')->count(); // Кількість активних ігор

        // Остання активність
        $recentActivities = ActivityLog::latest()->take(5)->get(); // Останні 5 активностей

        return view('admin.panel', [
            'userCount' => $userCount,
            'trafficData' => $trafficData,
            'activeGames' => $activeGames,
            'recentActivities' => $recentActivities
        ]);
    }

    private function middleware(string $string)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return true;
        }
        else{
            return redirect()->route('truth-or-lie.gamehub');
        }
    }

    /**
     * Керування користувачами
     *
     * @return \Illuminate\View\View
     */
    public function manageUsers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10); // або будь-яке число
        return view('admin.users', compact('users'));
    }


    public function manageContent()
    {
        $games = TruthOrLieGame::with('user')->latest()->paginate(10);
        return view('admin.content', compact('games'));
    }

    /**
     * Налаштування адміністратора
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Логіка для налаштувань адміністратора
        return view('admin.settings');
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,moderator,admin',
        ]);

        $user->role = $request->input('role');
        $user->save();

        return back()->with('success', 'Роль оновлено успішно.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return back()->with('success', 'Користувача видалено.');
    }

    public function destroyGame($id)
    {
        $game = TruthOrLieGame::findOrFail($id);
        $game->delete();

        return redirect()->route('admin.content')->with('success', 'Гру успішно видалено.');
    }

}
