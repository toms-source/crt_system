<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div>
            <h1 class="text-xl font-bold text-green-400">Welcome, <span class="capitalize text-stone-800 dark:text-slate-50">{{Auth::user()->name}}</span></h1>
        </div>

        <div class="flex underline underline-offset-4">
            <a href="{{ route('user.reports') }}">Reports</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-2 flex">
            <div class="flex-1 bg-white dark:bg-stone-800 shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section>
                        <h1>My RTO inventory</h1>

                        <div class="mt-4">
                            <div class="mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                                    <table id="inventory-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-stone-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item No</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">cost center head</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Approval Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white dark:bg-stone-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @php
                                            $loggedInUser = Auth::user();
                                            @endphp

                                            @forelse($inventories as $inventory)
                                            <tr>
                                                <td class="px-6 py-4">{{ $inventory->id }}</td>
                                                <td class="px-6 py-4 max-w-[150px] truncate whitespace-nowrap overflow-hidden">{{ $inventory->description }}</td>
                                                <td class="px-6 py-4">{{ $loggedInUser->manager?->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 uppercase font-bold text-center text-sm">
                                                    <span class="rounded-full px-4
                                                                @if(!is_null($inventory->approved_by)) bg-green-200 text-green-800
                                                                @elseif(is_null($inventory->approved_by)) bg-yellow-200 text-yellow-800
                                                                @endif">
                                                        {{ $inventory->approved_by === null ? 'Pending...' : 'Approved' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <x-success-button
                                                        x-data
                                                        x-on:click="$dispatch('open-modal', { inventory: {{ $inventory->toJson() }}})">
                                                        View
                                                    </x-success-button>
                                                    <x-danger-button>
                                                        <a href="{{ route('print-pdf', $inventory->id) }}" target="_blank" class="text-white">PDF</a>
                                                    </x-danger-button>
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
                            </div>
                        </div>
                    </section>
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
    @include('user.index.view-inventory-modal')
</x-app-layout>