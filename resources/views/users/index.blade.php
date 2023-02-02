@extends('admin.layouts.master')

@section('page-title')
{{ __('Users') }}
@endsection

@section('main-content')


<div class="card shadow mb-4">
    <div class="card-header py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold mb-0 text-gray-800"> {{ __('Users') }} <i id="spinner" class="fa ml-3 fa-spinner fa-spin" style="font-size:24px;position:absolute;top:23px;display:none"> </i> </h3>
            <span class="btn btn-sm btn-outline-primary" onclick="window.history.back()">back</span>
            <a id="addNewTypeBtn" href="javascript:void(0)" class="d-sm-inline-block btn btn-sm btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-box"></i>
                </span>
                <span class="text"> Add New User </span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    {{-- Dynamic --}}
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Generic form for add / update  -->
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form id="typeForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name='user_id' id="user_id" />

                    <!-- name-->
                    <div class="form-group">
                        <label for="name">Name: *</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <!-- /name -->

                    <!-- name-->
                    <div class="form-group">
                        <label for="email">Email: *</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <!-- /name -->

                    <!-- password -->
                    <div class="form-group">
                        <label for="password">Password: *</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <!-- password -->


                    <!-- role -->
                    <div class="form-group">
                        <label for="role">Assign Role: *</label>
                        <select name="role" id="role" class="form-control">
                            <option value="staff" selected>Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <!-- role -->

                    <div class="mt-2" id="errorsContainer"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" role="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Add</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- Generic form for add / update type -->

@endsection

@push('scripts')

<script>
    // document ready
    $(document).ready(function() {

        $spinner = $('#spinner');

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // init fleets DataTable
        var typesDataTable = $('#typesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('users.index') }}",
            },
            columnDefs: [],
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
                }
            ]
        });

        var mode = 'add';

        // Handle add new type 
        $('#addNewTypeBtn').click(function() {
            $('#errorsContainer').empty();
            $('#submitBtn').text("Add");
            $('#user_id').val(0);
            $('#typeForm').trigger("reset");
            $('#modalHeading').html("Add User");
            $('#typeModal').modal('show');
            mode = 'add';
        });
        // END of handle add new type

        // Hanlde add or update type

        $('#submitBtn').click(function(e) {

            e.preventDefault();

            // disable submit button
            $('#submitBtn').prop('disabled', true);
            $spinner.css('display', 'inline-block');

            $(this).html('Processing..');

            if (mode == 'add') {
                var url = '/users';
                var method = 'post';
            } else {
                var url = '/users/' + $('#user_id').val();
                var method = 'put';
            }

            axios({
                method,
                url,

                data: $('#typeForm').serialize()

            }).then(function(response) {

                var data = response.data;
                $spinner.css('display', 'none');

                if (data.success) {

                    $('#typeForm').trigger("reset");
                    $('#typeModal').modal('hide');
                    typesDataTable.draw();

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    // enable submit button
                    $('#submitBtn').prop('disabled', false);


                }

            }).catch(function({
                response
            }) {

                if (response.status == 422) {
                    var html = '<div class="alert alert-danger">';

                    for (const key in response.data.errors) {
                        html += '<p>' + response.data.errors[key][0] + '</p>';
                    }

                    html += '</div>';
                    $('#errorsContainer').html(html);

                    $('#submitBtn').html('Add User');
                    // enable submit button
                    $('#submitBtn').prop('disabled', false);
                }

                // error  
                $('#submitBtn').html('Add User');
                // enable submit button
                $('#submitBtn').prop('disabled', false);
                $spinner.css('display', 'none');

            });
        });

        // END of Hanlde add or update type

        // Handle edit type

        $('body').on('click', '.edit-user-btn', function() {

            mode = 'update';

            var ref_id = $(this).data('id');

            $spinner.css('display', 'inline-block');


            axios.get("/users/" + ref_id + '/edit')
                .then(function(response) {

                    var data = response.data;
                    $spinner.css('display', 'none');

                    if (data.success) {

                        $('#modalHeading').html("Update User");
                        $('#submitBtn').text("Update");

                        // set form fields values for update
                        setBrandFromValues(data.user);
                        $('#errorsContainer').empty();
                        $('#typeModal').modal('show');
                    }

                }).catch(function(response) {
                    // error
                    $spinner.css('display', 'none');
                });
        });

        // set type form values

        function setBrandFromValues(user) {
            $('#user_id').val(user.id);
            $('#name').val(user.name);
            $('#email').val(user.email);
            $('#role').val(user.roles[0].name);
        }

        // END of set type Form values

        // END of Handle type type


        $('body').on('click', '.delete-user-btn', function(e) {

            var user_id = $(this).data("id");

            // confirm trash or delete user action
            Swal.fire({
                title: 'Are you sure?',
                text: "The User will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it.'
            }).then((result) => {
                if (result.value) {

                    $spinner.css('display', 'inline-block');

                    axios.delete("{{route('users.index')}}/" + user_id)
                        .then(function(response) {

                            var data = response.data;

                            $spinner.css('display', 'none');

                            if (data.success) {
                                typesDataTable.draw();

                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                            }

                        }).catch(function(response) {
                            $spinner.css('display', 'none');
                        });
                }

            });

        });


    });
</script>

@endpush