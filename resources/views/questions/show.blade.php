{{-- resources/views/questions/show.blade.php --}}
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

                    {{-- ★★★ここに追加する★★★ --}}
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
                    {{-- ★★★追加ここまで★★★ --}}

                    <hr class="my-6 border-gray-200">

                    {{-- 成功メッセージの表示 --}}
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- 回答投稿フォーム --}}
                    @auth
                        <h4 class="text-xl font-semibold mt-8 mb-4">{{ __('回答を投稿する') }}</h4>

                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('answers.store', $question) }}">
                            @csrf

                            <!-- Answer Content -->
                            <div>
                                <x-input-label for="content" :value="__('あなたの回答')" />
                                <x-textarea-input id="content" class="block mt-1 w-full" name="content" rows="5" required>{{ old('content') }}</x-textarea-input>
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
                        @foreach ($question->answers as $answer)
                            <div class="bg-gray-50 p-4 mb-4 rounded-lg shadow-sm">
                                <p class="text-gray-800 mb-2">{{ $answer->content }}</p>
                                <p class="text-sm text-gray-500">回答者: {{ $answer->user->name ?? '不明' }} - {{ $answer->created_at->diffForHumans() }}</p>
                                @if (isset($answer->is_best_answer) && $answer->is_best_answer)
                                    <span class="inline-flex items-center mt-2 px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="-ms-1 me-1.5 h-3 w-3 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        ベストアンサー
                                    </span>
                                @endif
                            </div>
                        @endforeach
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
