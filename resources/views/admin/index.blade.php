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

    <div class="mx-2 mt-5 px-4 py-6 bg-green-300 rounded-md border-4 border-green-300 border-l-green-800">
        <div >
            <p class="text-green-800 font-bold">hello admin this is all your pending for recieveing and approval <span class="font-extrabold">RECORDS TURN-OVER</span> </p>
        </div>
    </div>

    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-2 flex">
            <div class="flex-1 bg-white dark:bg-stone-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section>
                        <div x-data="{ tab: 'tab1' }" class="w-full mx-auto">
                            <!-- Tab Headers -->
                            <div class="flex border-b border-gray-200 dark:border-stone-700">
                                <template x-for="(label, index) in ['Incoming', 'Completed', 'Approved']" :key="index">
                                    <button
                                        @click="tab = 'tab' + (index + 1)"
                                        class="relative w-full text-center py-3 text-sm font-medium text-gray-600 dark:text-gray-300 focus:outline-none transition duration-300"
                                        :class="tab === 'tab' + (index + 1) ? 'text-blue-600 dark:text-blue-400' : ''">
                                        <span x-text="label"></span>
                                        <!-- Active Tab Indicator -->
                                        <span
                                            class="absolute left-0 bottom-0 h-0.5 w-full bg-green-600 dark:bg-green-400 transform scale-x-0 transition-transform duration-300 ease-in-out"
                                            :class="tab === 'tab' + (index + 1) ? 'scale-x-100' : ''"></span>
                                    </button>
                                </template>
                            </div>

                            <!-- Tab Contents -->
                            <div class="mt-6 p-4 bg-white dark:bg-stone-800 rounded-lg shadow-sm border border-gray-200 dark:border-stone-700">
                                <div x-show="tab === 'tab1'" x-transition>
                                    <div class="">
                                        @include('admin.index.recieve-tab')
                                    </div>
                                </div>
                                <div x-show="tab === 'tab2'" x-transition>
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Material Tab 2</h2>
                                    <p class="text-gray-600 dark:text-gray-400">
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

                                    </p>
                                </div>
                                <div x-show="tab === 'tab3'" x-transition>
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Material Tab 3</h2>
                                    <p class="text-gray-600 dark:text-gray-400">
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

                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
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