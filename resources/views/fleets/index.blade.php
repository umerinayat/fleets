<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fleets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden pb-6">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8">
                        <div class="flex col-span-2 bg-white p-6 rounded-lg shadow-md">
                            <table id="fleetsDt" style="width: 100%">
                                <thead>
                                    <tr>
                         
                                        <th>Fleet Number</th>
                                        <th>Discription</th>
                                        <th>Image</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="flex flex-col justify-self-end bg-white rounded-lg shadow-md" style="width: 350px">
                            <div class="bg-white border-b border-gray-200 p-2">
                                Add Fleet
                            </div>

                            <form method="POST" action="{{ route('fleets.store') }}" class="p-6" enctype="multipart/form-data">
                                @csrf

                                <!-- Fleet Number -->
                                <div>
                                    <x-label for="fleet_number" :value="__('Fleet Number: *')" />

                                    <x-input id="fleet_number" class="block mt-1 w-full" min="0" oninput="validity.valid||(value='');" type="number" name="fleet_number" :value="old('fleet_number')" autofocus />
                                </div>

                                @if ($errors->has('fleet_number'))
                                <div class="mt-2" style="color:red">{{ $errors->first('fleet_number') }}</div>
                                @endif

                                <!-- Name -->
                                <div class="mt-4">
                                    <x-label for="name" :value="__('Discription: *')" />

                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                                </div>

                                @if ($errors->has('name'))
                                    <div class="mt-2" style="color:red">{{ $errors->first('name') }}</div>
                                @endif

                                <div class="mt-4">
                                    <x-label for="image" :value="__('Image: *')" />

                                    <x-input id="image" class="block mt-1 w-full" type="file" name="image" :value="old('image')" />
                                </div>

                                @if ($errors->has('image'))
                                <div class="mt-2" style="color:red">{{ $errors->first('image') }}</div>
                                @endif

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
        $(function() {
            var table = $('#fleetsDt')
            // .on( 'init.dt', function () {
            //     $('#fleetsDt .edit-icon').on('click', function(event) {
            //         const fleetId = $(this).data('id');
            //     });
            // })
            .DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('fleets.index') }}",
                columns: [
                    {
                        data: 'fleet_number',
                        name: 'fleet_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
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