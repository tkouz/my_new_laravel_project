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
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $question->title }}</h2>
                        <p class="text-gray-600 text-sm">
                            投稿者: {{ $question->user->name }} - {{ $question->created_at->diffForHumans() }}
                            @if ($question->is_resolved)
                                <span class="ml-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">解決済み</span>
                            @endif
                        </p>
                        <p class="mt-4 text-gray-800">{{ $question->body }}</p>
                    </div>

                    {{-- 質問の所有者で、かつまだベストアンサーが選ばれていない場合のみ表示 --}}
                    @if (Auth::check() && Auth::id() === $question->user_id && !$question->best_answer_id)
                        <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 rounded-lg">
                            <p>ベストアンサーを選ぶことで、この質問を解決済みにできます。</p>
                        </div>
                    @endif

                    {{-- ベストアンサーの表示 --}}
                    @if ($question->bestAnswer)
                        <div class="mt-8 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-sm">
                            <h3 class="text-lg font-semibold text-green-800 flex items-center">
                                ベストアンサー
                                {{-- ベストアンサータグを追加 --}}
                                <span class="ml-2 px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">選ばれました！</span>
                            </h3>
                            <p class="text-gray-700 mt-2">{{ $question->bestAnswer->content }}</p>
                            <p class="text-right text-sm text-green-600">
                                選ばれた回答者: {{ $question->bestAnswer->user->name }} - {{ $question->bestAnswer->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endif

                    <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">回答一覧 ({{ $question->answers->count() }})</h3>

                    @forelse ($question->answers as $answer)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4 {{ $answer->id === $question->best_answer_id ? 'border-2 border-green-500' : '' }}">
                            <p class="text-gray-700">{{ $answer->content }}</p>
                            <p class="text-right text-sm text-gray-600">
                                回答者: {{ $answer->user->name }} - {{ $answer->created_at->diffForHumans() }}
                                {{-- 各回答にもベストアンサータグを追加 --}}
                                @if ($answer->id === $question->best_answer_id)
                                    <span class="ml-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">ベストアンサー</span>
                                @endif
                            </p>
                            {{-- ベストアンサー選定ボタン --}}
                            @if (Auth::check() && Auth::id() === $question->user_id && !$question->best_answer_id)
                                <form action="{{ route('answers.markAsBestAnswer', ['question' => $question->id, 'answer' => $answer->id]) }}" method="POST" class="mt-2 text-right">
                                    @csrf
                                    <x-primary-button type="submit" class="text-green-600 hover:text-green-800 text-sm">ベストアンサーに選ぶ</x-primary-button>
                                </form>
                            @endif

                            {{-- コメント表示 --}}
                            @foreach($answer->comments as $comment)
                                <div class="ml-4 mt-2 p-2 bg-gray-100 rounded-lg text-sm">
                                    <p class="text-gray-700">{{ $comment->content }}</p> {{-- ★ここを修正: $comment->body を $comment->content に変更 --}}
                                    <p class="text-right text-xs text-gray-500">
                                        コメント者: {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            @endforeach

                            {{-- コメント投稿フォーム --}}
                            @auth
                                <form action="{{ route('comments.store', $answer) }}" method="POST" class="mt-2">
                                    @csrf
                                    <x-textarea-input name="content" class="w-full text-sm" rows="2" placeholder="コメントを追加"></x-textarea-input>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                    <x-primary-button class="mt-2">コメントする</x-primary-button>
                                </form>
                            @endauth
                        </div>
                    @empty
                        <p class="text-gray-700">まだ回答がありません。</p>
                    @endforelse

                    <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">回答を投稿する</h3>
                    @auth
                        <form action="{{ route('answers.store', $question) }}" method="POST">
                            @csrf
                            <x-textarea-input name="content" class="w-full" rows="5" placeholder="あなたの回答を入力してください"></x-textarea-input>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            <x-primary-button class="mt-4">回答を投稿</x-primary-button>
                        </form>
                    @else
                        {{-- ログインを促すメッセージは残し、ログインページへのリンクは削除 --}}
                        <p class="text-gray-700">回答を投稿するにはログインが必要です。</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
