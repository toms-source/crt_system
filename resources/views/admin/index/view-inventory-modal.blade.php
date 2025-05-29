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
        <div class="head-title text-center pt-4">
            <span class="flex justify-center">
                <img src="{{ asset('images/TranscoLogo.png') }}" class="w-[100px]" />
            </span>
            <h1 class="text-red-600 font-bold text-lg p-4 dark:text-red-400">National Transmission Corporation</h1>
            <p class="text-md">RECORDS TURN-OVER / INVENTORY LIST FORM</p>
            <p><strong>Cost Center Head:</strong><span x-text="inventory.manager_approval"></span></p>
        </div>

        <div class="inventory-head text-sm w-full flex justify-center py-4">
            <div class="flex-1">
                <h3>Office origin: <span x-text="inventory.office_origin"></span></h3>
                <h3>turn-over date: <span x-text="new Date(inventory.doc_date).getFullYear() ?? 'N/A'"></span></h3>
            </div>
            <div class="flex-1">
                <h3>prepared by: <span class="underline font-bold" x-text="inventory.prepared_by"></span></h3>
                <h3>approved by:<span x-text="inventory.manager_approval ?? 'N/A'" :class="inventory.manager_approval ? 'bg-green-300' : 'bg-red-500'" class="px-2 rounded-full text-green-800"></span></h3>
            </div>
        </div>
        <div class="space-y-2 text-sm">
            <p><strong>Item No:</strong> <span class="underline" x-text="inventory.id"></span></p>
            <p class="flex gap-1 items-start">
                <strong>Description:</strong>
                <span
                    class="underline block max-w-[400px] truncate"
                    :title="inventory.description"
                    x-text="inventory.description">
                </span>
            </p>
            <p><strong>Doc Date:</strong>
                <span class="underline" x-text="new Date(inventory.doc_date).getFullYear()"></span>
            </p>
            <p><strong>Quantity/unit code:</strong> <span class="underline" x-text="inventory.quantity_code"></span></p>
            <p><strong>index code:</strong> <span class="underline" x-text="inventory.index_code"></span></p>
            <p><strong>document status:</strong> <span class="underline" x-text="inventory.status"></span></p>
            <p><strong>retention period:</strong> <span class="underline" x-text="inventory.retention_period"></span><span class="pl-2">year/s</span></p>
            <p><strong>disposal date:</strong> <span class="underline" x-text="new Date(inventory.disposal_date).getFullYear() ?? 'N/A'""></span></p>
        </div>
        <div class=" text-sm flex justify-center py-4">
                    <div class="flex-1">
                        <h3>inventory list no.:</h3>
                        <h3>disposal series no.:</h3>
                        <h3>location code:</h3>
                    </div>
                    <div class="flex-1">
                        <h3><strong>recieved by:</strong><span x-text="inventory.recieved_by" :class="inventory.recieved_by ? 'bg-green-300' : 'bg-red-500'" class="px-2 rounded-full text-green-800"></span></h3>
                        <h3><strong>date:</strong><span
                                x-text="inventory.recieve_date 
                                ? new Date(inventory.recieve_date).toLocaleString('en-US', {  
                                    month: 'short', 
                                    day: '2-digit', 
                                    year: 'numeric' 
                                    }) 
                                : 'N/A'">
                            </span></h3>
                        <h3><strong>approved by(supervisor):</strong><span x-text="inventory.approved_by" :class="inventory.approved_by ? 'bg-green-300' : 'bg-red-500'" class="px-2 rounded-full text-green-800"></span></h3>
                        <h3><strong>date:</strong>
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
                <div class="flex justify-between">
                    <div>
                        <x-secondary-button @click="show = false">{{__('Close')}}</x-secondary-button>
                    </div>

                    <div class="flex gap-4">
                        <x-danger-button>{{__('delete')}}</x-danger-button>
                        <form :action="'{{ route('admin.recieve') }}'" method="POST" x-show="!inventory.recieved_by">
                            @csrf
                            <input type="hidden" name="id" :value="inventory.id">
                            <x-success-button type="submit">{{__('receive')}}</x-success-button>
                        </form>
                        <template x-if="inventory.recieved_by">
                            <p class="text-green-700 dark:text-green-200 flex align-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>


                                {{ __('Recieved') }}
                            </p>
                        </template>

                        <form :action="'{{ route('admin.approve') }}'" method="POST" x-show="!inventory.approved_by">
                            @csrf
                            <input type="hidden" name="id" :value="inventory.id">
                            <x-primary-button type="submit">{{__('approve')}}</x-primary-button>
                        </form>
                        <template x-if="inventory.approved_by">
                            <p class="text-blue-700 dark:text-blue-200 flex align-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ __('Approved') }}
                            </p>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@if (session('success'))
<div x-data="{ show: true }" x-show="show"
    class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded shadow-lg"
    x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-2 rounded my-4 text-center">
    {{ session('success') }}
</div>
@endif