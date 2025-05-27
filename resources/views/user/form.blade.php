<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <a href="{{ route('user.index') }}">RTO Inventory</a>
        </div>

        <div class="flex underline underline-offset-4">
            <a href="{{ route('user.reports') }}">Reports</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
    <!-- Registration Form -->
    <form method="POST" action="{{ route('user.form') }}" class="dark:bg-stone-800 bg-gray-200 rounded-lg mx-6 mt-2" id="registerForm">
        <h2 class="py-4 px-6 bg-green-400 rounded-t-lg text-xl font-bold text-green-50">RTO Inventory Form
            <p class="text-sm font-semibold">all fields are required</p>
        </h2>
        @csrf
        <div class="p-10">


            <!-- Document Description -->
            <div>
                <x-input-label for="description" :value="__('Document Description')" class="dark:text-gray-300" />
                <x-txt-area name="description" id="description" placeholder="Ex. CRTS Inventory...">{{ old('bio') }}</x-txt-area>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Quantity / Unit code -->
            <div class="mt-4">
                <x-input-label for="quantity_code" :value="__('Quantity/Unit Code')" class="dark:text-gray-300" />
                <x-text-input placeholder="Ex. 7UAwqol1" id="quantity_code" class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600" type="text" name="quantity_code" :value="old('quantity_code')" required autocomplete="quantity_code" />
                <x-input-error :messages="$errors->get('quantity_code')" class="mt-2" />
            </div>

            <!-- Document Date -->
            <div class="mt-4">
                <x-input-label for="doc_date" :value="__('Document Date')" class="dark:text-gray-300" />
                <x-year-picker name="doc_date" :selected="old('doc_date')" :start="1980" :end="now()->year" />
                <x-input-error :messages="$errors->get('doc_date')" class="mt-2" />
            </div>

            <!-- Index Code -->
            <div class="mt-4">
                <x-input-label for="index_code" :value="__('Index Code')" class="dark:text-gray-300" />
                <x-text-input placeholder="Ex. 7UAwqol1" id="password_confirmation" class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600" type="text" name="index_code" required autocomplete="index_code" />
                <x-input-error :messages="$errors->get('index_code')" class="mt-2" />
            </div>

            <!-- Status -->
            <div class="mt-4">
                <x-input-label for="status" :value="__('Select Document Status')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Select Status</x-input-label>
                <select name="status" id="status" class="block w-full p-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700 ">
                    <option value="" disabled selected hidden>-- Status --</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Temporary">Temporary</option>
                </select>
            </div>

            <!-- Retention period -->
            <div class="mt-4">
                <x-input-label for="retention_period" :value="__('Retention Period (counted as per year)')" class="dark:text-gray-300" />
                <x-text-input placeholder="Ex. 1" id="retention_period" class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600" type="number" name="retention_period" required autocomplete="retention_period" />
                <x-input-error :messages="$errors->get('retention_period')" class="mt-2" />
            </div>

            <!-- Already Registered -->
            <div class="flex flex-col sm:flex-row items-center justify-end mt-4">

                <!-- Submit Button -->
                <x-green-button id="submitButton">
                    {{ __('Submit form') }}
                </x-green-button>
            </div>
        </div>


    </form>

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed top-5 right-5 bg-red-500 text-white p-4 rounded shadow-lg"
        x-init="setTimeout(() => show = false, 3000)">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded shadow-lg"
        x-init="setTimeout(() => show = false, 3000)">
        <p>{{ session('success') }}</p>
    </div>
    @endif
</x-app-layout>

<script src="{{ asset('js/disabledbutton.js') }}"></script>
<script src="{{ asset('js/registerTogglePassword.js') }}"></script>