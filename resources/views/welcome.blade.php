<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Travel Agency</title>

        {{-- Styles --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    </head>
    <body class="bg-gray-900">
        <div class="flex justify-center mt-6 pt-8 sm:pt-0">
            <div class="text-gray-200 font-bold text-7xl">Travel Agency</div>
        </div>
        <div>
            <div class="flex justify-center mt-2 mb-4 pt-8 sm:pt-0">
                <div class="text-gray-400 font-bold text-3xl">Welcome to Travel Agency</div>
            </div>
        </div>
        <div class="container mx-auto text-white rounded">
                <div class="grid grid-cols-2 gap-2 place-items-stretch text-center mb-2">
                    <a href="http://localhost/cities">
                        <div class="bg-gray-800 rounded overflow-hidden shadow-xl border border-gray-700 hover:border-gray-200">
                            <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">Cities</div>
                            <p class="text-gray-600 text-base">
                                The most beautiful cities in the world
                            </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">

                            </div>
                        </div>
                    </a>
                    <a href="http://localhost/airlines">
                        <div class="bg-gray-800 rounded overflow-hidden shadow-xl border border-gray-700 hover:border-gray-200">
                            <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">Airlines</div>
                            <p class="text-gray-600 text-base">
                                The best airlines to travel with
                            </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">

                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid grid-cols-1 gap-2 place-items-stretch text-center">
                    <a href="http://localhost/flights">
                        <div class="bg-gray-800 rounded overflow-hidden shadow-xl border border-gray-700 hover:border-gray-200">
                            <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">Flights</div>
                            <p class="text-gray-600 text-base">
                                The most comfortable flight experience
                            </p>
                            </div>
                            <div id="default-carousel" class="relative" data-carousel="slide">
                                <!-- Carousel wrapper -->
                                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                    <!-- Item 1 -->
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                                        <span class="absolute text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                                        <img src="/img/de415334320dd313b583016db0352e93.jpeg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                    </div>
                                    <!-- Item 2 -->
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="/img/the-sky-clouds-flight-lights-wallpaper-preview.jpeg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                    </div>
                                    <!-- Item 3 -->
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="/docs/images/carousel/carousel-3.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                    </div>
                                    <!-- Slider indicators -->
                                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
    </body>
</html>
