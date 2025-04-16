@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">

<x-app-layout>
    <div class="min-w-[100%] min-h-[91%] flex justify-center items-center flex-col gap-[20px]">
        <div class="p-10 flex flex-col items-center justify-center bg-gray-800 w-[30%] rounded-[24px]">
            <h2 class="text-[20px] font-semibold mb-[20px]">Importer un calendrier</h2>

            <form class="min-w-[100%]" method="POST" action="{{ route('calendars.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-300">Entreprise</label>
                    <select name="company_id" required class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-300">Nom du calendrier (facultatif)</label>
                    <input type="text" name="name" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-300">Lien du calendrier iCal (.ics)</label>
                    <input type="url" name="source_file" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required placeholder="https://exemple.com/calendar.ics">
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-white text-gray-800 dark:text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                    Importer
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
