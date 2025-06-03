<x-app-layout>
    
    @if(auth()->user()->hasRole('admin'))
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div>
            <h1 class="text-xl font-bold text-green-400">Welcome, <span class="capitalize text-stone-800 dark:text-slate-50">{{Auth::user()->name}}</span></h1>
        </div>
        <div class="flex underline underline-offset-4">
            <a href="{{ route('admin.manage-accounts') }}">Manage Accounts</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
    @endif

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800 shadow-sm shadow-green-800">
        <div>
            <p class="text-green-800 font-bold">hello admin this is all your pending for recieveing and approval <span class="font-extrabold">RECORDS TURN-OVER</span> </p>
        </div>
    </div>

    <div class="text-gray-900 dark:text-gray-100 w-full py-6">
        <div class="text-xl mx-2 py-6 px-4 rounded-t-lg bg-stone-600 text-gray-50 font-bold">Records Turn-Over Inventory List</div>
        <div>
            <div class="px-2">
                <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l">
                    <table id="inventory-table" class="display nowrap dt-responsive text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700 drop-shadow-md shadow-stone-500" style="width:100%">
                        <thead class="bg-gray-50 dark:bg-gray-200">
                            <tr>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Item No</th>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Department</th>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">prepared by</th>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Cost Center Head</th>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal Date</th>
                                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
                    ajax: '{{ route("admin.index") }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'office_origin',
                            name: 'office_origin'
                        },
                        {
                            data: 'prepared_by',
                            name: 'prepared_by'
                        },
                        {
                            data: 'manager_approval',
                            name: 'manager_approval'
                        },
                        {
                            data: 'disposal_date',
                            name: 'disposal_date',
                            width: '200px',
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).addClass('max-w-[200px] break-words overflow-hidden whitespace-normal text-left');
                            },
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });
            });
        </script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

        <!-- DataTables Responsive JS -->
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        @include('modal.admin-view-inventory-modal')
        @include('modal.admin-edit-inventory-modal')
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
</x-app-layout>