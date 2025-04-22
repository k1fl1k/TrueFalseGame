<div class="profile-header">
    <div class="profile-circle">
        <img src="{{ $user->avatar }}" alt="User Avatar">
    </div>
    <div>
        <h2>{{ $user->username }}</h2>
        <p class="text-gray-400">role: {{ $user->role }}</p>
    </div>

    <!-- Кнопка налаштувань (тільки для власника профілю) -->
    @if(auth()->id() === $user->id)
        <div class="settings">
            <a href="{{ route('settings.show') }}" class="profile-settings-btn">Settings</a>
        </div>
    @endif
</div>
