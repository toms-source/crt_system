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
        <h3 class="text-gray-800 dark:text-green-200 py-4 px-4 font-bold text-lg">Total Inventory: {{ $inventories }}</h3>
        <div class="text-xl mx-2 py-6 px-4 rounded-t-lg bg-stone-600 text-gray-50 font-bold">Records Turn-Over Inventory List</div>
        <div>
            <div class="px-2">
                <div class="bg-zinc-200 dark:bg-stone-800 shadow overflow-hidden">
                    <!-- show table when desktop mode -->
                    <div>
                        <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l">
                            <table id="inventory-table" class="display nowrap dt-responsive text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700 drop-shadow-md shadow-stone-500" style="width:100%">
                                <thead class="bg-gray-50 dark:bg-gray-200">
                                    <tr>
                                        <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Inventory ID</th>
                                        <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">cost center head</th>
                                        <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Approval Status</th>
                                        <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal Status</th>
                                        <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                            </table>


                            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
                            <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

                            <script>
                                $(function() {
                                    $('#inventory-table').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        responsive: true,
                                        ajax: "{{ route('user.index') }}",
                                        columns: [{
                                                data: 'id',
                                                name: 'id'
                                            },
                                            {
                                                data: 'manager_approval',
                                                name: 'manager_approval'
                                            },
                                            {
                                                data: 'approved_by',
                                                name: 'approved_by',
                                                render: function(data) {
                                                    if (!data) {
                                                        return '<span class="text-yellow-800 font-semibold bg-yellow-200 px-4 py-2 rounded-full">Pending...</span>';
                                                    } else {
                                                        return '<span class="text-green-800 font-semibold bg-green-200 px-4 py-2 rounded-full">Approved</span>';
                                                    }
                                                }
                                            },
                                            {
                                                data: null,
                                                name: 'disposal_status',
                                                width: '200px',
                                                render: function(data) {
                                                    if (data.disposal_status === 'disposed') {
                                                        let date = new Date(data.disposed_date);
                                                        let formattedDate = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();

                                                        return `<span class="text-red-800 font-semibold bg-red-200 px-4 py-2 rounded-full">
                                                    Disposed (${formattedDate})
                                                </span>`;
                                                    } else if (data.disposal_status === 'for disposal') {
                                                        return '<span class="text-yellow-800 font-semibold bg-yellow-200 px-4 py-2 rounded-full">For Disposal</span>';
                                                    } else {
                                                        return `<span class="text-gray-600 dark:text-gray-300">${data.disposal_status ?? 'N/A'}</span>`;
                                                    }
                                                }
                                            },
                                            {
                                                data: 'action',
                                                name: 'action',
                                                orderable: false,
                                                searchable: false
                                            },
                                        ],
                                        pagingType: "simple_numbers",
                                        language: {
                                            search: "_INPUT_",
                                            searchPlaceholder: "Search...",
                                            lengthMenu: "Show _MENU_ entries",

                                        },
                                        drawCallback: function() {
                                            $('#inventory-table_paginate').addClass('flex items-center gap-2 mt-4');
                                            $('#inventory-table_paginate a').addClass('px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600');
                                            $('#inventory-table_paginate .current').addClass('bg-green-600 text-white');
                                        }
                                    });
                                });
                            </script>

                        </div>
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