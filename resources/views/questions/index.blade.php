<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('質問一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-3 py-6 sm:px-6 text-gray-900">
                    {{-- 検索フォームと並び替え、ステータス絞り込みドロップダウン --}}
                    <div class="mb-4 p-4 border border-gray-200 bg-gray-50 rounded-lg sm:flex sm:items-center sm:flex-wrap">
                        <form action="{{ route('questions.index') }}" method="GET" class="flex-grow flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                            <input type="text" name="keyword" placeholder="キーワードで検索" value="{{ request('keyword') }}"
                                   class="w-full sm:w-auto flex-grow rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-base py-2 px-3">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('検索') }}
                            </button>
                            @if (request('keyword'))
                                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            @endif
                            <div class="mt-2 sm:mt-0 sm:ms-2 w-full sm:w-auto">
                                <label for="sort_by" class="sr-only">{{ __('並び替え') }}</label>
                                <select name="sort_by" id="sort_by" onchange="this.form.submit()"
                                        class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-base py-2 px-3 pr-8">
                                    <option value="latest" {{ $sortBy == 'latest' ? 'selected' : '' }}>{{ __('新しい順') }}</option>
                                    <option value="oldest" {{ $sortBy == 'oldest' ? 'selected' : '' }}>{{ __('古い順') }}</option>
                                    <option value="most_answers" {{ $sortBy == 'most_answers' ? 'selected' : '' }}>{{ __('回答数が多い順') }}</option>
                                </select>
                            </div>
                            {{-- ステータス絞り込みドロップダウン --}}
                            <div class="mt-2 sm:mt-0 sm:ms-2 w-full sm:w-auto">
                                <label for="status_filter" class="sr-only">{{ __('ステータス') }}</label>
                                <select name="status_filter" id="status_filter" onchange="this.form.submit()"
                                        class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-base py-2 px-3 pr-8">
                                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>{{ __('全て') }}</option>
                                    <option value="open" {{ $statusFilter == 'open' ? 'selected' : '' }}>{{ __('未解決') }}</option>
                                    <option value="resolved" {{ $statusFilter == 'resolved' ? 'selected' : '' }}>{{ __('解決済み') }}</option>
                                </select>
                            </div>
                        </form>
                        @if (request('keyword') || (request('status_filter') && request('status_filter') != 'all'))
                            <a href="{{ route('questions.index') }}"
                               class="mt-2 sm:mt-0 sm:ms-4 w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 text-center">
                                {{ __('条件をリセット') }}
                            </a>
                        @endif
                    </div>
                   

                    {{-- 質問リストの表示 --}}
                    <h3 class="text-xl font-semibold mb-4">{{ __('すべての質問') }}</h3>
                    @if ($questions->isEmpty())
                        <p class="text-gray-600">{{ __('まだ質問が投稿されていません。') }}</p>
                    @else
                        <div class="space-y-6">
                            @foreach ($questions as $question)
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                                    <h4 class="text-lg font-bold">
                                        <a href="{{ route('questions.show', $question) }}" class="text-blue-600 hover:underline break-words">
                                            {{ $question->title }}
                                        </a>
                                    </h4>
                                    <p class="text-gray-700 text-sm mt-2 line-clamp-2 break-words">{{ $question->content }}</p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        投稿者: {{ $question->user->name ?? '不明' }}
                                        {{-- 回答数表示 --}}
                                        - 回答数: <a href="{{ route('questions.show', $question) }}#answers" class="text-blue-500 hover:underline">{{ $question->answers_count }}</a>
                                        {{-- 質問ステータスバッジの追加 --}}
                                        @if ($question->status === 'resolved')
                                            <span class="inline-flex items-center ms-2 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ __('解決済み') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center ms-2 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ __('未解決') }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        {{-- ページネーションリンク --}}
                        <div class="mt-6">
                            {{ $questions->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
