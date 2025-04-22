<x-app-layout>
    <x-slot name="title">Користувачі</x-slot>

    <div class="main">
        <div class="content">
            <div class="profile-header">
                <p class="admin-subinfo">Загальний список користувачів</p>
                <a href="{{ route('admin.panel') }}">На головну</a>
            </div>

            <div class="user-list">
                <table class="min-w-full divide-y divide">
                    <thead class="bg-[#121212]">
                    <tr>
                        <th class="px-4 py-2 text-left">Ім’я користувача</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Роль</th>
                        <th class="px-4 py-2 text-left">Дата створення</th>
                        <th class="px-4 py-2 text-left">Дії</th>
                    </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->username }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1 bg-gray-800">
                                        <option value="user" @selected($user->role === 'user')>Користувач</option>
                                        <option value="admin" @selected($user->role === 'admin')>Адмін</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-2">{{ $user->created_at->format('d.m.Y') }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цього користувача?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Видалити
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- Пагінація -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
