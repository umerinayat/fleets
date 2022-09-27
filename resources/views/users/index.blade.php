<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden pb-6">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8">
                        <div class="flex col-span-2 bg-white p-6 rounded-lg shadow-md">
                            <table id="usersDt" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="flex flex-col justify-self-end bg-white rounded-lg shadow-md" style="width: 350px">
                            <div class="bg-white border-b border-gray-200 p-2">
                                Add User
                            </div>

                            <form method="POST" action="{{ route('users.store') }}" class="p-6">
                                @csrf
                                
                                <!-- Name -->
                                <div>
                                    <x-label for="name" :value="__('Name: *')" />

                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
                                </div>

                                @if ($errors->has('name'))
                                    <div class="mt-2" style="color:red">{{ $errors->first('name') }}</div>
                                @endif

                                <!-- email -->
                                <div class="mt-4">
                                    <x-label for="email" :value="__('Email: *')" />

                                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  />
                                </div>

                                @if ($errors->has('email'))
                                    <div class="mt-2" style="color:red">{{ $errors->first('email') }}</div>
                                @endif

                                <!-- password -->
                                <div class="mt-4">
                                    <x-label for="password" :value="__('Password: *')" />

                                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" />
                                </div>

                                @if ($errors->has('password'))
                                <div class="mt-2" style="color:red">{{ $errors->first('password') }}</div>
                                @endif

                                <div class="mt-4">
                                    <x-label for="role" :value="__('Assign Role: *')" />

                                    <select name="role" id="role" class="block mt-1 w-full">
                                        <option value="staff" selected>Staff</option>
                                        <option value="admin">Admin</option>
                                    </select>
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
        $(function() {
            var table = $('#usersDt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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