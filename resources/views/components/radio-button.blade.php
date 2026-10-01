@props(['name', 'value', 'label', 'id', 'required' => false,])

<label for="{{ $id }}" class="flex items-center gap-3 cursor-pointer">
    <input
        type="radio"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name) === $value)
        @required($required)
        class="peer sr-only"
    >

    <span
        class="
            relative
            w-5
            h-5
            rounded-full
            border-2
            border-gray-400
            bg-white
            transition
            duration-150

            peer-focus:border-red-600
            peer-focus:ring-red-600
            peer-focus:ring-offset-2

            peer-checked:border-yellow-500

            after:absolute
            after:top-1/2
            after:left-1/2
            after:w-2.5
            after:h-2.5
            after:-translate-x-1/2
            after:-translate-y-1/2
            after:rounded-full
            after:bg-transparent
            after:transition

            peer-checked:after:bg-yellow-400
        "
    ></span>

    <span class=" font-semibold text-gray-700">
        {{ $label }}
    </span>
</label>
