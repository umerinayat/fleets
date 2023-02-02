@extends('admin.layouts.master')

@section('page-title')
{{ __('Dashboard') }}
@endsection

@push('styles')
<style>
    .filter {
        display: flex;
        margin-bottom: 12px;
        align-items: center;
        margin-top: 16px;
        padding: 8px;
    }

    .filter .date {
        display: flex;
        margin-right: 32px;
        align-items: center;
    }

    .date .label {
        margin-right: 12px;
    }

    .fleets-selection {
        width: 280px;
    }

    @media screen and (max-width: 1020px) {
        .filter {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter .date {
            margin-bottom: 6px;
            display: flex;
            flex-direction: column;
            
        }

        .date input {
            margin-left: 0px !important;
            margin-top: 4px !important;
        }


        #filterBtn {
            margin-top: 6px;
            margin-left: 2px;
        }
    }
</style>
@endpush

@section('main-content')


<div class="card shadow mb-4">
    <div class="card-header py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold mb-0 text-gray-800"> {{ __('Fleets Refulling Readings') }} <i id="spinner" class="fa ml-3 fa-spinner fa-spin" style="font-size:24px;position:absolute;top:23px;display:none"> </i> </h3>

            <a id="addNewTypeBtn" href="javascript:void(0)" class="d-sm-inline-block btn btn-sm btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-box"></i>
                </span>
                <span class="text"> Add New Refuelling </span>
            </a>
        </div>
    </div>

    <div class="filter">
        <div class="date">
            <div class="label">Select Date:</div>
            <input type="date" id="startDate">
            <input type="date" id="endDate" style="margin-left: 8px;">
        </div>
        <div>
            <select name="sfleet" class="fleets-selection" id="sfleet">
                <option></option>
                @foreach($fleets as $fleet)
                <option value="{{ $fleet->id }}">
                    <div class="name">{{$fleet->fleet_number}}-{{$fleet->name}}</div>
                </option>
                @endforeach
            </select>
        </div>
        <button class="btn ml-3" id="filterBtn">Reset</button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fleet Number</th>
                        <th>Litter Per hr. Avg</th>
                        <th>Total Year Consumed</th>
                        <th>Operating Hours</th>
                        <th>Current Machine Hr.</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fleet Number</th>
                        <th>Litter Per hr. Avg</th>
                        <th>Total Year Consumed</th>
                        <th>Operating Hours</th>
                        <th>Current Machine Hr.</th>
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

                    <input type="hidden" name='ref_id' id="refId" />

                    <!-- fleet  -->
                    <div class="form-group">
                        <label for="fleet_number">Select Fleet: *</label>
                        <div>
                            <select name="fleet_id" class="fleets-selection" id="fleets-selection">
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


        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        const sfleet = document.getElementById('sfleet');
        const filterBtn = document.getElementById('filterBtn');
        let isFilter = false;

        startDate.value = moment().startOf('quarter').format('YYYY-MM-DD');
        endDate.value = moment().startOf('quarter').add(364, 'days').format('YYYY-MM-DD');

        filterBtn.addEventListener('click', function(event) {
            $("#sfleet").val('');
            $("#sfleet").trigger('change.select2');
            startDate.value = moment().startOf('quarter').format('YYYY-MM-DD');
            endDate.value = moment().startOf('quarter').add(364, 'days').format('YYYY-MM-DD');
            $('#typesTable').DataTable().ajax.reload();
        });

        startDate.addEventListener('change', function() {
            $('#typesTable').DataTable().ajax.reload();
        });

        endDate.addEventListener('change', function() {
            $('#typesTable').DataTable().ajax.reload();
        });



        $('#sfleet').on('select2:select', function(e) {
            $('#typesTable').DataTable().ajax.reload();
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
                url: "{{ route('dashboard') }}",
                "data": function(d) {
                    d.sdate = startDate.value;
                    d.edate = endDate.value;
                    d.sfleet = sfleet.value
                },
            },
            columnDefs: [

            ],
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

        var mode = 'add';


        // Handle add new type 
        $('#addNewTypeBtn').click(function() {
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

        $('#submitBtn').click(function(e) {

            e.preventDefault();

            // disable submit button
            $('#submitBtn').prop('disabled', true);
            $spinner.css('display', 'inline-block');

            $(this).html('Processing..');

            if (mode == 'add') {
                var url = '/refuelling';
                var method = 'post';
            } else {}

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




    });
</script>

@endpush