        {{-- resources/views/components/checkbox.blade.php --}}
        @props(['disabled' => false])

        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'checkbox', 'class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) !!}>
        