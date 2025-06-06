@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenue sur votre outil de création de factures !') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Vous êtes connecté !") }}
                </div>
            </div>
            <div class="flex justify-start justify-items-start flex-col gap-[20px] mt-[40px]">
                <h2 class="text-[22px] font-semibold">Mes clients</h2>
                <p class="text-[16px]">Vous retrouverez ici toutes les entreprises pour lesquelles vous travaillez et dont la génération de facture en fonction d'un calendrier est nécéssaire.</p>
                <a class="w-[19.8%]" href="{{route('companies.index')}}"><button class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Consulter mes entreprises</button></a> 
            </div>
        </div>
    </div> 
</x-app-layout>
