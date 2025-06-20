<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:hidden">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="link text-gray-700 dark:text-gray-200 flex justify-start mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>

            <a href="{{ route('manager.register') }}">Add User</a>
        </div>
    </div>

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800 shadow-sm shadow-green-800">
        <div>
            <p class="text-green-800 font-bold">
                hello manager this is all the list/s of completed RTO/Inventory by user under your provision
            <div class="text-red-700 text-sm">
                <span class="uppercase text-red-700 text-sm font-extrabold mr-2">note*</span>all the list below will be controll by the admin
            </div>
            </p>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100">
        <h3 class="text-gray-800 dark:text-green-200 py-4 px-4 font-bold text-lg">Total Inventory: {{$totalInv}}</h3>
        <div class="flex justify-between items-center mx-2 mt-4 ">
            <h2 class="w-full py-6 px-4 bg-stone-600 text-gray-50 font-bold text-xl rounded-t-lg">RTO/Inventory History</h2>
        </div>
        <div class="mx-2">
            <div class="bg-zinc-200 dark:bg-stone-800 shadow overflow-hidden">
                <div class="lg:block md:hidden sm:hidden xs:hidden">
                    <table id="inventory-table" class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Inventory Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Turn-Over Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Cost Center Heade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $managerArchiveInventory as $archInventory)
                            <tr class="border-b border-gray-300 dark:border-stone-700 hover:bg-gray-100 dark:hover:bg-stone-800">
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{$archInventory->id}}</td>
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">
                                    {{ Carbon\Carbon::parse($archInventory->created_at)->format('M-d-Y') }}
                                </td>
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{ $archInventory->manager_approval }}</td>
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{ $archInventory->disposal_status }}</td>
                                <td>
                                    <x-success-button
                                        x-data
                                        x-on:click="$dispatch('open-modal', { archInventory: {{ $archInventory->toJson() }}})">
                                        View
                                    </x-success-button>

                                    <a href="{{ route('print-arch-pdf', $archInventory->id) }}" target="_blank" class="text-white">
                                        <x-primary-button>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                            </svg>
                                            download
                                        </x-primary-button>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- mobile view -->
                <div class="lg:hidden md:block sm:block xs:block mt-4">
                    @foreach ( $managerArchiveInventory as $archInventory )
                    <div class="bg-stone-200 dark:bg-stone-700 border-t-8 border-green-500 overflow-hidden shadow shadow-stone-500 sm:rounded-lg mb-4">

                        <div class="p-4">
                            <div class="">
                                <strong>Item No: <span>{{ $archInventory->original_id }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Prepared By: <span>{{ $archInventory->prepared_by }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Cost Center Head: <span>{{ $archInventory->approved_by }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Disposal Date: <span>{{ $archInventory->disposal_date }}</span></strong>
                            </div>
                            <div class="mt-4">
                                <x-success-button
                                    x-data
                                    x-on:click="$dispatch('open-modal', { archInventory: {{ $archInventory->toJson() }}})">
                                    View
                                </x-success-button>
                                <x-primary-button>
                                    <a href="{{ route('print-arch-pdf', $archInventory->id) }}" target="_blank" class="text-white">PDF</a>
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    @include('modal.view-arch-inventory-modal')
</x-app-layout>