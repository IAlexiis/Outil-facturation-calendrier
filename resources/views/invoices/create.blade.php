@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>

    <div class="p-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Entreprise</label>
                <select name="company_id" class="w-full mt-1 rounded-md dark:bg-gray-900 dark:text-white" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-sm font-medium">Date de début</label>
                    <input type="date" name="start_date" class="w-full mt-1 rounded-md dark:bg-gray-900 dark:text-white" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-medium">Date de fin</label>
                    <input type="date" name="end_date" class="w-full mt-1 rounded-md dark:bg-gray-900 dark:text-white" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Taux horaire (€)</label>
                <input type="number" step="0.01" name="hourly_rate" class="w-full mt-1 rounded-md dark:bg-gray-900 dark:text-white" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">TVA (%)</label>
                <input type="number" step="0.01" name="tva_rate" class="w-full mt-1 rounded-md dark:bg-gray-900 dark:text-white" value="20">
            </div>

            <x-primary-button class="mt-4">
                Générer la facture
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
