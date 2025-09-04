<x-app-layout>
    @if(auth()->user()->hasRole('manager'))
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div>
            <h1 class="text-xl font-bold text-green-400">Welcome, <span class="capitalize text-stone-800 dark:text-slate-50">{{Auth::user()->name}}</span></h1>
        </div>
        <div class="flex underline underline-offset-4">
            <a href="{{ route('manager.register') }}">Add User</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
    @endif

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800">
        <div>
            <p class="text-green-800 font-bold">hello Cost Center Head this is all your pending for approval <span class="font-extrabold">RECORDS TURN-OVER</span> </p>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100 w-full py-6">
        <div class="text-xl mx-2 py-6 px-4 rounded-t-lg bg-stone-600 text-gray-50 font-bold">Records Turn-Over Inventory List</div>
        <div>
            <div class="px-2">
                <div class="text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l">
                        <table id="inventory-table" class="display nowrap dt-responsive text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700 drop-shadow-md shadow-stone-500" style="width:100%">
                            <thead class="bg-gray-50 dark:bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Inventory ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">prepared by</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Turn-Over Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Approval Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">disposal Status</th>
                                    <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Date of disposed</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script>
                    $(function() {
                        $('#inventory-table').DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            initComplete: function() {
                                const $searchInput = $('div.dataTables_filter input');
                                $searchInput
                                    .addClass('mb-4 px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-stone-800 text-gray-900 dark:text-gray-100')
                                    .attr('placeholder', 'Search...');

                                const $select = $('div.dataTables_length select');
                                $select
                                    .addClass('px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-stone-800 text-gray-900 dark:text-gray-100');
                                $select.find('option').each(function() {
                                    this.style.color = document.documentElement.classList.contains('dark') ? '#f9fafb' : '#1f2937';
                                    this.style.backgroundColor = document.documentElement.classList.contains('dark') ? '#1c1917' : '#ffffff';
                                });
                            },
                            ajax: '{{ route("manager.index") }}',
                            columns: [{
                                    data: 'id',
                                    name: 'id',
                                },
                                {
                                    data: 'prepared_by',
                                    name: 'prepared_by'
                                },
                                {
                                    data: 'created_at',
                                    name: 'created_at',
                                    orderable: false,
                                    searchable: false,
                                    width: '200px',
                                },
                                {
                                    data: 'manager_approval',
                                    name: 'manager_approval',
                                    render: function(data, type, row) {
                                        return data ? '<span class="px-4 py-2 bg-green-300 text-green-700 font-bold rounded">Approved</span>' : '<span class="px-4 py-2 bg-yellow-300 text-yellow-700 font-bold rounded-full">Pending</span>';
                                    },
                                },
                                {
                                    data: null,
                                    name: 'disposal_status',
                                    width: '200px',
                                    render: function(data) {
                                        if (data.disposal_status === 'disposed') {
                                            return `<span class="text-red-800 font-semibold bg-red-200 px-4 py-2 rounded">
                                                    Disposed
                                                </span>`;
                                        } else if (data.disposal_status === 'disposal') {
                                            return '<span class="text-yellow-800 font-semibold bg-yellow-200 px-4 py-2 rounded">Disposal</span>';
                                        } else {
                                            return `<span class="text-gray-600 dark:text-gray-300">${data.disposal_status ?? 'N/A'}</span>`;
                                        }
                                    }
                                },
                                {
                                    data: 'disposed_date',
                                    name: 'disposed_date',
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
                            ]
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    @include('modal.manager-view-inventory-modal')
</x-app-layout>