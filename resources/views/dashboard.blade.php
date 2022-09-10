<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden pb-6">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3">
                    <div class="flex flex-col col-span-2 bg-white  rounded-lg shadow-md">
                    <div class="bg-white border-b border-gray-200 p-2 mb-3">
                            <span class="text-gray-600/80">Fleets Refulling Readings:</span>
                        </div>
                            <table id="fleetsReadingDt" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Fleet Number</th>
                                        <th>Litter Per hr. Avg</th>
                                        <th>Total Year Consumed</th>
                                        <th>Operating Hours</th>
                                        <th>Current Machine Hr.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center">
                                        <td>44</td>
                                        <td>{{number_format($littersPerHours, '2')}}</td>
                                        <td>{{$totalFuelConsumption}}</td>
                                        <td>{{$operatingHours}}</td>
                                        <td>{{$totalFuelConsumption}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-col justify-self-end bg-white rounded-lg shadow-md" style="width: 350px">
                            <div class="bg-white border-b border-gray-200 p-2">
                             
                                <span class="text-gray-600/80">  Add Refuelling:</span>
                            </div>

                            <form method="POST" class="p-6" action="{{ route('refuelling.store') }}">

                                @csrf
                                <!-- fleet selection -->
                                <div>
                                    <x-label for="fleet" :value="__('Select Fleet: *')" />
                                    <select name="fleet_id" id="fleets-selection">
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

                                <div class="flex items-center justify-end mt-4">
                                    <x-button>
                                        {{ __('Add') }}
                                    </x-button>
                                </div>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
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
            templateResult: formatState
        });
    </script>
    @endpush
</x-app-layout>