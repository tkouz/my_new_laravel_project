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
                    {{-- 検索フォームと全件表示リンクをここに入れます --}}
                    <div class="search-form" style="margin-bottom: 20px; padding: 15px; border: 1px solid #eee; background-color: #f5f5f5; border-radius: 5px; display: flex; align-items: center;">
                        <form action="{{ route('questions.index') }}" method="GET" style="display: flex; flex-grow: 1;">
                            <input type="text" name="keyword" placeholder="キーワードで検索" value="{{ request('keyword') }}" style="flex-grow: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-right: 10px;">
                            <button type="submit" style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">検索</button>
                        </form>
                        @if (request('keyword'))
                            <a href="{{ route('questions.index') }}" class="clear-search-link" style="display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">全件表示に戻る</a>
                        @endif
                    </div>

                    {{-- 質問リストの表示 --}}
                    @if ($questions->isEmpty())
                        <p class="no-questions">まだ質問がありません。</p>
                    @else
                        @foreach ($questions as $question)
                            <div class="question" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                                <h2 style="font-size: 1.25em; margin-bottom: 10px;"><a href="{{ route('questions.show', ['question' => $question->id]) }}" style="color: #007bff; text-decoration: none;">{{ $question->title }}</a></h2>
                                <p style="color: #555; margin-bottom: 10px;">{{ $question->content }}</p>
                                {{-- userモデルのnameカラムを使用するように変更。もしuserモデルにusernameカラムがあるならそちらでも可 --}}
                                <p style="font-size: 0.9em; color: #888;">投稿者: {{ $question->user->name ?? '不明' }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>