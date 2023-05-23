@extends('layouts.master')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!--Add Modal -->
            <div class="modal fade" id="addNewSpecialPrice" role="dialog" aria-labelledby="addNewSpecialPriceLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewSpecialPriceLabel">Add Special Price</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none" id="ajax-alert-danger">
                                <button type="button" class="close" data-dismiss="alert" onclick="$('.modal').removeClass('show');" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="productClientForm">
                                @csrf
                                <input type="hidden" id="txtClientId" name="client_id" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <select id="ddlProductName" name="product_id" class="form-control select2 required aFunction" style="width: 100%;">
                                                <option value="0">--Select Product--</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" id="txtPrice" name="price" min="0.00" class="form-control required" placeholder="Price" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal" onclick="$('.modal').removeClass('show');">
                            <i class="mdi mdi-close-thick font-size-16 align-middle"></i> Close
                            </button>

                            <button type="submit" class="btn btn-success waves-effect waves-light" id="btnClientPrice">
                                <i class="mdi mdi-check-underline font-size-16 align-middle"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Add Modal -->
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h3 class="mb-0 font-size-18">Clients</h4>
                    </div>
                </div>
            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none" id="ajax-alert">
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive mt-1">
                                            <table id="datatable-buttons" class="display table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="datatable-buttons_info">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/customJs/jquery.validate.js')}}"></script>
<script>
    var table = $('.display').DataTable({
        "stripeClasses": [   ],
        serverSide: true,
        processing: true,
        dom: 'Bfrtip',
        "order": [
            [1, "asc"]
        ],
        buttons: [{
            extend: 'print',
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
        }],
        ajax: "{{ route('client.index') }}",
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
        ],

    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $('#btnClientPrice').click(function () {
            $.ajax({
                url: '{{ route('set-price') }}',
                container: '#productClientForm',
                type: "POST",
                disableButton: true,
                blockUI: false,
                buttonSelector: $(this),
                data: $('#productClientForm').serialize(),
                file: true,
                success: function (response) {
                if(response.message == 'success'){
                        clearFields();
                        $(".modal,.modal-backdrop").removeClass("show");
                        $('.modal,.modal-backdrop').hide();
                        $('#ajax-alert').addClass('alert-sucess').show(function() {
                                $(this).html("<i class='mdi mdi-check-all mr-2'></i>Special prices have been set successfully.! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                        });
                        $("#ajax-alert").fadeTo(2000, 500).slideUp(500, function() {
                            $("#ajax-alert").slideUp(500);
                        });

                    }
                else if(response.message == 'Already exists'){
                        clearFields();
                        $('#addNewSpecialPrice').find('#ajax-alert-danger').addClass('alert-danger').show(function() {
                        $(this).html("<i class='mdi mdi-close-thick mr-2'></i> Product price already exists for the user. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                        });
                        
                        $("#ajax-alert-danger").fadeTo(2000, 500).slideUp(500, function() {
                            $("#ajax-alert-danger").slideUp(500);
                        });

                    }
                },
                error: function (response) {
                    $('#ajax-alert-danger').addClass('alert-danger').show(function() {
                        $(this).html("<i class='mdi mdi-close-thick mr-2'></i> " + error + "! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                    });
                    $("#ajax-alert-danger").fadeTo(2000, 500).slideUp(500, function() {
                        $("#ajax-alert-danger").slideUp(500);
                    });
                }
            })
        });

        $('#datatable-buttons_wrapper').on('click', '.addClientPrice', function() {
            var clientId = $(this).attr('data-id');
            $('#txtClientId').val(clientId);

            $('#addNewSpecialPrice').modal('show');
            $('.modal,.modal-backdrop').show();
            $(".modal,.modal-backdrop").addClass("show");

        });
        $('.display').on('click', '.deleteProduct', function() {
            if (confirm("Are you sure?")) {
                var productId = $(this).attr('data-id');

                var url = '/product/' + productId;
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'_method': 'DELETE'},
                    success: function(dataResult) {
                        if (dataResult.message == 'success') {
                            $('#ajax-alert').addClass('alert-sucess').show(function() {
                                $(this).html("<i class='mdi mdi-check-all mr-2'></i> Product has been deleted successfully.! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                            });
                            $("#ajax-alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#ajax-alert").slideUp(500);
                            });
                            table.ajax.url('/product').load();
                        }
                    },
                    error: function(dataResult) {
                        if (dataResult.message == 'error') {
                            var error = dataResult.responseJSON.errors.name[0];
                            $('#ajax-alert-danger').addClass('alert-danger').show(function() {
                                $(this).html("<i class='mdi mdi-close-thick mr-2'></i> " + error + "! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                            });
                            $("#ajax-alert-danger").fadeTo(2000, 500).slideUp(500, function() {
                                $("#ajax-alert-danger").slideUp(500);
                            });
                        }
                    }
                });
            }
            return false;
        });
    });

    function clearFields() {
        $('input[type=text]').val('');
        $('input[type=number]').val('');
        $('select').val('');
    }
</script>
@endsection