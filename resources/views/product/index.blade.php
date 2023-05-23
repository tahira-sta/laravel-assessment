@extends('layouts.master')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!--Add Modal -->
            <div class="modal fade" id="addNewRecord" role="dialog" aria-labelledby="addNewRecordLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewRecordLabel">Add New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none" id="ajax-alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="productForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h5 class="font-size-14">Name <span class="text-danger">*</span></h5>
                                            <input type="text" id="txtProductName" name="product_name" class="form-control required" placeholder="Product Name" />
                                    
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" id="txtBasePrice" name="base_price" min="0.00" class="form-control required" placeholder="Price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select id="ddlCategory" name="category" class="form-control select2 aFunction" style="width: 100%;">
                                                <option value="0">--Select Category--</option>
                                                <option value="Food">Food</option>
                                                <option value="Shoes">Shoes</option>
                                                <option value="Home">Home</option>
                                                <option value="Kitchen">Kitchen</option>
                                                <option value="Health">Health</option>
                                                <option value="Jewelry">Jewelry</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><i class="mdi mdi-close-thick font-size-16 align-middle"></i> Close</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light" id="btnProductSubmit">
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
                        <h3 class="mb-0 font-size-18">Products</h4>

                            <div class="page-title-right">
                                <button class="my-0 float" data-target="#addNewRecord" data-toggle="modal" type="button"><i class="fa fa-plus my-float"></i></button>
                            </div>

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
                                                        <th>Price</th>
                                                        <th>Description</th>
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
        ajax: "{{ route('product.index') }}",
        columns: [{
                data: 'product_name',
                name: 'ucwords(product_name)'
            },
            {
                data: 'base_price',
                name: 'base_price'
            },
            {
                data: 'category',
                name: 'category'
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
        $('#btnProductSubmit').click(function () {
            console.log("ds");
            $.ajax({
                url: '{{ route('product.store') }}',
                container: '#productForm',
                type: "POST",
                disableButton: true,
                blockUI: false,
                buttonSelector: $(this),
                data: $('#productForm').serialize(),
                file: true,
                success: function (response) {
                if(response.message == 'success'){
                        table.ajax.url('/product').load();
                        clearFields();
                        $('#addNewRecord').modal('toggle');  $('#ajax-alert').addClass('alert-sucess').show(function() {
                            $(this).html("<i class='mdi mdi-check-all mr-2'></i> Product has been added successfully.! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>");
                        });
                        $("#ajax-alert").fadeTo(2000, 500).slideUp(500, function() {
                            $("#ajax-alert").slideUp(500);
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