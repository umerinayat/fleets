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
    
    @push('scripts')
    @endpush
</x-app-layout>