@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>


    <div class="p-6 max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Entreprise</h3>
            <p class="text-gray-800 dark:text-gray-200">{{ $invoice->company->name }}</p>
            <p class="text-sm text-gray-500">{{ $invoice->company->adress }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Facturation</h3>
            <p><strong>Période :</strong> {{ $invoice->period }}</p>
            <p><strong>Date de facture :</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</p>
            <p><strong>Total heures :</strong> {{ $invoice->hours_total }} h</p>
            <p><strong>Total HT :</strong> {{ number_format($invoice->rising_total, 2) }} €</p>
            <p><strong>TVA :</strong> {{ number_format($invoice->rising_total * 0.2, 2) }} €</p>
            <p><strong>Total TTC :</strong> {{ number_format($invoice->rising_total * 1.2, 2) }} €</p>
        </div>

        <x-primary-button onclick="window.print()">Imprimer</x-primary-button>
    </div>
</x-app-layout>
