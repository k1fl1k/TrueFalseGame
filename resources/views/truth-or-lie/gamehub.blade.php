<x-app-layout>
    <div class="bg-[#3a1e00] min-h-screen px-10 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @if($games->count())
                @foreach($games as $game)
                    @if($game->is_public == true)
                        <a href="{{ route('truth-or-lie.show', $game->id) }}"
                           class="bg-[#1a1a1a] text-center p-4 rounded shadow block transition-transform duration-200 hover:scale-105">
                            <div class="aspect-video mb-2 bg-cover bg-center rounded"
                                 style="background-image: url('{{ asset($game->image ?? 'images/default.png') }}')">
                            </div>
                            <div class="text-white text-sm font-bold mb-1">{{ $game->title }}</div>
                            <div class="text-gray-400 text-xs mb-1">
                                {{ Str::limit($game->description, 60) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $game->is_public ? 'Public' : 'Private' }} |
                                {{ $game->user->username ?? 'Unknown' }}
                            </div>
                        </a>
                    @endif
                @endforeach
            @else
                <div class="col-span-full text-white text-center">
                    No games available.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
