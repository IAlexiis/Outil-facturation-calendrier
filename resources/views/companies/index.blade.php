@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-6">
            {{ __('Mes entreprises') }}
        </h2>
    </x-slot>

    <div class="pt-[50px] pl-[100px] pr-[100px] flex flex-col">
        <div class="flex flex-col mb-[50px]">
            <p class="mb-[10px] text-[16px]">
                Vous pouvez ajouter ici une entreprise pour laquelle vous travaillez.
            </p>
            <a class="w-[16.3%]" href="{{ route('companies.create') }}">
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Ajouter une entreprise
                </button>
            </a>
        </div>

        <div class="flex flex-col gap-[10px]">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($companies->count())
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="p-2">Nom</th>
                            {{-- <th class="p-2">Adresse</th> --}}
                            {{-- <th class="p-2">Email</th> --}}
                            <th class="p-2">SIRET</th>
                            <th class="p-2">Actions</th>
                            <th class="p-2">Importer</th>
                            <th class="p-2">Factures</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr class="text-[13.5px]">
                                <td class="p-2">{{ $company->name }}</td>
                                {{-- <td class="p-2">{{ $company->adress }}</td> --}}
                                {{-- <td class="p-2">{{ $company->email }}</td> --}}
                                <td class="p-2 max-w-[30%]">{{ $company->siret }}</td>
                                <td class="p-2 flex gap-4">
                                    <a class="no-underline" href="{{ route('companies.edit', $company) }}">
                                        <button class="p-2 bg-blue-800 text-white hover:bg-blue-500">Modifier</button>
                                    </a>

                                    <form action="{{ route('companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Supprimer cette entreprise ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-800 text-white hover:bg-red-500">Supprimer</button>
                                    </form>
                                </td>
                                <td class="p-2">
                                    <a href="{{ route('calendars.create', ['company_id' => $company->id]) }}">
                                        <button class="text-left text-nowrap p-2 bg-black text-white hover:bg-white hover:text-black">Importer calendrier</button>
                                    </a>
                                </td>
                                <td class="p-2 flex gap-4">
                                    <a href="{{ route('invoices.create') }}">
                                        <button class="text-left text-nowrap p-2  bg-black text-white  hover:bg-white hover:text-black">Créer une facture</button>
                                    </a>
                                    <a href="{{ route('companies.invoices', $company) }}">
                                        <button class="text-left text-nowrap p-2  bg-black text-white  hover:bg-white hover:text-black">Voir les factures</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-6 text-gray-600">Aucune entreprise enregistrée.</p>
            @endif
        </div>
    </div>
</x-app-layout>
