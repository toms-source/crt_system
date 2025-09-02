<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-start mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>

            <a href="{{ route('form') }}">Form</a>
        </div>
    </div>

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800 shadow-sm shadow-green-800">
        <div>
            <p class="text-green-800 font-bold">
                hello <span class="capitalize underline">{{ Auth::user()->name }}</span> this is all the summary list/s of your completed approved by cost center head and admin RTO/Inventory.
            <div class="text-red-700 text-sm">
                <span class="uppercase text-red-700 text-sm font-extrabold mr-2">note*</span>all the list below will be controll by the admin
            </div>
            </p>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100">
        <h3 class="text-gray-800 dark:text-green-200 py-4 px-4 font-bold text-lg">Total Inventory: {{$totalArch}}</h3>
        <div class="flex justify-between items-center mx-2 mt-4 ">
            <h2 class="w-full py-6 px-4 bg-stone-600 text-gray-50 font-bold text-xl rounded-t-lg">Records Overview</h2>

        </div>
        <div class="mx-2">
            <div class="bg-zinc-200 dark:bg-stone-800 shadow overflow-hidden">
                <div>
                    <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l">
                        <table id="inventory-table" class="display nowrap dt-responsive text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700 drop-shadow-md shadow-stone-500" style="width:100%">
                            <thead class="bg-gray-50 dark:bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Inventory Id</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Turn-Over Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">cost center head</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
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
                                    ajax: "{{ route('user.reports') }}",
                                    columns: [{
                                            data: 'id',
                                            name: 'id'
                                        },
                                        {
                                            data: 'created_at',
                                            name: 'created_at'
                                        },
                                        {
                                            data: 'manager_approval',
                                            name: 'manager_approval'
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
    @include('modal.view-arch-inventory-modal')
</x-app-layout>