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
    <form method="POST" action="{{ route('user.form') }}" class="dark:bg-stone-800 bg-gray-200 rounded-lg mx-6 mt-2">
        <h2 class="py-4 px-6 bg-green-400 rounded-t-lg text-xl font-bold text-green-50">RTO Inventory Form
            <p class="text-sm font-semibold">all fields are required</p>
        </h2>
        @csrf

        <div class="p-10">
            <!-- Inventory Items -->
            <div class="p-6 mt-6 rounded shadow" x-data="{ items: [{}] }">
                <template x-for="(item, index) in items" :key="index">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- description -->
                        <div>
                            <x-input-label for="description" :value="__('Document Description')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <input type="text" placeholder="Ex. CRTS Inventory..." class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" :name="'items[' + index + '][description]'" x-model="item.description">
                        </div>

                        <!-- doc date -->
                        <div>
                            <x-input-label for="doc date" :value="__('Doc date')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <input type="date" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" :name="'items[' + index + '][doc_date]'" x-model="item.doc_date">
                        </div>

                        <!-- quantity/unit code -->
                        <div>
                            <x-input-label for="quantity_code" :value="__('quantity/unit code')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <input type="text" placeholder="Ex. 7UAwqol1" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" :name="'items[' + index + '][quantity_code]'" x-model="item.quantity_code">
                        </div>

                        <!-- index code -->
                        <div>
                            <x-input-label for="index_code" :value="__('index code')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <input type="text" placeholder="Ex. 7UAwqol1" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" :name="'items[' + index + '][index_code]'" x-model="item.index_code">
                        </div>

                        <!-- retention period -->
                        <div>
                            <x-input-label for="retention_period" :value="__('retention period')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <input type="number" placeholder="Ex. 1" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" :name="'items[' + index + '][retention_period]'" x-model="item.retention_period">
                        </div>

                        <!-- status -->
                        <div>
                            <x-input-label for="status" :value="__('Select Document Status')" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Select Status</x-input-label>
                            <select :name="'items[' + index + '][status]'" id="status" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700" x-model="item.status">
                                <option value="" disabled selected hidden>-- Status --</option>
                                <option value="Permanent">Permanent</option>
                                <option value="Temporary">Temporary</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <button type="button" class="items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" @click="items.splice(index, 1)" x-show="items.length > 1">Remove Item</button>
                        </div>
                    </div>

                </template>

                <div class="my-4">
                    <x-primary-button type="button" @click="items.push({})">
                        + Add Another Item
                    </x-primary-button>
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
                    Submit Inventory
                </button>
            </div>

        </div>

    </form>

    <!-- Flash Messages -->
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