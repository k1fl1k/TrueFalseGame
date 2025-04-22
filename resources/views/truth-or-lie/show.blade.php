<x-app-layout>
    <div class="content">
        <div class="main">
            <div class="game-view">
                <div class="profile-header">
                    <a class="flex">
                        <img src="{{ $game->user->avatar }}" class="w-12 h-12 rounded-full" alt="{{ $game->user->username }}">
                        <div>
                            <h2 class="text-lg font-semibold">{{ $game->user->username }}</h2>
                            <p class="text-sm text-gray-500">Автор гри</p>
                        </div>
                        @if(Auth::id() === $game->user->id)
                            <form method="POST" action="{{ route('truth-or-lie.toggle-public', $game->id) }}" class="ml-4">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 rounded bg-{{ $game->is_public ? 'green' : 'gray' }}-600 text-white text-sm hover:bg-opacity-80">
                                    {{ $game->is_public ? 'Зробити приватною' : 'Зробити публічною' }}
                                </button>
                            </form>
                        @endif
                    </a>
                </div>

                <div class="game-preview mb-6">
                    @if ($game->image)
                        <img src="{{ asset($game->image) }}" alt="Game preview" class="w-full max-w-xl mx-auto rounded shadow-md">
                    @else
                        <div class="w-full max-w-xl mx-auto aspect-video bg-gray-700 rounded shadow-md flex items-center justify-center text-white text-sm">
                        </div>
                    @endif
                    <h1 class="text-2xl font-bold mt-4 text-center">{{ $game->title }}</h1>
                    <p class="mt-2 text-gray-600 text-center">{{ $game->description }}</p>

                        @if (!is_null($score) && !is_null($questionIndex))
                            <div class="text-center text-lg font-semibold text-green-700 mb-4">
                                Ви набрали {{ $score }} з {{ $questionIndex }} балів 🎉
                            </div>
                        @endif
                </div>


                <div class="mb-6">
                    <a href="{{ route('truth-or-lie.play', $game->id) }}" class="button btn-gold w-full">
                        ▶️ Запустити гру
                    </a>
                </div>
                <form action="{{ route('likes.toggle', $game->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="like-button">
                        @if ($game->isLikedByUser(auth()->id()))
                            Dislike
                        @else
                            Like
                        @endif
                    </button>
                </form>
                <div class="comments-section">
                    <h3 class="text-lg font-semibold mb-2">Коментарі</h3>
                    <form action="{{ route('comments.storeGame', $game->id) }}" method="POST" class="comment-form mt-4">
                        @csrf
                        <textarea name="body" placeholder="Додайте коментар..." rows="3" class="w-full border rounded p-2"></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded">Надіслати</button>
                    </form>

                    @foreach ($comments as $comment)
                        <div class="comment mt-4 border-t pt-2">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $comment->user->avatar ?? asset('storage/images/avatar-male.png') }}" class="w-8 h-8 rounded-full" alt="{{ $comment->user->username }}">
                                <p class="font-semibold">{{ $comment->user->username }}</p>
                            </div>
                            <p class="ml-10">{{ $comment->body }}</p>
                            @if (Auth::id() === $comment->user_id || Auth::user()?->isAdmin())
                                <form action="{{ route('comments.destroyGame', ['game' => $game->id, 'comment' => $comment->id]) }}" method="POST" class="ml-10 mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-600 hover:underline">Видалити</button>
                                </form>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
