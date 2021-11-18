<footer class="footer bg-blue-500 w-full">
    <div class="mx-auto">
        <div class="grid grid-cols-12 sm:mt-1">
            <div class="col-span-6 sm:col-span-3 text-center">
                <span class="block font-bold text-white text-xs sm:text-base uppercase mt-1 sm:mb-2">O nákupe</span>
                <span class="block sm:my-1"><a href="#" class="text-white text-xs sm:text-base">Reklamácie</a></span>
                <span class="block sm:my-1"><a href="#" class="text-white text-xs sm:text-base">Platba</a></span>
            </div>
            <!-- https://www.iconfinder.com/social-media-icons -->
            <div class="hidden sm:flex justify-self-center col-span-12 sm:col-span-6 text-center self-center">
                <div class="bg-white sm:rounded-md p-2">
                    <a href="#">
                        <img src="{{ url('/images/yt.png') }}" alt="Youtube" class="w-6 inline mx-1 md:mx-4"/>
                    </a>
                    <a href="#">
                        <img src="{{ url('/images/linkedin.png') }}" alt="LinkedIn" class="w-6 inline mx-1 md:mx-4"/>
                    </a>
                    <a href="#">
                        <img src="{{ url('/images/fb.png') }}" alt="Facebook" class="w-6 inline mx-1 md:mx-4"/>
                    </a>
                    <a href="#">
                        <img src="{{ url('/images/ig.png') }}" alt="Instagram" class="w-6 inline mx-1 md:mx-4"/>
                    </a>
                    <a href="#">
                        <img src="{{ url('/images/twitter.png') }}" alt="Twitter" class="w-6 inline mx-1 md:mx-4"/>
                    </a>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3 text-center mr-1">
                <span class="block font-bold text-white uppercase text-xs sm:text-base mt-1 sm:mb-2">Informácie</span>
                <span class="block sm:my-1"><a href="#" class="text-white text-xs sm:text-base">Kontakt</a></span>
                <span class="block sm:my-1"><a href="#" class="text-white text-xs sm:text-base">Obchodné podmienky</a></span>
            </div>
        </div>
    </div>
    <div class="mx-auto w-full bg-blue-700">
        <div class="mt-2 flex flex-col items-center">
            <div class="w-full sm:w-2/3 text-center py-1">
                <p class="text-xs sm:text-sm text-white font-bold">© 2021 - 2022 Smarpthone Eshop</p>
                <p class="text-xs sm:text-sm text-white font-bold">Všetky práva vyhradené</p>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="{{ asset('/js/nav.js') }}"></script>
