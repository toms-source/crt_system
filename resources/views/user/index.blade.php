<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div>
            <h1 class="text-xl font-bold text-green-400">Welcome, <span class="capitalize text-stone-800 dark:text-slate-50">{{Auth::user()->name}}</span></h1>
        </div>

        <div class="flex underline underline-offset-4">
            <a href="{{ route('form') }}">Form</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100 w-full py-6 ">
        <h3 class="text-gray-800 dark:text-green-200 py-4 px-4 font-bold text-lg">Total Inventory: {{ $totalInv }}</h3>
        <div class="text-xl mx-2 py-6 px-4 rounded-t-lg bg-stone-600 text-gray-50 font-bold">Records Turn-Over Inventory List</div>
        <div>
            <div class="px-2">
                <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l">
                    <!-- show table when desktop mode -->
                    <div class="lg:block md:hidden sm:hidden xs:hidden">
                        <table id="inventory-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-200">
                                <tr>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Inventory ID</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">cost center head</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Approval Status</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal Status</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-stone-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                $loggedInUser = Auth::user();
                                @endphp

                                @forelse($inventories as $inventory)
                                <tr>
                                    <td class="px-6 py-4">{{ $inventory->id }}</td>
                                    <td class="px-6 py-4 capitalize">{{ $loggedInUser->manager?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 uppercase font-bold text-center text-sm">
                                        <span class="rounded-full px-4
                                                                @if(!is_null($inventory->approved_by)) bg-green-200 text-green-800
                                                                @elseif(is_null($inventory->approved_by)) bg-yellow-200 text-yellow-800
                                                                @endif">
                                            {{ $inventory->approved_by === null ? 'Pending...' : 'Approved' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 capitalize">{{ $inventory->disposal_status }}</td>
                                    <td class="px-6 py-4">
                                        <x-success-button
                                            x-data
                                            x-on:click="$dispatch('open-modal', { inventory: {{ $inventory->toJson() }}})">
                                            View
                                        </x-success-button>
                                        <a href="{{ route('print-pdf', $inventory->id) }}" target="_blank" class="text-white">
                                            <x-danger-button>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                                </svg>
                                                download
                                            </x-danger-button>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-300">
                                        No created Inventory yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- show cards when in mobile or tablet -->
                    <div class="lg:hidden md:block sm:block xs:block">
                        @foreach ( $inventories as $inventory )
                        <div class="bg-stone-200 dark:bg-stone-700 border-t-8 border-green-500 overflow-hidden shadow shadow-stone-500 sm:rounded-lg mb-4">

                            <div class="p-4">
                                <div class="">
                                    <strong>Inventory ID:</strong> <span>{{ $inventory->id }}</span>
                                </div>
                                <div class="">
                                    <strong>Cost Center Head:</strong> <span class="capitalize">{{ $loggedInUser->manager?->name ?? 'N/A' }}</span>
                                </div>
                                <div class="">
                                    <strong>Approval Status: <span class="rounded-full px-4
                                                                @if(!is_null($inventory->approved_by)) bg-green-200 text-green-800
                                                                @elseif(is_null($inventory->approved_by)) bg-yellow-200 text-yellow-800
                                                                @endif">
                                            {{ $inventory->approved_by === null ? 'Pending...' : 'Approved' }}
                                        </span></strong>
                                </div>
                                <div class="">
                                    <strong>Disposal Status:</strong> <span>{{ $inventory->disposal_status }}</span>
                                </div>
                                <div class="mt-4">
                                    <x-success-button
                                        x-data
                                        x-on:click="$dispatch('open-modal', { inventory: {{ $inventory->toJson() }}})">
                                        View
                                    </x-success-button>
                                    <a href="{{ route('print-pdf', $inventory->id) }}" target="_blank" class="text-white">
                                        <x-danger-button>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                            </svg>
                                            download
                                        </x-danger-button>
                                    </a>

                                </div>
                            </div>

                        </div>
                        @endforeach

                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>



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
    @include('modal.user-view-inventory-modal')
</x-app-layout>