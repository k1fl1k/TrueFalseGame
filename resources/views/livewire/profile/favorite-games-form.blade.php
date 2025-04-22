<div class="user-posts">
    <div class="user-posts-header">
        <h2 class="user-posts-title">User Posts</h2>
    </div>
    <div class="user-posts-container">
        <div class="user-posts-scroll-wrapper">
            <div class="user-posts-grid">
                @if($likes->count())
                    @foreach($likes as $like)
                        @php $game = $like->game; @endphp

                        @if($game)
                            <a href="{{ route('truth-or-lie.show', $game->id) }}" class="user-post-card">
                                <div class="user-post-image"
                                     style="background-image: url('{{ asset($game->image ?? 'images/default.png') }}')">
                                </div>
                                <div class="user-post-title">{{ $game->title }}</div>
                                <div class="user-post-description">
                                    {{ Str::limit($game->description, 60) }}
                                </div>
                                <div class="user-post-meta">
                                    {{ $game->is_public ? 'Public' : 'Private' }} |
                                    {{ $game->user->username ?? 'Unknown' }}
                                </div>
                            </a>
                        @endif
                    @endforeach

                @else
                    <div class="user-posts-empty">
                        No games available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
