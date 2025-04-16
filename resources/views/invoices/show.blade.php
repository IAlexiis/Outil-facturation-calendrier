@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<div class="flex justify-center items-center w-FULL h-FULL">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 p-8 rounded shadow mt-10 print:p-0 print:shadow-none print:bg-white">

        <div class="flex justify-between items-center mb-8 gap-[50px]">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Facture</h1>
                <p class="text-sm text-gray-500">N° {{ $invoice->id }}</p>
                <p class="text-sm text-gray-500">Émise le : {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $invoice->company->name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $invoice->company->adress }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $invoice->company->email }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">SIRET : {{ $invoice->company->siret }}</p>
            </div>
        </div>

        <hr class="mb-6 border-gray-300 dark:border-gray-700">

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Détails de la prestation</h3>
            <ul class="text-sm text-gray-700 dark:text-gray-300 list-disc pl-5">
                <li><strong>Période :</strong> {{ $invoice->period }}</li>
                <li><strong>Tarif horaire :</strong> {{ number_format($invoice->hourly_rate, 2, ',', ' ') }} € / heure</li>
                <li><strong>Nombre total d’heures :</strong> {{ number_format($invoice->total_hours, 2, ',', ' ') }} h</li>
            </ul>
        </div>

        <hr class="mb-6 border-gray-300 dark:border-gray-700">

        <div class="grid grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-200">
            <div><strong>Total HT :</strong></div>
            <div class="text-right">{{ number_format($invoice->total, 2, ',', ' ') }} €</div>

            <div><strong>TVA ({{ $invoice->tva_rate ?? 0 }}%) :</strong></div>
            <div class="text-right">{{ number_format($invoice->total * ($invoice->tva_rate ?? 0) / 100, 2, ',', ' ') }} €</div>

            <div class="border-t mt-2 pt-2 text-lg font-bold">Total TTC :</div>
            <div class="border-t mt-2 pt-2 text-right text-lg font-bold">
                {{ number_format($invoice->total * (1 + ($invoice->tva_rate ?? 0) / 100), 2, ',', ' ') }} €
            </div>
        </div>

        <div class="mt-8 text-right print:hidden">
            <x-primary-button onclick="window.print()">Imprimer la facture</x-primary-button>
        </div>
    </div>
</div>
    

