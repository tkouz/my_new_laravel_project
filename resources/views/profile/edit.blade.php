{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('マイページ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- 自分の質問一覧 (既存) --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('あなたの質問') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('あなたが投稿した質問の一覧です。') }}
                    </p>

                    <div class="mt-6 space-y-4">
                        @if ($myQuestions->isEmpty())
                            <p class="text-gray-600">{{ __('まだ質問を投稿していません。') }} <a href="{{ route('questions.create') }}" class="underline text-blue-500 hover:text-blue-700">{{ __('質問を投稿する') }}</a></p>
                        @else
                            @foreach ($myQuestions as $question)
                                <div class="border-b border-gray-100 pb-4">
                                    <h3 class="text-lg font-semibold">
                                        <a href="{{ route('questions.show', $question) }}" class="text-blue-600 hover:underline">
                                            {{ $question->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">投稿日時: {{ $question->created_at->format('Y/m/d H:i') }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <a href="{{ route('questions.edit', $question) }}" class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">
                                            {{ __('編集') }}
                                        </a>
                                        <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('本当にこの質問を削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-md hover:bg-red-200">
                                                {{ __('削除') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- 自分の回答一覧 (既存) --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('あなたの回答') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('あなたが投稿した回答の一覧です。') }}
                    </p>

                    <div class="mt-6 space-y-4">
                        @if ($myAnswers->isEmpty())
                            <p class="text-gray-600">{{ __('まだ回答を投稿していません。') }}</p>
                        @else
                            @foreach ($myAnswers as $answer)
                                <div class="border-b border-gray-100 pb-4">
                                    <p class="text-base text-gray-800">{{ $answer->content }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        質問: <a href="{{ route('questions.show', $answer->question) }}" class="text-blue-600 hover:underline">
                                            {{ $answer->question->title }}
                                        </a>
                                    </p>
                                    <p class="text-sm text-gray-500">回答日時: {{ $answer->created_at->format('Y/m/d H:i') }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- ★ここから追加: 自分のブックマーク一覧 --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('あなたのブックマーク') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('あなたがブックマークした質問の一覧です。') }}
                    </p>

                    <div class="mt-6 space-y-4">
                        {{-- Auth::user() は現在ログインしているユーザーインスタンス。
                             ->bookmarks は User モデルで定義した多対多リレーション。 --}}
                        @if (Auth::user()->bookmarks->isEmpty())
                            <p class="text-gray-600">{{ __('まだブックマークした質問がありません。') }} <a href="{{ route('questions.index') }}" class="underline text-blue-500 hover:text-blue-700">{{ __('質問を探す') }}</a></p>
                        @else
                            @foreach (Auth::user()->bookmarks as $bookmarkedQuestion)
                                <div class="border-b border-gray-100 pb-4 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold">
                                            <a href="{{ route('questions.show', $bookmarkedQuestion) }}" class="text-blue-600 hover:underline">
                                                {{ $bookmarkedQuestion->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            ブックマーク日時: {{ $bookmarkedQuestion->pivot->created_at->format('Y/m/d H:i') }}
                                        </p>
                                    </div>
                                    {{-- ブックマーク解除ボタン --}}
                                    <form action="{{ route('bookmark.destroy', $bookmarkedQuestion) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-md hover:bg-yellow-200">
                                            {{ __('解除') }}
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            {{-- ★ここまで追加 --}}

        </div>
    </div>
</x-app-layout>
