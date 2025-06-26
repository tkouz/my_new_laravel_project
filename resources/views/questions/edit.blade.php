{{-- resources/views/questions/edit.blade.php --}}
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
                    <h3 class="text-xl font-semibold mb-6">{{ __('質問を編集する') }}</h3>

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('questions.update', $question) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('タイトル')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $question->title)" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <x-input-label for="content" :value="__('質問内容')" />
                            <x-textarea-input id="content" class="block mt-1 w-full" name="content" rows="10" required>{{ old('content', $question->content) }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        {{-- ★ここを修正: justify-end を justify-center に変更 --}}
                        <div class="flex items-center justify-center mt-4 space-x-4"> 
                            {{-- 削除ボタン --}}
                            <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('本当にこの質問を削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('削除') }}
                                </button>
                            </form>

                            {{-- 戻るボタン --}}
                            <a href="{{ route('questions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('質問一覧に戻る') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('更新') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
