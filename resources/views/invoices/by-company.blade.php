@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-6">
            {{ __('Mes factures') }}
        </h2>
    </x-slot>

    <div class="pl-[100px] pr-[100px] mt-[50px]">
        @if ($invoices->isEmpty())
            <p>Aucune facture pour cette entreprise.</p>
        @else
            <table class="w-full table-auto text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="p-2">Période</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr class="border-b text-[13.5px]">
                            <td class="p-2">{{ $invoice->period }}</td>
                            <td class="p-2">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                            <td class="p-2">{{ number_format($invoice->total, 2, ',', ' ') }} €</td>
                            <td class="p-2 flex gap-[15px]">
                                <a href="{{ route('invoices.show', $invoice) }}"><button class="text-left text-nowrap p-2 bg-black text-white hover:bg-white hover:text-black">Voir</button></a>
                            
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Supprimer cette facture ?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-800 text-white hover:bg-red-500">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
