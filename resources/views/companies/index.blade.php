@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-6">
            {{ __('Mes entreprises') }}
        </h2>

    </x-slot>

    <div class="pl-[175px] pt-[50px]">
        <a href="{{ route('companies.create') }}">
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Ajouter une entreprise</button>
        </a>

        @if ($companies->count())
        <table class="mt-6 w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Nom</th>
                    <th class="p-2">Adresse</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">SIRET</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr class="border-t">
                        <td class="p-2">{{ $company->name }}</td>
                        <td class="p-2">{{ $company->adress }}</td>
                        <td class="p-2">{{ $company->email }}</td>
                        <td class="p-2">{{ $company->siret }}</td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('companies.edit', $company) }}" class="text-blue-600 hover:underline">Modifier</a>

                            <form action="{{ route('companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Supprimer cette entreprise ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
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
