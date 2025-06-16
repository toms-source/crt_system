<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-start mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>

            <a href="{{ route('admin.office') }}">Manager Office</a>
        </div>
    </div>
    <header class="flex justify-between items-center mx-2 mt-4">
        <h2 class="w-full py-6 px-4 bg-stone-600 text-gray-50 font-bold text-xl rounded-t-lg">Summary Reports</h2>
    </header>
    <div>
        <div class="py-4 sm:px-6 bg-white dark:bg-stone-800 shadow shadow-stone-500/50 text-gray-900 dark:text-gray-100 mx-2 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                <div class="card shadow-md rounded-md border-l-4 border-green-500 bg-stone-200 dark:bg-stone-700">
                    <div class="flex w-full justify-between text-lg px-8 pt-8">
                        <p>
                            <strong class="text-green-800 dark:text-green-100">Registered User:</strong>
                        </p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 p-2 rounded-full bg-green-100 text-green-800">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="flex justify-center content-center w-full h-full pb-8">
                        <strong class="text-2xl">{{ $users }}</strong>
                    </div>
                </div>

                <div class="card shadow-md rounded-md border-l-4 border-orange-500 bg-stone-200 dark:bg-stone-700">
                    <div class="flex w-full justify-between text-lg px-8 pt-8">
                        <p>
                            <strong class="text-green-800 dark:text-green-100">Archives RTO Inventory</strong>
                        </p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 p-2 rounded-full bg-green-100 text-green-800">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <div class="flex justify-center content-center w-full h-full pb-8">
                        <strong class="text-2xl">{{ $inventories}}</strong>
                    </div>

                </div>

                <div class="card shadow-md rounded-md border-l-4 border-blue-500 bg-stone-200 dark:bg-stone-700">
                    <div class="flex w-full justify-between text-lg px-8 pt-8">
                        <p>
                            <strong class="text-green-800 dark:text-green-100">Registered Office:</strong>
                        </p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12 p-2 rounded-full bg-green-100 text-green-800">
                            <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex justify-center content-center w-full h-full pb-8">
                        <strong class="text-2xl">{{ $office }}</strong>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mx-2 mt-4 ">
            <h2 class="w-full py-6 px-4 bg-stone-600 text-gray-50 font-bold text-xl rounded-t-lg">RTO/Inventory History</h2>
        </div>
        <div class="mx-2">
            <div class="bg-zinc-200 dark:bg-stone-800 shadow overflow-hidden">
                <div class="lg:block md:hidden sm:hidden xs:hidden">
                    <table id="inventory-table" class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Item No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Prepared by</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">cost center head</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $adminArchiveInventory as $archInventory)
                            <tr class="border-b border-gray-300 dark:border-stone-700 hover:bg-gray-100 dark:hover:bg-stone-800">
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{$archInventory->original_id}}</td>
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{$archInventory->prepared_by}}</td>
                                <td class="py-3 px-6 text-left text-gray-700 dark:text-gray-200">{{$archInventory->manager_approval}}</td>
                                <td>
                                    <div class="flex items-center gap-4">
                                        <x-success-button
                                        x-data
                                        x-on:click="$dispatch('open-modal', { archInventory: {{ $archInventory->toJson() }}})">
                                        View
                                    </x-success-button>
                                    <form action="{{ route('archInventory.destroy', $archInventory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit">Delete</x-danger-button>
                                    </form>
                                    <x-primary-button>
                                        <a href="{{ route('print-arch-pdf', $archInventory->id) }}" target="_blank" class="text-white">PDF</a>
                                    </x-primary-button>
                                </div>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('pagination.adminArchInventory-pagination')

                </div>
                <!-- mobile view -->
                <div class="lg:hidden md:block sm:block xs:block mt-4">
                    @foreach ( $adminArchiveInventory as $archInventory )
                    <div class="bg-stone-200 dark:bg-stone-700 border-t-8 border-green-500 overflow-hidden shadow shadow-stone-500 sm:rounded-lg mb-4">

                        <div class="p-4">
                            <div class="">
                                <strong>Item No: <span>{{ $archInventory->original_id }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Prepared By: <span>{{ $archInventory->prepared_by }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Cost Center Head: <span>{{ $archInventory->manager_approval }}</span></strong>
                            </div>
                            <div class="">
                                <strong>Disposal Date: <span>{{ $archInventory->disposal_date }}</span></strong>
                            </div>
                            <div class="flex gap-4 mt-4">
                                <x-success-button
                                    x-data
                                    x-on:click="$dispatch('open-modal', { archInventory: {{ $archInventory->toJson() }}})">
                                    View
                                </x-success-button>
                                <form action="{{ route('archInventory.destroy', $archInventory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">Delete</x-danger-button>
                                </form>
                                <x-primary-button>
                                    <a href="{{ route('print-arch-pdf', $archInventory->id) }}" target="_blank" class="text-white">PDF</a>
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @include('pagination.adminArchInventory-pagination')
                </div>

            </div>
        </div>
    </div>
    @include('modal.view-arch-inventory-modal')
</x-app-layout>