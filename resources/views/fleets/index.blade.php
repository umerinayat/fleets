@extends('admin.layouts.master')

@section('page-title') 
    {{ __('Fleets') }} 
@endsection

@section('main-content')


<div class="card shadow mb-4">
            <div class="card-header py-3">
            
                <div class="d-sm-flex align-items-center justify-content-between">

                    <h3 class="m-0 font-weight-bold mb-0 text-gray-800"> {{ __('Fleets') }} <i id="spinner" class="fa ml-3 fa-spinner fa-spin" style="font-size:24px;position:absolute;top:23px;display:none"> </i> </h3>
                    <span class="btn btn-sm btn-outline-primary" onclick="window.history.back()">back</span>
                    <a id="addNewTypeBtn" href="javascript:void(0)" class=" d-sm-inline-block btn btn-sm btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-box"></i>
                        </span>
                        <span class="text"> Add New Fleet </span>
                    </a>
                </div>
            </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Fleet Number</th>
                        <th>Discription</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Fleet Number</th>
                        <th>Discription</th>
                        <th>Image</th>
                        <th>Actions</th>
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

                    <input type="hidden" name='fleet_id' id="fleetId"  />

                    <!-- fleet name -->
                    <div class="form-group">
                        <label for="fleet_number">Fleet Number: *</label>
                        <input type="number" class="form-control" name="fleet_number" id="fleet_number">
                    </div>
                    <!-- /fleet name -->

                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Discription:</label>
                        <textarea type="text" class="form-control" name="name" id="name"> </textarea>
                    </div>
                    <!-- /name -->

                    <!-- image -->
                        <div class="form-group">
                            <label for="image">Image:</label>

                            <input  type="file" id="fleetImage">
                            <input type="text" name="image" id="image" style="display:none">
                            <input type="text" name="imageName" id="imageName" style="display:none">

                            <div class="img p-4">
                                <img  id="imageView" src=""  alt="" style="display:none">
                            </div>
                        </div>
                    <!-- /image -->


                

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

         //init fleets DataTable
        var typesDataTable = $('#typesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('fleets.index') }}",
                },
                columnDefs: [
                    { "bSortable": false, "aTargets": [ 0, 1 ] },
                ],
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
                        name: 'action',
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
        });

        var mode = 'add';


        // Handle add new type 
        $('#addNewTypeBtn').click(function () {
            $('#errorsContainer').empty();
            $('#submitBtn').text("Add");
            $('#fleetId').val(0);
            $('#typeForm').trigger("reset");
            $('#modalHeading').html("Add Fleet");
            $('#imageView').css('display', 'none');
            $('#typeModal').modal('show');
            mode = 'add';
        });
        // END of handle add new type

        // Hanlde add or update type

        $('#submitBtn').click(function (e) {
            
            e.preventDefault();

            // disable submit button
            $('#submitBtn').prop('disabled', true);
            $spinner.css('display', 'inline-block');
            
            $(this).html('Processing..');

            if(mode == 'add') {
                var url = '/fleets';
                var method = 'post';
            } else {
                var url = '/fleets/' + $('#fleetId').val();
                var method = 'put';
            }

                axios({method, url, 
                    
                    data: $('#typeForm').serialize()  

                }).then(function (response) {

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

                    }).catch(function({response}) {

                        if(response.status == 422) {
                            var html = '<div class="alert alert-danger">';



                            for(const key in response.data.errors) {
                                html += '<p>' + response.data.errors[key][0] + '</p>';
                            }

                            html += '</div>';
                            $('#errorsContainer').html(html);

                            $('#submitBtn').html('Add Fleet');
                            // enable submit button
                            $('#submitBtn').prop('disabled', false);
                        }

                      // error  
                      $('#submitBtn').html('Add Fleet');
                      // enable submit button
                      $('#submitBtn').prop('disabled', false);
                      $spinner.css('display', 'none');

                    });
        });

        // END of Hanlde add or update type

        // Handle edit type

        $('body').on('click', '.edit-fleet-btn', function () {

             mode = 'update';
            
            var fleet_id = $(this).data('id');

            $spinner.css('display', 'inline-block');


            axios.get("/fleets/" + fleet_id + '/edit')
                .then( function ( response ) {

                    var data = response.data;
                    $spinner.css('display', 'none');

                    if (data.success) {

                        $('#modalHeading').html("Update Fleet");
                        $('#submitBtn').text("Update");
                       
                        // set form fields values for update
                        setBrandFromValues( data.fleet );
                        $('#errorsContainer').empty();
                        $('#typeModal').modal('show');
                    }

                }).catch( function( response ) {
                    // error
                    $spinner.css('display', 'none');

                });
        });

        // set type form values

        function setBrandFromValues( fleet ) {
            $('#fleetId').val(fleet.id);
            $('#fleet_number').val(fleet.fleet_number);
            $('#name').val(fleet.name);
        }

        // END of set type Form values

        // END of Handle type type


        $('body').on('click', '.delete-fleet-btn', function(e) {

            var fleet_id = $(this).data("id");

            // confirm trash or delete user action
            Swal.fire({
                title: 'Are you sure?',
                text: "The Fleet will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it.'
            }).then((result) => {
                if (result.value) {

                    $spinner.css('display', 'inline-block');

                    axios.delete("{{route('fleets.index')}}/" + fleet_id)
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

<script>

$brandImgTrigger = $('.brandImgTrigger');

$fleetImage = $('#fleetImage');

$fleetImage.on('change', function (e) {

 
    if (this.files && this.files[0]) {

        var reader = new FileReader();

        var imageFile = this.files[0];

        reader.onload = function (e) {

            console.log(imageFile);
            console.log(e.target.result);

            $('#imageView').attr('src', e.target.result);

            // base64 image
            $('#image').val(e.target.result);
            // image name
            // imageName 
            $('#imageName').val(imageFile.name);

            $brandImgTrigger.css('fontSize', '16px');
            $brandImgTrigger.text(' | change');
            $('#magicBox').append($brandImgTrigger);

            $('#imageView').css('display', 'block');
            
            
        }

        reader.readAsDataURL(this.files[0]);

    }

});

</script>

@endpush
