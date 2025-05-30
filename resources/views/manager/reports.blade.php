<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:hidden">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="link text-gray-700 dark:text-gray-200 flex justify-start mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>

            <a href="{{ route('manager.register') }}">Add User</a>
        </div>
    </div>

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800 shadow-sm shadow-green-800">
        <div>
            <p class="text-green-800 font-bold">
                hello manager this is all the list/s of completed RTO/Inventory by user under your provision
            <div class="text-red-700 text-sm">
                <span class="uppercase text-red-700 text-sm font-extrabold mr-2">note*</span>all the list below will be controll by the admin
            </div>
            </p>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center mx-2 mt-4 ">
            <h2 class="w-full py-6 px-4 bg-stone-600 text-gray-50 font-bold text-xl rounded-t-lg">RTO/Inventory History</h2>
        </div>
        <div class="mx-2">
            <div class="bg-zinc-200 dark:bg-stone-800 shadow overflow-hidden">
                <table id="inventory-table" class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Item No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Prepared By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Department Name(Double click to edit)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-green-900 uppercase tracking-wider">Disposal Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>