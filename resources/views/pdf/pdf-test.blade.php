<x-app-layout>
    <div class="border py-4 dark:text-stone-50">

        <head class="px-4">
            <div class="w-full flex align-center justify-around border-b border-stone-50">
                <div class="flex flex-col justify-center align-center my-4">
                    <div class=" flex justify-center align-center">
                        <img src="{{ asset('images/TranscoLogo.png') }}" alt="TranscoLogo" class="w-[100px]" />
                    </div>
                    <p class="text-red-500">National Transmission Corporation</p>
                </div>

                <div class="flex justify-center align-center">
                    <h1 class="uppercase text-lg font-bold ">RECORDS TURN-OVER / INVENTORY LIST FORM</h1>
                </div>
            </div>
        </head>


        <div class="top flex w-full my-5 px-4">
            <div class="left flex-1">
                <h1 class="uppercase">office origin:<span class="capitalize ml-3">HR</span></h1>
                <h1 class="uppercase">Turn-Over Date:<span class="capitalize ml-3">may, 26 2025</span></h1>
            </div>
            <div class="right flex-1">
                <h1 class="uppercase">Prepared/Turn-over By:<span class="capitalize ml-3">User</span></h1>
                <h1 class="uppercase">Approved by:<span class="capitalize ml-3">manager</span></h1>
            </div>
        </div>

        <div class="body">
            <table class="border border-red-100 w-full">
                <thead>
                    <th>Item No</th>
                    <th class="border-x-2 border-red-50 uppercase">Document Description</th>
                    <th class="border-x-2 border-red-50 uppercase">Doc Date</th>
                    <th class="border-x-2 border-red-50 uppercase">Quantity/Unit Code</th>
                    <th class="border-x-2 border-red-50 uppercase">Index Code</th>
                    <th class="border-x-2 border-red-50 uppercase">Status</th>
                    <th class="border-x-2 border-red-50 uppercase">Retention Period</th>
                    <th>Disposal Date</th>
                </thead>

                <tbody class="border border-red-100">
                    <tr class="text-center">
                        <td>121</td>
                        <td class="text-left border-x-2 border-red-50"">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus labore nam corrupti, in fugiat ab assumenda provident nesciunt.</td>
                        <td class="border-x-2 border-red-50">May/26/2025</td>
                        <td class="border-x-2 border-red-50">23fedw2</td>
                        <td class="border-x-2 border-red-50">sdc211</td>
                        <td class="border-x-2 border-red-50">Permanent</td>
                        <td class="border-x-2 border-red-50">1 Year/s</td>
                        <td>2024</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>