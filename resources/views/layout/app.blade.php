<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Domovská stránka" ])
</head>

<body class="font-body text-gray-600 bg-gray-100">
@include('layout.partials.header')

<main class="m-12">
    <section>
        <h1 class="text-center font-bold text-xl lg:text-4xl px-2 mt-4">Prečo si zakúpiť smartfón u nás?</h1>
        <div class="text-center mx-auto w-full mt-5 lg:mt-8">
            <div class="grid grid-cols-12 lg:w-4/5 xl:w-1/2 mx-auto">
                <div class="hidden sm:inline col-span-12 sm:col-span-4 justify-self-end">
                    <!-- https://unsplash.com/photos/1RaiPibiOmA -->
                    <img src="{{ url('wtech/images/iphone.png') }}" alt="Úvodný obrázok" class="inline sm:w-48 lg:w-64" />
                </div>
                <div class="col-span-12 sm:col-span-8 mt-4">
                    <div>
                        <img src="{{ url('wtech/images/check.png') }}" alt="Odrážka" class="w-6 lg:w-10 inline -mt-1 lg:-mt-2 mx-2" />
                        <p class="inline text-lg lg:text-2xl">Doprava zadarmo</p>
                    </div>
                    <div class="mt-2 lg:mt-4">
                        <img src="{{ url('wtech/images/check.png') }}" alt="Odrážka" class="w-6 lg:w-10 inline -mt-1 lg:-mt-2 mx-2" />
                        <p class="inline text-lg lg:text-2xl">Garancia najnižších cien</p>
                    </div>
                    <div class="mt-2 lg:mt-4">
                        <img src="{{ url('wtech/images/check.png') }}" alt="Odrážka" class="w-6 lg:w-10 inline -mt-1 lg:-mt-2 mx-2" />
                        <p class="inline text-lg lg:text-2xl">2 ročná prémiová záruka</p>
                    </div>
                    <a href="{{ route('smartphones') }}">
                        <div class="mt-5 lg:mt-10 w-54 inline-block lg:w-96 lg:text-xl bg-blue-500 lg:px-10 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">Kúp si smartfón ešte dnes</div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="text-center my-5 lg:my-8">
            <h1 class="font-bold text-xl lg:text-4xl px-2 mt-4">Najpredávanejšie produkty</h1>
            <p class="mt-2 text-lg">Tieto smartfóny si naši zákazníci zamilovali</p>
        </div>
        <div class="grid grid-cols-12 w-11/12 lg:w-3/4 mx-auto mt-4 mb-2 gap-4">
            @foreach($smartphones as $smartphone)
            <div class="col-span-12 sm:col-span-6 lg:col-span-4 text-center">
                <a href="{{ route('details', $smartphone->id) }}" class="text-white text-xs sm:text-base">
                    @if($smartphone->images->first())
                    <img src="{{ url('wtech/' . $smartphone->images->first()->source) }}" alt="{{ $smartphone->images->first()->name }}" class="h-64 inline overflow-hidden" />
                    @else
                    <img alt="image does not exist" src="{{ url('wtech/images/no_img_available.jpg') }}" class="h-64 inline" />
                    @endif
                </a>
                <p class="font-bold">{{ $smartphone->name }}</p>
                <p>{{ formattedPrice($smartphone->price) }}</p>
            </div>
            @endforeach
        </div>
    </section>
</main>

@include('layout.partials.footer')
</body>
</html>
