<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Všetky produkty" ])
</head>

<body class="font-body text-gray-600 bg-gray-100 flex flex-col h-screen justify-between">
@include('layout.partials.header')
<main class="mx-3 lg:mx-16 my-12 ">
    <h1 class="text-xl font-bold pb-2 mt-4 border-gray-300">Nový produkt</h1>
    <hr>
    <form action="{{ route('smartphones.update', [$smartphone->id]) }}" method="POST" enctype="multipart/form-data" >
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-12 lg:col-span-6">
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="name">Názov produktu</label>
                        <input type="text" value="{{ $smartphone->name }}" class="form-control p-1" id="name" name="name" required>
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="price">Cena</label>
                        <input type="number" value="{{ $smartphone->price }}" step=".01" class="form-control" id="price" name="price" required>
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="quantity">Množstvo na sklade</label>
                        <input type="number" value="{{ $smartphone->quantity }}" class="form-control p-1" id="quantity" name="quantity" required>
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="description">Popis produktu</label>
                        <textarea class="form-control p-1" id="description" name="description">{{ $smartphone->description }}</textarea>
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="ram">Pamäť RAM (MB)</label>
                        <input type="number" value="{{ $smartphone->ram }}" class="form-control p-1" id="ram" name="ram">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="operating_system">Operačný systém</label>
                        <input type="text" value="{{ $smartphone->operating_system }}" class="form-control p-1" id="operating_system" name="operating_system">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="os_version">Verzia operačného systému</label>
                        <input type="number" value="{{ $smartphone->os_version }}" class="form-control p-1" id="os_version" name="os_version">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="display_size">Veľkosť displeja (V palcoch)</label>
                        <input type="number" step=".01" value="{{ $smartphone->display_size }}" class="form-control p-1" id="display_size" name="display_size">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="resolution">Rozlíšenie displeja</label>
                        <input type="text" value="{{ $smartphone->resolution }}" class="form-control p-1" id="resolution" name="resolution">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="height">Výška (mm)</label>
                        <input type="number" step=".01" value="{{ $smartphone->height }}" class="form-control p-1" id="height" name="height">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="width">Šírka (mm)</label>
                        <input type="number" step=".01" value="{{ $smartphone->width }}" class="form-control p-1" id="width" name="width">
                    </div>
                </div>
                <div class="form-group m-2">
                    <div class="grid grid-cols-2">
                        <label for="thickness">Hrúbka (mm)</label>
                        <input type="number" step=".01" value="{{ $smartphone->thickness }}" class="form-control p-1" id="thickness" name="thickness">
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <section>
                    <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Farba</span>
                    <div class="flex flex-col text-left px-16">
                        @foreach($colors as $color)
                            <label class="text-lg inline-flex items-center" for="{{ $color }}">
                                {{ Form::radio('color', $color ,  $smartphone->color && $smartphone->color->name_sk == $color, ['id' => $color, 'class' => 'form-checkbox h-4 w-4']) }}
                                <span class="mx-2">{{ $color }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <section>
                    <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Výrobca</span>
                    <div class="flex flex-col text-left px-16">
                        @foreach($brands as $brand)
                            <label class="text-lg inline-flex items-center" for="{{ $brand }}">
                                {{ Form::radio('brand', $brand, $smartphone->brand && $smartphone->brand->name == $brand, ['id' => $brand, 'class' => 'form-checkbox h-4 w-4']) }}
                                <span class="mx-2">{{ $brand }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <div class="m-2 w-full md:w-1/2">
            <label class="text-gray-700 font-bold py-4 px-8 flex justify-start block tray-700">
                Obrázky
            </label>
            @foreach($smartphone->images as $image)
                <div class="grid grid-cols-12 m-2">
                    <div class="col-span-12 md:col-span-6">
                        <img src="{{ $image->source }}" alt="{{ $image->name }}" class="w-36 inline-block" />
                    </div>
                    <div class="col-span-12 md:col-span-6 self-center">
                        {{ Form::checkbox($image->source, $image->source, false) }}
                        <span class="mx-2">Odstrániť</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="m-2">
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="images[]" type="file" class="sr-only" multiple>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">
                        PNG, JPG up to 10MB
                    </p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="text-center my-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs my-4 px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
            Uložiť zmeny
        </button>
    </form>
</main>

</body>
</html>
