<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fleets Refuellings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden pb-6">
                <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
                    <table id="refuellingsDt" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Fleet Number</th>
                                <th>Fleet Description</th>
                                <th>Fuel Added</th>
                                <th>Machine Hours</th>
                                <th>Is Tank Filled?</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            var table = $('#refuellingsDt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('refuelling.index') }}",
                columns: [
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'fleet_number',
                        name: 'fleet_number'
                    },
                    {
                        data: 'fleet_name',
                        name: 'fleet_name'
                    },
                    {
                        data: 'fuel_added',
                        name: 'fuel_added'
                    },
                    {
                        data: 'machine_hours',
                        name: 'machine_hours'
                    },
                   
                    
                    {
                        data: 'isTankFilled',
                        name: 'isTankFilled'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>