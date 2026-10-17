{{-- Product form for create and edit. $smartphone is null when creating; $brands and $colors are models. --}}
@php
    $field = 'w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
    $value = fn ($name) => old($name, $smartphone?->$name);
    $selectedBrand = old('brand', $smartphone?->brand?->name);
    $selectedColor = old('color', $smartphone?->color?->name_en);
@endphp

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        {{-- Basics --}}
        <section class="bg-white rounded-lg shadow-xs p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Basics') }}</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Product name') }}</label>
                <input type="text" id="name" name="name" value="{{ $value('name') }}" required maxlength="255"
                       class="{{ $field }} @error('name') border-red-500 @else border-gray-300 @enderror"/>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Price (€)') }}</label>
                    <input type="number" id="price" name="price" value="{{ $value('price') }}" step=".01" min="0" required
                           class="{{ $field }} @error('price') border-red-500 @else border-gray-300 @enderror"/>
                    @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Stock quantity') }}</label>
                    <input type="number" id="quantity" name="quantity" value="{{ $value('quantity') }}" min="0" required
                           class="{{ $field }} @error('quantity') border-red-500 @else border-gray-300 @enderror"/>
                    @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        {{-- Sale --}}
        <section class="bg-white rounded-lg shadow-xs p-6 space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Sale') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Optional. Leave the dates empty for a sale without start or end.') }}</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Sale price (€)') }}</label>
                    <input type="number" id="sale_price" name="sale_price" value="{{ $value('sale_price') }}" step=".01" min="0"
                           class="{{ $field }} @error('sale_price') border-red-500 @else border-gray-300 @enderror"/>
                    @error('sale_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @foreach (['sale_starts_at' => __('Sale starts'), 'sale_ends_at' => __('Sale ends')] as $name => $label)
                    <div>
                        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                        <input type="datetime-local" id="{{ $name }}" name="{{ $name }}"
                               value="{{ old($name, $smartphone?->$name?->timezone(config('demo.reset.timezone'))->format('Y-m-d\TH:i')) }}"
                               class="{{ $field }} @error($name) border-red-500 @else border-gray-300 @enderror"/>
                        @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Descriptions --}}
        <section class="bg-white rounded-lg shadow-xs p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Descriptions') }}</h2>
            @foreach (['description' => [__('Description (English)'), 'en'], 'description_de' => [__('Description (German)'), 'de'], 'description_sk' => [__('Description (Slovak)'), 'sk']] as $name => [$label, $lang])
                <div>
                    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                    <textarea id="{{ $name }}" name="{{ $name }}" lang="{{ $lang }}" rows="4"
                              class="{{ $field }} @error($name) border-red-500 @else border-gray-300 @enderror">{{ old($name, $lang === 'en' ? $smartphone?->description : ($smartphone?->description_translations[$lang] ?? '')) }}</textarea>
                    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
        </section>

        {{-- Specifications --}}
        <section class="bg-white rounded-lg shadow-xs p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Specifications') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ([
                    'ram' => [__('RAM (GB)'), 'number', '1'],
                    'operating_system' => [__('Operating system'), 'text', null],
                    'os_version' => [__('OS version'), 'number', '1'],
                    'display_size' => [__('Display size (inches)'), 'number', '.01'],
                    'resolution' => [__('Display resolution'), 'text', null],
                    'height' => [__('Height (mm)'), 'number', '.01'],
                    'width' => [__('Width (mm)'), 'number', '.01'],
                    'thickness' => [__('Thickness (mm)'), 'number', '.01'],
                ] as $name => [$label, $type, $step])
                    <div>
                        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value($name) }}"
                               @if ($step) step="{{ $step }}" min="0" @endif
                               class="{{ $field }} @error($name) border-red-500 @else border-gray-300 @enderror"/>
                        @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="space-y-6">
        {{-- Brand --}}
        <fieldset class="bg-white rounded-lg shadow-xs p-6">
            <legend class="sr-only">{{ __('Brand') }}</legend>
            <h2 class="text-lg font-semibold text-gray-900 mb-4" aria-hidden="true">{{ __('Brand') }}</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($brands as $brand)
                    <label class="flex items-center gap-2 p-2 rounded-lg border cursor-pointer text-sm has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 border-gray-200 hover:border-indigo-200">
                        <input type="radio" name="brand" value="{{ $brand->name }}" class="sr-only" @checked($selectedBrand === $brand->name)>
                        @include('layout.partials.brand-logo', ['brand' => $brand, 'size' => 'w-8 h-8 shrink-0'])
                        <span class="truncate">{{ $brand->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('brand')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </fieldset>

        {{-- Colour --}}
        <fieldset class="bg-white rounded-lg shadow-xs p-6">
            <legend class="sr-only">{{ __('Color') }}</legend>
            <h2 class="text-lg font-semibold text-gray-900 mb-4" aria-hidden="true">{{ __('Color') }}</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($colors as $color)
                    <label class="swatch" title="{{ \Illuminate\Support\Str::ucfirst(__($color->name_en)) }}">
                        <input type="radio" name="color" value="{{ $color->name_en }}" class="sr-only" @checked($selectedColor === $color->name_en)>
                        <span class="swatch-dot" style="background-color: {{ \App\Models\Color::hex($color->name_en) }}"></span>
                        <span class="sr-only">{{ __($color->name_en) }}</span>
                    </label>
                @endforeach
            </div>
            @error('color')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </fieldset>

        {{-- Images --}}
        <section class="bg-white rounded-lg shadow-xs p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Images') }}</h2>
            @if ($smartphone && $smartphone->images->isNotEmpty())
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($smartphone->images as $image)
                        <label class="group relative block aspect-square rounded-lg border border-gray-200 bg-gray-50 overflow-hidden cursor-pointer has-[:checked]:opacity-40 has-[:checked]:border-red-400">
                            <img src="{{ $image->url }}" alt="{{ $image->name }}" class="h-full w-full object-contain p-1"/>
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="absolute top-1 right-1 h-4 w-4 accent-red-600">
                            <span class="sr-only">{{ __('Remove') }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500">{{ __('Tick the images to remove when saving.') }}</p>
            @endif

            <label for="images" data-dropzone
                   class="flex flex-col items-center justify-center gap-1 px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer hover:border-indigo-400 transition-colors">
                <x-icon name="photo" class="w-10 h-10 text-gray-400"/>
                <span class="text-sm font-medium text-indigo-600">{{ __('Upload a file') }}</span>
                <span class="text-xs text-gray-500">{{ __('or drag and drop') }} · {{ __('JPG, PNG or WebP up to 10 MB') }}</span>
                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/jpeg,image/png,image/webp">
            </label>
            <div class="grid grid-cols-3 gap-2" data-previews></div>
            @error('images')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            @error('images.*')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </section>
    </div>
</div>

{{-- Actions, kept in view on phones --}}
<div class="sticky bottom-0 mt-6 -mx-4 px-4 py-3 bg-gray-50/90 backdrop-blur-sm border-t border-gray-200 flex justify-end gap-3 sm:static sm:mx-0 sm:px-0 sm:bg-transparent sm:border-0">
    <a href="{{ route('admin') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Cancel') }}</a>
    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700">
        <x-icon name="check"/>{{ $smartphone ? __('Save changes') : __('Add product') }}
    </button>
</div>

<script>
    // previews of the chosen files, and dropping files onto the upload area
    (function () {
        const input = document.getElementById('images');
        const zone = document.querySelector('[data-dropzone]');
        const previews = document.querySelector('[data-previews]');

        function showPreviews() {
            previews.replaceChildren(...Array.from(input.files).map(function (file) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.className = 'aspect-square w-full rounded-lg border border-gray-200 bg-gray-50 object-contain p-1';
                return img;
            }));
        }

        input.addEventListener('change', showPreviews);
        ['dragenter', 'dragover'].forEach((type) => zone.addEventListener(type, function (event) {
            event.preventDefault();
            zone.classList.add('border-indigo-500');
        }));
        ['dragleave', 'drop'].forEach((type) => zone.addEventListener(type, () => zone.classList.remove('border-indigo-500')));
        zone.addEventListener('drop', function (event) {
            event.preventDefault();
            input.files = event.dataTransfer.files;
            showPreviews();
        });
    })();
</script>
