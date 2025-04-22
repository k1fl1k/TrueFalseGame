<x-app-layout>
    <x-slot name="title">Admin Panel</x-slot>

    <div class="main">
        <div class="content">
            <div class="game-view">
                <!-- Sidebar -->
                <div class="profile-header">
                    <h1 class="admin-info">Панель адміністратора</h1>
                    <p class="admin-subinfo">Вітаємо, {{ Auth::user()->username }}!</p>
                </div>

                <!-- Main Content -->
                <div class="dashboard">
                    <div class="dashboard-statistics">
                        <div class="stat-box">
                            <h3>Користувачі</h3>
                            <p>{{ $userCount }} користувачів</p>
                        </div>
                        <div class="stat-box">
                            <h3>Загальний трафік</h3>
                            <p>{{ $trafficData }} візитів</p>
                        </div>
                        <div class="stat-box">
                            <h3>Ігрові сеанси</h3>
                            <p>{{ $activeGames }} активних ігор</p>
                        </div>
                    </div>

                    <!-- Admin Links -->
                    <div class="admin-links">
                        <div class="link-box">
                            <a href="{{ route('admin.users') }}" class="btn-link">
                                <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                </svg>
                                Користувачі
                            </a>
                        </div>
                        <div class="link-box">
                            <a href="{{ route('admin.content') }}" class="btn-link">
                                <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                                </svg>
                                Контент
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <h2>Остання активність</h2>
                        <ul>
                            @foreach($recentActivities as $activity)
                                <li>{{ $activity->description }} <span class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
