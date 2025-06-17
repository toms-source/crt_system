<div
    x-data="{ show: false, inventory: {} }"
    x-on:edit-modal.window="show = true; inventory = $event.detail.inventory"
    x-show="show"
    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="text-gray-900 dark:text-gray-100 bg-white dark:bg-stone-800 rounded-lg w-full max-w-md px-4 py-8">
        <h2 class="text-lg font-bold mb-4 uppercase">Inventory footer</h2>

        <form
            x-on:submit.prevent="
                fetch(`/admin/inventories/${inventory.id}/update`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        list_no: inventory.list_no,
                        series_no: inventory.series_no,
                        loc_code: inventory.loc_code
                    })
                }).then(() => {
                    show = false;
                    window.location.reload(); // or re-fetch table
                })
            ">
            <label class="block mb-2">Series No:</label>
            <input type="text" x-model="inventory.series_no" class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-60 mb-4">

            <label class="block mb-2">Loc Code:</label>
            <input type="text" x-model="inventory.loc_code" class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-60 mb-4">

            <div class="flex justify-end space-x-2">
                <x-secondary-button type="button" x-on:click="show = false" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</x-secondary-button>
                <x-green-button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</x-green-button>
            </div>
        </form>
    </div>
</div>