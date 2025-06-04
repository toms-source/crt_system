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
        } else if (diffYears > 2) {
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
        <div class="head-title text-center pt-4">
            <span class="flex justify-center">
                <img src="{{ asset('images/TranscoLogo.png') }}" class="w-[100px]" />
            </span>
            <h1 class="text-red-600 font-bold text-lg p-4 dark:text-red-400">National Transmission Corporation</h1>
            <p class="text-md">RECORDS TURN-OVER / INVENTORY LIST FORM</p>
            <p><strong>Cost Center Head:</strong> {{ $loggedInUser->manager?->name ?? 'N/A' }}</p>
            <!-- <p class="text-sm">cost center head approval status:</p> -->
        </div>

        <div class="inventory-head text-sm w-full flex justify-center py-4">
            <div class="flex-1">
                <h3>Office origin: {{ $loggedInUser->office?->department ?? 'N/A' }}</h3>
                <h3>turn-over date: <span x-text="new Date(inventory.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) ?? 'N/A'"></span></h3>
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
            <p>
                <strong>disposal date:</strong>
                <span
                    class="underline"
                    :class="disposalYearClass"
                    x-text="inventory.disposal_date ? new Date(inventory.disposal_date).getFullYear() : 'N/A'">
                </span>
            </p>
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

        <div class="mt-6 text-right">
            <div class="p-8">
                <x-secondary-button @click="show = false">{{__('Close')}}</x-secondary-button>
            </div>
        </div>
    </div>
</div>