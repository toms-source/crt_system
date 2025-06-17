<div
    x-data="{
    show: false,
    inventory: {},
    
    get disposalYearClass() {
        if (!this.inventory.disposal_date) return '';

        const now = new Date();
        const disposalDate = new Date(this.inventory.disposal_date);
        const diffYears = (disposalDate - now) / (1000 * 60 * 60 * 24 * 365);

        if (diffYears <= 1) {
            return 'text-red-800 bg-red-300 font-extrabold rounded-full px-4';
        } else if (diffYears => 2) {
            return 'text-green-800 bg-green-300 font-extrabold rounded-full px-4';
        } else {
            return '';
        }
    },

    init() {
        window.addEventListener('open-modal', event => {
            this.inventory = event.detail.inventory;
            this.show = true;
        });
    }
}"
    x-init="init()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 mx-6"
    style="display: none;">
    <!-- Overlay (Backdrop) -->
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-stone-900 opacity-75"></div>
    </div>

    <div x-show="show"
        class="uppercase px-4 mx-4 mb-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-stone-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        @php
        $loggedInUser = Auth::user();
        @endphp
        <div class="flex justify-end mt-2">
            <button @click="show = false" class="text-green-200 hover:text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="head-title text-center pt-4">
            <span class="flex justify-center">
                <img src="{{ asset('images/TranscoLogo.png') }}" class="w-[100px]" />
            </span>
            <h1 class="text-red-600 font-bold text-lg p-4 dark:text-red-400">National Transmission Corporation</h1>
            <p class="text-md">RECORDS TURN-OVER / INVENTORY LIST FORM</p>
            <p><strong>Cost Center Head:</strong> {{ $loggedInUser->manager?->name ?? 'N/A' }}</p>
        </div>

        <div class="inventory-head text-sm w-full flex justify-center py-4">
            <div class="flex-1">
                <h3>Office origin: <span x-text="inventory.office_origin"></span></h3>
                <h3>turn-over date: <span x-text="new Date(inventory.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) ?? 'N/A'"></span></h3>
            </div>
            <div class="flex-1">
                <h3>prepared by: <span x-text="inventory.prepared_by"></span></h3>
                <h3>approved by:<span x-text="inventory.manager_approval ?? 'N/A'" :class="inventory.manager_approval ? 'bg-yellow-300' : 'bg-red-500'" class="px-2 rounded-full text-white"></span></h3>
            </div>
        </div>
        <div class="space-y-2 text-sm overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-200">
                    <tr>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">item no</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Description</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Doc Date</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Quantity</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Index Code</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Status</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Retention period</th>
                        <th class="whitespace-nowrap text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-stone-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="item in inventory.items" :key="item.id">
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.item_no"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.description"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.doc_date"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.quantity_code"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.index_code"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.status"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.retention_period ?? '—'"></td>
                            <td class="whitespace-nowrap px-4 py-2 text-center" x-text="item.disposal_date ? new Date(item.disposal_date).toLocaleDateString('en-US') : '—'"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class=" text-sm flex justify-center py-4">
            <div class="flex-1">
                <h3><strong>inventory list no.:</strong><span x-text="inventory.list_no" class="underline"></span></h3>
                <h3><strong>disposal series no.:</strong><span x-text="inventory.series_no" class="underline"></span></h3>
                <h3><strong>location code:</strong><span x-text="inventory.loc_code" class="underline"></span></h3>
            </div>
            <div class="flex-1">
                <h3><strong>recieved by:</strong><span x-text="inventory.recieved_by" class="underline"></span></h3>
                <h3><strong>date:</strong>
                    <span
                        x-text="inventory.recieve_date 
                                ? new Date(inventory.recieve_date).toLocaleString('en-US', {  
                                    month: 'short', 
                                    day: '2-digit', 
                                    year: 'numeric' 
                                    }) 
                                : 'N/A'" class="underline">
                    </span>
                </h3>
                <h3><strong>approved by(supervisor):</strong><span x-text="inventory.approved_by" class="underline"></span></h3>
                <h3><strong>date:</strong>
                    <span
                        x-text="inventory.approved_date 
                                ? new Date(inventory.approved_date).toLocaleString('en-US', {  
                                    month: 'short', 
                                    day: '2-digit', 
                                    year: 'numeric' 
                                    }) 
                                : 'N/A'" class="underline">
                    </span>
                </h3>
            </div>
        </div>
    </div>
</div>