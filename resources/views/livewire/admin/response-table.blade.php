<x-app-layout>

    <div>
        <!-- component -->

        <body class="flex items-center justify-center">
            <div class="container">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                    <thead class="text-white">
                        <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="p-3 text-left">Nombre</th>
                            <th class="p-3 text-left">IMC</th>
                            <th class="p-3 text-left">Volemia</th>
                            <th class="p-3 text-left">Categoria</th>
                            <th class="p-3 text-left">Apto</th>
                        </tr>
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td class="border-grey-light border hover:bg-gray-100 p-3">{{ $namePatient }}</td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ round($response, 2) }}</td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ round($volemia, 2) }}</td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $categoria }}</td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $apto }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>

        <style>
            html,
            body {
                height: 100%;
            }

            @media (min-width: 640px) {
                table {
                    display: inline-table !important;
                }

                thead tr:not(:first-child) {
                    display: none;
                }
            }

            th, td {

                color: black;
            }

            td:not(:last-child) {
                border-bottom: 0;
            }

            th:not(:last-child) {
                border-bottom: 2px solid rgba(0, 0, 0, .1);
            }
        </style>
    </div>

</x-app-layout>