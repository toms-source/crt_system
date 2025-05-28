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
    
    <!-- warning -->
    <div class="flex justify-center align-center">
        <img src="{{ asset('images/under_construction.svg') }}" alt="" class="w-72">
    </div>
    <div class="flex align-center justify-center text-red-700">
        <h1 class="text-lg font-extrabold ">DO NOT ENTER</h1>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
        </svg>
    </div>
</x-app-layout>