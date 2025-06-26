<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('質問詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- 質問本体の表示 --}}
                    <h3 class="text-2xl font-bold mb-4">{{ $question->title }}</h3>
                    <p class="text-lg text-gray-700 mb-6">{{ $question->content }}</p>
                    <p class="text-sm text-gray-500 mb-8">投稿者: {{ $question->user->name ?? '不明' }}</p>
                    {{-- 質問のステータス表示 --}}
                    <p class="text-md font-semibold mb-4">
                        ステータス:
                        @if ($question->status === 'resolved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ __('解決済み') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ __('未解決') }}
                            </span>
                        @endif
                    </p>

                    {{-- 編集・削除ボタン --}}
                    @auth
                        @if (Auth::id() === $question->user_id)
                            <div class="flex space-x-4 mb-8">
                                <a href="{{ route('questions.edit', $question) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('編集') }}
                                </a>

                                <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('本当にこの質問を削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('削除') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    {{-- ブックマークボタン --}}
                    @auth
                        @if (Auth::id() !== $question->user_id)
                            <div class="mb-8">
                                @if (Auth::user()->bookmarks->contains($question->id))
                                    <form action="{{ route('bookmark.destroy', $question) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('ブックマーク解除') }}
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('bookmark.store', $question) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('ブックマーク') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <hr class="my-6 border-gray-200">


                    {{-- 回答投稿フォーム --}}
                    @auth
                        <h4 class="text-xl font-semibold mt-8 mb-4">{{ __('回答を投稿する') }}</h4>

                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('answers.store', $question) }}">
                            @csrf

                            <!-- Answer Content -->
                            <div>
                                <x-input-label for="answer_content" :value="__('あなたの回答')" />
                                <x-textarea-input id="answer_content" class="block mt-1 w-full" name="content" rows="5" required>{{ old('content') }}</x-textarea-input>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('回答を送信') }}
                                </x-primary-button>
                            </div>
                        </form>
                        <hr class="my-6 border-gray-200">
                    @else
                        <p class="mb-4 text-gray-600">{{ __('回答を投稿するには') }} <a href="{{ route('login') }}" class="underline text-blue-500 hover:text-blue-700">ログイン</a> {{ __('してください。') }}</p>
                        <hr class="my-6 border-gray-200">
                    @endauth

                    {{-- 回答一覧の表示 --}}
                    <h4 class="text-xl font-semibold mt-8 mb-4">{{ __('回答一覧') }} ({{ $question->answers->count() }})</h4>
                    @if ($question->answers->isEmpty())
                        <p class="text-gray-600">{{ __('まだ回答がありません。最初の回答を投稿しましょう！') }}</p>
                    @else
                        <div class="space-y-6">
                            @foreach ($question->answers as $answer)
                                <div class="bg-gray-50 p-4 mb-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start flex-wrap">
                                        <div class="flex-grow">
                                            <p class="text-gray-800 mb-2">{{ $answer->content }}</p>
                                            <p class="text-sm text-gray-500">回答者: {{ $answer->user->name ?? '不明' }} - {{ $answer->created_at->diffForHumans() }}</p>
                                        </div>
                                        {{-- ベストアンサー選定ボタン --}}
                                        @auth
                                            @if (Auth::id() === $question->user_id && $question->status === 'open' && !$answer->is_best_answer)
                                                <form action="{{ route('answers.markAsBestAnswer', ['question' => $question->id, 'answer' => $answer->id]) }}" method="POST" onsubmit="return confirm('この回答をベストアンサーに選定し、質問を解決済みにしますか？');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-2 sm:mt-0">
                                                        {{ __('ベストアンサーに選ぶ') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>

                                    {{-- ベストアンサー表示 (is_best_answer カラムがある場合) --}}
                                    @if (isset($answer->is_best_answer) && $answer->is_best_answer)
                                        <span class="inline-flex items-center mt-2 px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="-ms-1 me-1.5 h-3 w-3 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            ベストアンサー
                                        </span>
                                    @endif

                                    {{-- コメント一覧とコメント投稿フォーム --}}
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <h5 class="text-md font-semibold mb-3">{{ __('コメント') }} ({{ $answer->comments->count() }})</h5>
                                        @if ($answer->comments->isEmpty())
                                            <p class="text-sm text-gray-600">{{ __('まだコメントがありません。') }}</p>
                                        @else
                                            <div class="space-y-3">
                                                @foreach ($answer->comments as $comment)
                                                    <div class="bg-gray-100 p-3 rounded-md">
                                                        <p class="text-sm text-gray-800">{{ $comment->content }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">コメント者: {{ $comment->user->name ?? '不明' }} - {{ $comment->created_at->diffForHumans() }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- コメント投稿フォーム --}}
                                        @auth
                                            <div class="mt-4">
                                                <h6 class="text-base font-semibold mb-2">{{ __('コメントを追加') }}</h6>
                                                <x-validation-errors :messages="$errors->get('comment_content')" class="mb-4" />

                                                <form method="POST" action="{{ route('comments.store', $answer) }}">
                                                    @csrf

                                                    <div>
                                                        <x-textarea-input id="comment_content_{{ $answer->id }}" class="block mt-1 w-full" name="content" rows="3" placeholder="コメントを入力..." required>{{ old('content') }}</x-textarea-input>
                                                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                                    </div>

                                                    <div class="flex items-center justify-end mt-3">
                                                        <x-primary-button class="ms-4">
                                                            {{ __('コメントを投稿') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <p class="mt-4 text-sm text-gray-600">{{ __('コメントを投稿するには') }} <a href="{{ route('login') }}" class="underline text-blue-500 hover:text-blue-700">ログイン</a> {{ __('してください。') }}</p>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('questions.index') }}" class="text-blue-500 hover:underline">
                            {{ __('質問一覧に戻る') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
