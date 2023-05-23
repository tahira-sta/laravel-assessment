@extends('layouts.master')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h3 class="mb-0 font-size-18">Client {{$client->name}} Products</h4>
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
                                                        <th>Base Price</th>
                                                        <th>Price</th>
                                                        <th>Category</th>
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
        ajax: "{{ route('product-client.show',$client->id) }}",
        columns: [{
                data: 'product.product_name',
                name: 'product.product_name'
            },
            {
                data: 'product.base_price',
                name: 'product.base_price'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'product.category',
                name: 'product.category'
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
        $('.display').on('click', '.deleteProduct', function() {
            if (confirm("Are you sure?")) {
                var productId = $(this).attr('data-id');

                var url = '/product-client/' + productId;
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
                            table.ajax.url('/product-client.show/$client->id').load();
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