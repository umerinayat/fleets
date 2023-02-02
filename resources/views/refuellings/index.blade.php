@extends('admin.layouts.master')

@section('page-title') 
    {{ __('Fleets Refuellings') }} 
@endsection

@section('main-content')


<div class="card shadow mb-4">
            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold mb-0 text-gray-800"> {{ __('Fleets Refuellings') }} <i id="spinner" class="fa ml-3 fa-spinner fa-spin" style="font-size:24px;position:absolute;top:23px;display:none"> </i> </h3>
                    <span class="btn btn-sm btn-outline-primary" onclick="window.history.back()">back</span>
                    <a id="addNewTypeBtn" href="javascript:void(0)" class="d-sm-inline-block btn btn-sm btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-box"></i>
                        </span>
                        <span class="text"> Add New Refuelling </span>
                    </a>
                </div>
            </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Fleet Number</th>
                        <th>Fleet Description</th>
                        <th>Fuel Added</th>
                        <th>Machine Hours</th>
                        <th>Is Tank Filled?</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Fleet Number</th>
                        <th>Fleet Description</th>
                        <th>Fuel Added</th>
                        <th>Machine Hours</th>
                        <th>Is Tank Filled?</th>
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

                    <input type="hidden" name='ref_id' id="refId"  />

                    <!-- fleet  -->
                    <div class="form-group">
                        <label for="fleet_number">Select Fleet: *</label>
                        <div>
                        <select name="fleet_id"  class="fleets-selection" id="fleets-selection">
                            <option></option>
                            @foreach($fleets as $fleet)
                            <option value="{{ $fleet->id }}">
                                <div class="name">{{$fleet->fleet_number}}-{{$fleet->name}}</div>
                            </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <!-- /fleet -->

                    <!-- fuel_added -->
                    <div class="form-group">
                        <label for="fuel_added">Fuel added: (in Liters) *</label>
                        <input type="number" step="0.01" class="form-control" name="fuel_added" id="fuel_added">
                    </div>
                    <!-- /fuel_added -->

                    <!-- machine hours -->
                    <div class="form-group">
                        <label for="machine_hours">Machine Hours: *</label>
                        <input type="number" step="0.01" class="form-control" name="machine_hours" id="machine_hours">
                    </div>
                     <!-- machine hours -->

                    <!-- location -->
                    <div class="form-group">
                        <label for="location">Location: *</label>
                        <input type="text" class="form-control" name="location" id="location">
                    </div>
                    <!-- location -->

                    
                    <!-- date -->
                    <div class="form-group">
                        <label for="date">Date: *</label>
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                    <!-- date -->

                    <!-- isTankFilled -->
                    <div class="form-group">
                        <label for="isTankFilled">Is Tank Filled:</label>
                        <input type="checkbox" class="form-check-input ml-2" name="isTankFilled" id="isTankFilled">
                    </div>
                    <!-- isTankFilled -->


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
                    url: "{{ route('refuelling.index') }}",
                },
                columnDefs: [
                    
                ],
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
                    }
                ]
        });

        var mode = 'add';


        // Handle add new type 
        $('#addNewTypeBtn').click(function () {
            $('#errorsContainer').empty();
            $('#submitBtn').text("Add");
            $('#refId').val(0);
            $('#typeForm').trigger("reset");
            $('#modalHeading').html("Add Refuelling");
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
                var url = '/refuelling';
                var method = 'post';
            } else {
                var url = '/refuelling/' + $('#refId').val();
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

                            $('#submitBtn').html('Add refuelling');
                            // enable submit button
                            $('#submitBtn').prop('disabled', false);
                        }

                      // error  
                      $('#submitBtn').html('Add refuelling');
                      // enable submit button
                      $('#submitBtn').prop('disabled', false);
                      $spinner.css('display', 'none');

                    });
        });

        // END of Hanlde add or update type

        // Handle edit type

        $('body').on('click', '.edit-ref-btn', function () {

            mode = 'update';
            
            var ref_id = $(this).data('id');

            $spinner.css('display', 'inline-block');


            axios.get("/refuelling/" + ref_id + '/edit')
                .then( function ( response ) {

                    var data = response.data;
                    $spinner.css('display', 'none');

                    if (data.success) {

                        $('#modalHeading').html("Update refuelling");
                        $('#submitBtn').text("Update");
                       
                        // set form fields values for update
                        setBrandFromValues( data.refuelling );
                        $('#errorsContainer').empty();
                        $('#typeModal').modal('show');
                    }

                }).catch( function( response ) {
                    // error
                    $spinner.css('display', 'none');
                });
        });

        // set type form values

        function setBrandFromValues( ref ) {
            $('#refId').val(ref.id);
            $('#fleets-selection').val(ref.fleet_id);
            $('#fuel_added').val(ref.fuel_added);

            $('#machine_hours').val(ref.machine_hours);
            $('#location').val(ref.location);
            $('#date').val(ref.date);

            $('#isTankFilled').prop('checked', ref.isTankFilled == 0 ? false : true);
        }

        // END of set type Form values

        // END of Handle type type


        $('body').on('click', '.delete-ref-btn', function(e) {

            var refulling_id = $(this).data("id");

            // confirm trash or delete user action
            Swal.fire({
                title: 'Are you sure?',
                text: "The Refuelling will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it.'
            }).then((result) => {
                if (result.value) {

                    $spinner.css('display', 'inline-block');

                    axios.delete("{{route('refuelling.index')}}/" + refulling_id)
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