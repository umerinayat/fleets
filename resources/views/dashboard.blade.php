<x-app-layout>
    @push('styles')
    <style>
        input[type=date] {
            height: 32px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @endpush
    
    <div class="page-header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard  
        </h2>
        <button @click="openModal" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Add Refuelling
        </button>
    </div>
    
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Fleets Refulling Readings:
    </h4>
    <div>
        <div>Select Date:</div>
        <input type="date" id="startDate">
        <input type="date" id="endDate">
        <select name="sfleet" class="fleets-selection" id="sfleet">
            <option></option>
            @foreach($fleets as $fleet)
            <option value="{{ $fleet->id }}">
                <div class="name">{{$fleet->fleet_number}}-{{$fleet->name}}</div>
            </option>
            @endforeach
        </select>
        <button class="btn" id="filterBtn">Reset</button>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap" id="fleetsReadingDt">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Fleet Number</th>
                        <th class="px-4 py-3">Litter Per hr. Avg</th>
                        <th class="px-4 py-3">Total Year Consumed</th>
                        <th class="px-4 py-3">Operating Hours</th>
                        <th class="px-4 py-3">Current Machine Hr.</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                </tbody>
            </table>
        </div>

    </div>

   

    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        <!-- Modal -->
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal">
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end">
                <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="mt-4 mb-6">
                <!-- Modal title -->
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    Add Refuelling
                </p>
                <!-- Modal description -->
                <form method="POST" class="p-6" action="{{ route('refuelling.store') }}">

                    @csrf
                    <!-- fleet selection -->
                    <div>
                        <x-label for="fleet" :value="__('Select Fleet: *')" />
                        <select name="fleet_id" class="fleets-selection" id="fleets-selection">
                            <option></option>
                            @foreach($fleets as $fleet)
                            <option value="{{ $fleet->id }}">
                                <div class="name">{{$fleet->fleet_number}}-{{$fleet->name}}</div>
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has('fleet_id'))
                        <div class="mt-2" style="color:red">{{ $errors->first('fleet_id') }}</div>
                        @endif
                    </div>
                    <!-- Fuel added -->
                    <div class="mt-4">
                        <x-label for="fuel_added" :value="__('Fuel added: (in Liters) *')" />

                        <x-input id="fuel_added" step="0.01" class="block mt-1 w-full" type="number" name="fuel_added" :value="old('fuel_added')" />
                        @if ($errors->has('fuel_added'))
                        <div class="mt-2" style="color:red">{{ $errors->first('fuel_added') }}</div>
                        @endif
                    </div>
                    <!-- machine hours -->
                    <div class="mt-4">
                        <x-label for="machine_hours" :value="__('Machine Hours: *')" />

                        <x-input id="machine_hours" step="0.01" class="block mt-1 w-full" type="number" name="machine_hours" :value="old('machine_hours')" />
                        @if ($errors->has('machine_hours'))
                        <div class="mt-2" style="color:red">{{ $errors->first('machine_hours') }}</div>
                        @endif
                    </div>
                    <!-- location -->
                    <div class="mt-4">
                        <x-label for="location" :value="__('Location: *')" />

                        <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" />
                        @if ($errors->has('location'))
                        <div class="mt-2" style="color:red">{{ $errors->first('location') }}</div>
                        @endif
                    </div>

                    <!-- date -->
                    <div class="mt-4">
                        <x-label for="date" :value="__('Date: *')" />

                        <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" />
                        @if ($errors->has('date'))
                        <div class="mt-2" style="color:red">{{ $errors->first('date') }}</div>
                        @endif
                    </div>

                    <!-- isTankFilled -->
                    <div class="mt-4">
                        <x-label for="isTankFilled" :value="__('Is Tank Filled:')" />

                        <x-input id="isTankFilled" class="block mt-1" type="checkbox" name="isTankFilled" :value="old('isTankFilled')" />
                        @if ($errors->has('isTankFilled'))
                        <div class="mt-2" style="color:red">{{ $errors->first('isTankFilled') }}</div>
                        @endif
                    </div>

                    <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                  {{  __('Add') }}
                </button>


                </form>
            </div>
            <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </button>
               
            </footer>
        </div>
    </div>
    <!-- End of modal backdrop -->

    @push('scripts')
    <script>
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        const sfleet = document.getElementById('sfleet');
        const filterBtn = document.getElementById('filterBtn');
        let isFilter = false;

        startDate.value = moment().startOf('quarter').subtract(1, 'year').format('YYYY-MM-DD');
        endDate.value = moment().startOf('quarter').subtract(1, 'days').format('YYYY-MM-DD');

        filterBtn.addEventListener('click', function(event) {
            $("#sfleet").val('');
            $("#sfleet").trigger('change.select2');
            startDate.value = moment().startOf('quarter').subtract(1, 'year').format('YYYY-MM-DD');
            endDate.value = moment().startOf('quarter').subtract(1, 'days').format('YYYY-MM-DD');
            $('#fleetsReadingDt').DataTable().ajax.reload();
        });

        startDate.addEventListener('change', function() {
            $('#fleetsReadingDt').DataTable().ajax.reload();
        });

        endDate.addEventListener('change', function() {
            $('#fleetsReadingDt').DataTable().ajax.reload();
        });



        $('#sfleet').on('select2:select', function(e) {
            $('#fleetsReadingDt').DataTable().ajax.reload();
        });


        const fleetsJson = '{!! $fleets !!}';

        const fleets = JSON.parse(fleetsJson);

        const fleetImages = fleets.reduce((obj, item) => Object.assign(obj, {
            [item.fleet_number + '-' + item.name]: item.image_url
        }), {});

        function formatState(state) {

            if (!state.id) {
                return state.text;
            }
            var $state = $(
                `<div class="foption"> 
                    <div class="flabel"> ${state.text} </div>
                    <div class="fimage"> <img src="${fleetImages[state.text.trim()]}" class="img-flag" /> </div>
                 </div>`
            );
            return $state;
        };

        $("#fleets-selection").select2({
            templateResult: formatState,
            placeholder: 'Select a fleet'
        });

        $('#sfleet').select2({
            templateResult: formatState,
            placeholder: 'Select a fleet'
        });

        $(function() {
            var table = $('#fleetsReadingDt').DataTable({
                processing: true,
                serverSide: true,
                "bPaginate": false,
                "bLengthChange": false,
                "searching": false,
                ajax: {
                    url: "{{ route('dashboard') }}",
                    "data": function(d) {
                        d.sdate = startDate.value;
                        d.edate = endDate.value;
                        d.sfleet = sfleet.value
                    },
                },
                columns: [
                    // {
                    //     data: 'fleet_name',
                    //     name: 'fleet_name'
                    // },
                    {
                        data: 'fleet_number',
                        name: 'fleet_number'
                    },
                    {
                        data: 'littersPerHours',
                        name: 'littersPerHours'
                    },
                    {
                        data: 'totalFuelConsumption',
                        name: 'totalFuelConsumption'
                    },
                    {
                        data: 'operatingHours',
                        name: 'operatingHours'
                    },
                    {
                        data: 'currentMachineReading',
                        name: 'currentMachineReading'
                    }


                ]
            });
        });
    </script>
    @endpush
</x-app-layout>