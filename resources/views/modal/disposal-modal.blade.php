<div x-show="showDisposeModal"
    x-transition
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-stone-700 rounded-lg shadow-lg p-6 w-full max-w-md mx-auto">
        <h2 class="text-xl font-bold text-red-600 dark:text-red-400 mb-4">Confirm Disposal</h2>
        <p class="text-gray-700 dark:text-gray-200 mb-6">Are you sure you want to dispose this inventory?</p>

        <div class="flex justify-end space-x-4">
            <button @click="showDisposeModal = false"
                class="px-4 py-2 bg-gray-300 dark:bg-stone-600 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-stone-500">
                Cancel
            </button>
            <button @click="disposeInventory"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Yes, Dispose
            </button>
        </div>
    </div>
</div>