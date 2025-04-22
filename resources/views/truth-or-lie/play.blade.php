<x-app-layout>
    <div class="min-h-screen bg-[#3b220f] text-white flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-4xl mb-6">
            <h2 class="text-3xl font-bold text-center text-yellow-400 mb-2">{{ $game->title }}</h2>
        </div>

        <div class="bg-[#1f1a16] p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <div class="bg-[#7d622b] text-white p-6 rounded mb-6 text-lg leading-relaxed">
                {{ $question->statement }}
            </div>

            <form action="{{ route('game.submitAnswer', $game->id) }}" method="POST" class="flex flex-col items-center space-y-6">
                @csrf
                <div class="flex space-x-6">
                    <button type="submit" name="answer" value="1"
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition">
                        True
                    </button>

                    <button type="submit" name="answer" value="0"
                            class="bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-full text-lg font-semibold transition">
                        False
                    </button>
                </div>
            </form>
        </div>

        <div class="flex justify-between items-center w-full max-w-3xl mt-8 px-4">
            <a href="{{ route('truth-or-lie.gamehub') }}"
               class="bg-[#8b6e38] hover:bg-[#a0854f] text-white px-6 py-3 rounded-lg text-lg font-semibold transition">
                Back
            </a>

            <div class="text-xl font-bold">
                Бал: {{ $score }}
            </div>

            <div class="px-6 py-3 text-lg text-gray-400 rounded-lg">
                Question {{ $index + 1 }}
            </div>
        </div>
    </div>
</x-app-layout>
