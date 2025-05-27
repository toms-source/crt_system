<div class="text-lg">Records Turn-Over Inventory List</div>
<div class="py-4">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-2">
        <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l border border-gray-500">
            <table id="inventory-table" class="display nowrap dt-responsive text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700" style="width:100%">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item No</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">prepared by</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost Center Head</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
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
                    data: 'description',
                    name: 'description',
                    width: '200px',
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('max-w-[200px] truncate whitespace-nowrap overflow-hidden text-left');
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

@include('admin.index.view-inventory-modal')