<div>
    @if($label)
        <label
            for="{{ $name }}"
            class="block text-sm font-semibold text-gray-700 mb-2"
        >
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => 'w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500 focus:rounded-b-none']) }}>
        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>
