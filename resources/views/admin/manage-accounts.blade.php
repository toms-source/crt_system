<x-app-layout>
    <div class="link text-gray-700 dark:text-gray-200 flex justify-between mt-2 px-4 font-bold">
        <div class="flex underline underline-offset-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <a href="{{ route('admin.index') }}">Dashboard</a>
        </div>

        <div class="flex underline underline-offset-4">
            <a href="{{ route('admin.registerForm') }}">Add Manager</a>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
    <header class="flex justify-between items-center mx-10 my-4">
        <h2 class="py-4 px-6 xs:px-2 dark:bg-stone-800 bg-green-300 rounded-lg text-xl xs:text-md font-semibold text-green-800">Cost Center Manager & Users</h2>
    </header>

    <div class="mx-auto sm:px-6 lg:px-8 xs:mx-4">
        @if($users->count() > 0)
        @include('admin.manage-accounts.filter-users')
        @include('admin.manage-accounts.retrieve-users')
        @include('admin.manage-accounts.retrieve-user-pagination')
        @else
        <p class="text-red-500 text-center">No users found.</p>
        <x-danger-button class="flex justify-center align-center w-full">
            <a href="{{ route('admin.manage-accounts') }}">Go back</a>
        </x-danger-button>
        @endif
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