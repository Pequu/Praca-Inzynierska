@props([
    'poster' => null,
])

<div>
    <label class="mb-2 block text-sm font-medium text-gray-900">
        Plakat
    </label>

    <div
        id="posterDropzone"
        class="relative flex min-h-80 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 transition hover:border-red-500 hover:bg-gray-100"
    >
        <input
            type="file"
            name="poster"
            id="posterInput"
            accept="image/jpeg,image/png,image/webp"
            class="hidden"
        >

        <div
            id="posterPlaceholder"
            class="{{ $poster ? 'hidden' : '' }} pointer-events-none flex flex-col items-center px-6 text-center"
        >
            <svg
                class="mb-4 h-12 w-12 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 8l-4-4m0 0L8 8m4-4v12"
                />
            </svg>

            <p class="text-sm font-medium text-gray-700">
                Przeciągnij plakat tutaj
            </p>

            <p class="mt-1 text-xs text-gray-500">
                lub kliknij, aby wybrać plik
            </p>

            <p class="mt-2 text-xs text-gray-400">
                JPG, PNG lub WEBP • maks. 5 MB
            </p>
        </div>

        <div
            id="posterPreviewContainer"
            class="{{ $poster ? '' : 'hidden' }} absolute inset-0"
        >
            @if ($poster)
                <img
                    id="posterPreview"
                    src="{{ asset('storage/' . $poster) }}"
                    alt="Podgląd plakatu"
                    class="h-full w-full object-contain p-4"
                >
            @else
                <img
                    id="posterPreview"
                    src=""
                    alt="Podgląd plakatu"
                    class="h-full w-full object-contain p-4"
                >
            @endif

            <button
                type="button"
                id="posterRemoveButton"
                class="absolute right-3 top-3 rounded-full bg-black/70 px-3 py-2 text-sm text-white transition hover:bg-red-600"
            >
                Zmień
            </button>
        </div>
    </div>

    <p
        id="posterError"
        class="mt-2 hidden text-sm text-red-600"
    ></p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropzone = document.getElementById('posterDropzone');
        const input = document.getElementById('posterInput');
        const placeholder = document.getElementById('posterPlaceholder');
        const previewContainer = document.getElementById('posterPreviewContainer');
        const preview = document.getElementById('posterPreview');
        const removeButton = document.getElementById('posterRemoveButton');
        const error = document.getElementById('posterError');

        if (!dropzone || !input) {
            return;
        }

        dropzone.addEventListener('click', function () {
            input.click();
        });

        input.addEventListener('change', function () {
            if (input.files.length > 0) {
                showPoster(input.files[0]);
            }
        });

        dropzone.addEventListener('dragover', function (event) {
            event.preventDefault();

            dropzone.classList.add(
                'border-red-500',
                'bg-red-50'
            );
        });

        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove(
                'border-red-500',
                'bg-red-50'
            );
        });

        dropzone.addEventListener('drop', function (event) {
            event.preventDefault();

            dropzone.classList.remove(
                'border-red-500',
                'bg-red-50'
            );

            const files = event.dataTransfer.files;

            if (files.length > 0) {
                const file = files[0];

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                input.files = dataTransfer.files;

                showPoster(file);
            }
        });

        removeButton.addEventListener('click', function (event) {
            event.stopPropagation();

            input.value = '';

            preview.src = '';
            previewContainer.classList.add('hidden');
            placeholder.classList.remove('hidden');
        });

        function showPoster(file) {
            error.classList.add('hidden');
            error.textContent = '';

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                showError('Dozwolone są tylko pliki JPG, PNG i WEBP.');
                input.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showError('Plik może mieć maksymalnie 5 MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                preview.src = event.target.result;

                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }

        function showError(message) {
            error.textContent = message;
            error.classList.remove('hidden');
        }
    });
</script>
