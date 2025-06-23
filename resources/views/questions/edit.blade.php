<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('質問を編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- 成功メッセージの表示 --}}
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- バリデーションエラーメッセージの表示 --}}
                    <x-validation-errors class="mb-4" />

                    {{--
                        フォームの method="POST" は HTML の標準では PUT/PATCH/DELETE をサポートしない。
                        そのため、@method('PUT') を使用して Laravel が PUT リクエストとして認識するようにする。
                    --}}
                    <form method="POST" action="{{ route('questions.update', $question) }}">
                        @csrf
                        @method('PUT') {{-- ★重要: PUTメソッドを使用することを宣言 --}}

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('質問のタイトル')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $question->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <x-input-label for="content" :value="__('質問の内容')" />
                            {{-- old() と $question->content の両方を指定し、古い入力値があればそれを、なければ現在の質問内容を表示 --}}
                            <x-textarea-input id="content" class="block mt-1 w-full" name="content" rows="10" required>{{ old('content', $question->content) }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('質問を更新') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
