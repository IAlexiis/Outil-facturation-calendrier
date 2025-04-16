@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-6">
            {{ __('Mes entreprises') }}
        </h2>

    </x-slot>

    <div class="pt-[50px] pl-[100px] pr-[100px] flex flex-col">
        
        <p class="mb-[10px] text-[16px]">Vous pouvez ajouter ici une entreprise pour laquelle vous travaillez.</p>
        <a class="w-[16.3%]" href="{{ route('companies.create') }}">
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Ajouter une entreprise</button>
        </a>


            @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 mt-4">
            {{ session('success') }}
        </div>
            @endif

        @if ($companies->count())
        <table class="mt-[50px] w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-800">
                    <th class="p-2">Nom</th>
                    <th class="p-2">Adresse</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">SIRET</th>
                    <th class="p-2">Actions</th>
                    <th class="p-2">Importer</th>
              
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr class="border-t">
                        <td class="p-2">{{ $company->name }}</td>
                        <td class="p-2">{{ $company->adress }}</td>
                        <td class="p-2">{{ $company->email }}</td>
                        <td class="p-2 max-w-[30%]">{{ $company->siret }}</td>
                        <td class="p-2 flex gap-5">
                            
                            <a class="no-underline" href="{{ route('companies.edit', $company) }}"><button class="text-blue-600">Modifier</button></a>

                            <form action="{{ route('companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Supprimer cette entreprise ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Supprimer</button>
                            </form>
                        </td>
                        <td >
                            <a href="{{ route('calendars.create', ['company_id' => $company->id]) }}">
                                <button class="text-left text-nowrap">Importer calendrier</button>
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

    
</x-app-layout>
