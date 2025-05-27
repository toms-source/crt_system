<div class="text-lg">Records Turn-Over Inventory List</div>
<div class="py-4">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-2">
        <div class="bg-white dark:bg-stone-800 p-4 shadow overflow-hidden sm:rounded-l border border-gray-500">
            <table id="inventory-table" class="text-center min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item No</th>
                        <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                        <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">prepared by</th>
                        <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost Center Head</th>
                        <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="text-center px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
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
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.index") }}',
            columns: [{
                    data: 'id',
                    name: 'id',
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
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: 1, // Index of the 'description' column
                render: function(data, type, row) {
                    let maxChars = 50;
                    return data.length > maxChars ? data.substr(0, maxChars) + '…' : data;
                },
                className: 'max-w-[250px] truncate'
            }]
        });
    });
</script>

@include('admin.index.view-inventory-modal')