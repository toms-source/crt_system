<div
    x-data="{
        show: false,
        inventory: {},

        init() {
            window.addEventListener('open-modal', event => {
                this.inventory = event.detail.inventory;
                this.show = true;
            });
        }
    }"
    x-init="init()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
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
        class="uppercase px-4 mb-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-stone-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        @php
        $loggedInUser = Auth::user();
        @endphp
        <div class="head-title text-center">
            <h1 class="text-red-600 font-bold text-lg p-4 dark:text-red-400">National Transmission Corporation</h1>
            <p class="text-md">RECORDS TURN-OVER / INVENTORY LIST FORM</p>
            <p><strong>Cost Center Head:</strong> {{ $loggedInUser->manager?->name ?? 'N/A' }}</p>
            <!-- <p class="text-sm">cost center head approval status:</p> -->
        </div>

        <div class="inventory-head text-sm w-full flex justify-center py-4">
            <div class="flex-1">
                <h3>Office origin: {{ $loggedInUser->office?->department ?? 'N/A' }}</h3>
                <h3>turn-over date:  <span x-text="new Date(inventory.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) ?? 'N/A'"></span></h3>
            </div>
            <div class="flex-1">
                <h3>prepared by: <span class="underline font-bold">{{ $loggedInUser->name}}</span></h3>
                <h3>approved by:<span x-text="inventory.manager_approval ?? 'N/A'" :class="inventory.manager_approval ? 'bg-green-500' : 'bg-red-500'" class="px-2 rounded-full text-white"></span></h3>
            </div>
        </div>
        <div class="space-y-2 text-sm">
            <p><strong>Item No:</strong> <span x-text="inventory.id"></span></p>
            <p><strong>Description:</strong> <span x-text="inventory.description"></span></p>
            <p><strong>Doc Date:</strong>
                <span x-text="new Date(inventory.doc_date).getFullYear()"></span>
            </p>
            <p><strong>Quantity/unit code:</strong> <span x-text="inventory.quantity_code"></span></p>
            <p><strong>index code:</strong> <span x-text="inventory.index_code"></span></p>
            <p><strong>document status:</strong> <span x-text="inventory.status"></span></p>
            <p><strong>retention period:</strong> <span x-text="inventory.retention_period"></span><span class="pl-2">year/s</span></p>
            <p><strong>disposal date:</strong> <span x-text="new Date(inventory.disposal_date).getFullYear() ?? 'N/A'""></span></p>
        </div>
        <div class=" text-sm flex justify-center py-4">
                    <div class="flex-1">
                        <h3>inventory list no.:</h3>
                        <h3>disposal series no.:</h3>
                        <h3>location code:</h3>
                    </div>
                    <div class="flex-1">
                        <h3>recieved by:<span x-text="inventory.recieved_by"></span></h3>
                        <h3>date:<span x-text="inventory.recieve_date"></span></h3>
                        <h3>approved by(supervisor):<span x-text="inventory.approved_by"></span></h3>
                        <h3>
                            date:
                            <span
                                x-text="inventory.approved_date 
                                ? new Date(inventory.approved_date).toLocaleString('en-US', {  
                                    month: 'short', 
                                    day: '2-digit', 
                                    year: 'numeric' 
                                    }) 
                                : 'N/A'">
                            </span>
                        </h3>
                    </div>
        </div>

        <div class="mt-6 text-right">
            <div class="p-8">
                <x-secondary-button @click="show = false">{{__('Close')}}</x-secondary-button>
            </div>
        </div>
    </div>
</div>