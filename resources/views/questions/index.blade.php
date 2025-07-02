{{-- resources/views/questions/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('質問一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">質問リスト</h3>
                        @auth {{-- ログインしている場合のみ表示 --}}
                            <a href="{{ route('questions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('質問を投稿') }}
                            </a>
                        @endauth
                    </div>

                    {{-- 検索フォーム、ソートとステータス絞り込みドロップダウン --}}
                    {{-- flex-wrap を追加して、要素が折り返せるようにする --}}
                    <form action="{{ route('questions.index') }}" method="GET" class="mb-4 flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        {{-- 検索入力窓と検索ボタンのコンテナ --}}
                        <div class="w-full sm:w-1/2 flex items-center space-x-2"> {{-- flex と space-x-2 を追加 --}}
                            <x-text-input id="search" name="search" type="text" class="block w-full" placeholder="{{ __('キーワードで検索') }}" value="{{ request('search') }}" />
                            {{-- 検索ボタン --}}
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('検索') }}
                            </button>
                        </div>

                        {{-- ソートドロップダウン --}}
                        <div class="w-full sm:w-1/6"> {{-- 幅を sm:w-1/6 に変更 (合計が1になるように調整) --}}
                            <label for="sort_by" class="sr-only">並び替え</label>
                            <select name="sort_by" id="sort_by" onchange="this.form.submit()"
                                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"> {{-- text-sm と py-2 で高さを調整 --}}
                                <option value="latest" {{ ($sortBy ?? 'latest') == 'latest' ? 'selected' : '' }}>新しい順</option>
                                <option value="oldest" {{ ($sortBy ?? 'latest') == 'oldest' ? 'selected' : '' }}>古い順</option>
                                <option value="most_answers" {{ ($sortBy ?? 'latest') == 'most_answers' ? 'selected' : '' }}>回答数が多い順</option>
                            </select>
                        </div>

                        {{-- ステータス絞り込みドロップダウン --}}
                        <div class="w-full sm:w-1/6"> {{-- 幅を sm:w-1/6 に変更 --}}
                            <label for="status_filter" class="sr-only">ステータス絞り込み</label>
                            <select name="status_filter" id="status_filter" onchange="this.form.submit()"
                                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"> {{-- text-sm と py-2 で高さを調整 --}}
                                <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>全て</option>
                                <option value="open" {{ ($statusFilter ?? 'all') == 'open' ? 'selected' : '' }}>未解決</option>
                                <option value="resolved" {{ ($statusFilter ?? 'all') == 'resolved' ? 'selected' : '' }}>解決済み</option>
                            </select>
                        </div>

                        {{-- リセットボタンを追加 (条件付き表示) --}}
                        @if (request('search') || (isset($sortBy) && $sortBy !== 'latest') || (isset($statusFilter) && $statusFilter !== 'all'))
                            <div class="w-full sm:w-1/6"> {{-- 幅を sm:w-1/6 に変更 --}}
                                <a href="{{ route('questions.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 text-sm"> {{-- text-sm を追加 --}}
                                    {{ __('リセット') }}
                                </a>
                            </div>
                        @endif
                    </form>

                    @forelse ($questions as $question)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                            <h4 class="text-xl font-semibold text-gray-800">
                                <a href="{{ route('questions.show', $question) }}" class="hover:underline">
                                    {{ $question->title }}
                                </a>
                            </h4>
                            <p class="text-gray-600 text-sm mt-1">
                                投稿者: {{ $question->user->name }} - {{ $question->created_at->diffForHumans() }}
                                @if ($question->is_resolved)
                                    <span class="ml-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">解決済み</span>
                                @else {{-- 未解決タグの表示ロジック --}}
                                    <span class="ml-2 px-2 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">未解決</span>
                                @endif
                            </p>
                            <p class="text-gray-700 mt-2">{{ Str::limit($question->body, 150) }}</p> {{-- 質問内容の表示 --}}
                            <div class="mt-3 text-sm text-gray-500">
                                回答数: {{ $question->answers_count ?? $question->answers->count() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-700">まだ質問がありません。</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
