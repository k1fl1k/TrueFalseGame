<x-app-layout>
    <x-slot name="title">Керування контентом</x-slot>

    <div class="main">
        <div class="content">
            <div class="profile-header">
                <p class="admin-subinfo">Редагування, видалення або створення нового контенту</p>
                <a href="{{ route('admin.panel') }}">На головну</a>
            </div>

            <div class="mt-6">
                @if($games->isEmpty())
                    <p class="text-gray-600">Наразі немає жодної гри.</p>
                @else
                    <table class="min-w-full bg-[#121212] shadow rounded overflow-hidden">
                        <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-4 text-left">Назва</th>
                            <th class="py-2 px-4 text-left">Опис</th>
                            <th class="py-2 px-4 text-left">Автор</th>
                            <th class="py-2 px-4">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($games as $game)
                            <tr class="border-b hover:bg-gray-500">
                                <td class="py-2 px-4">{{ $game->title }}</td>
                                <td class="py-2 px-4 text-sm text-gray-600">{{ Str::limit($game->description, 80) }}</td>
                                <td class="py-2 px-4">{{ $game->user->username ?? 'Невідомо' }}</td>
                                <td class="py-2 px-4 text-center">
                                    <a href="{{ route('truth-or-lie.show', $game->id) }}" class="text-blue-600 hover:underline">Переглянути</a>

                                    <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Ви впевнені, що хочете видалити цю гру?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $games->links() }} {{-- Пагінація --}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
