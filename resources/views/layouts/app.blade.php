<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
   
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            .dataTables_wrapper {
                width: 100% !important;
            }

            .select2-container--default .select2-results>.select2-results__options{
                max-height: 400px !important;
            }

            .icon {
                cursor: pointer;
                margin-right: 12px;
            }

            .edit-icon {
                color: green;
            }

            .trash-icon {
                color: red
            }

            select {
                background-position: right -5px center;
            }

            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }

            #fleets-selection {
                width: 300px;
            }

            .foption {
                padding-bottom: 8px;
                border-bottom: 2px solid #B8A009;
            }

            .flabel {
                font-size: 19px;
                font-weight: bold;
                text-align: center;
            }

            .select2-container--default .select2-results__option {
                background-color: #fff;
                color: #000;
            }
            
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color:  #B8A009;
                color: #000;
            }
            

            table thead tr th {
                font-size: .84rem;
            }
            

        </style>

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        @stack('scripts')

    </body>
</html>
