@extends('layouts.app')

@section('template_title', 'Products')

@section('template_linked_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="http://www.citizensfiber.com/assets/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css">
    <style>
        a{
            text-decoration: none;
        }
        a:hover, a:active, a:focus{
            text-decoration: none;
        }
        span.is-preferred {
            position: absolute;
            width: 0;
            height: 0;
            border-top: 40px solid transparent;
            border-bottom: 40px solid transparent;
            border-left: 40px solid #04b104;
            transform: rotate(-45deg);
            right: -7px;
            text-align: right;
            z-index: 9;
            top: -27px;
        }
        span.is-preferred span{
            position: absolute;
            left: -35px;
            top: -10px;
        }
        .checkStatus{
            width: 20%;
        }
        span.creatTime {
            position: absolute;
            padding: 4px;
            background: #04b104;
            top: 36.4px;
            right: -63px;
            color: #fff;
            transform: rotate(90deg);
            border-top-right-radius: 10px;
        }
        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="m-t-50">
        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Products</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('products.product.create') }}" class="btn btn-success" title="Create New Product">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>



        @role('admin', true)
        <div class="m-r-5 m-l-5 m-t-5">
            <table class="table table-bordered dt-responsive" id="products" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>User</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Created</th>
                    <th>Active</th>
                    <th>Sold</th>
                    <th>Preferred</th>
                    <th>Edit</th>
                    <th>Description</th>
                </tr>
                </thead>
            </table>
        </div>
        @endrole
        @role('user', true)
            @include('products.user-products');
        @endrole
    </div>

@endsection

@section('footer_scripts')

    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="http://www.citizensfiber.com/assets/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.js"></script>
    <script>
        $(document).ready(function() {
            $('#products').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('products.product.getProducts') }}',
                    data: function(d) {
                        d.name = $('input[name=name]').val();
                        d.product_name = $('input[name=product_name]').val();
                        d.is_active = $('input[name=is_active]').val();
                    }
                },
                columns: [
                    { data: 'product_id', name: 'product_id', orderable: true, searchable: false },
                    { data: 'name', name: 'name', orderable: true, searchable: true },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'p_price', name: 'p_price', orderable: true, searchable: false },
                    { data: 'p_created', name: 'p_created', orderable: true, searchable: false },
                    { data: 'is_active', name: 'is_active', orderable: true, searchable: false },
                    { data: 'sold', name: 'sold', orderable: true, searchable: false },
                    { data: 'preferred', name: 'preferred', orderable: true, searchable: false },
                    { data: 'edit', name: 'edit', orderable: true, searchable: false },
                    { data: 'description', name: 'description' },
                ],
                "order": [[1, 'asc']],
                initComplete: function () {
                    this.api().columns([5,6,7]).every( function () {
                        var column = this;
                        // Use column title as label for select
                        var title = $(column.header()).text();
                        // Generate Label
                        var label = $('<label style="margin-left: 10px;">'+title+' : </label>').appendTo("#products_wrapper #products_length");
                        var select = $('<select class="form-control"><option value=""></option></select>').appendTo(label)
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            var cSelect = select.append( '<option value="'+d+'">'+d+'</option>' );
                        } );
                    } );
                }
            });
            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#products tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );

            // On each draw, loop over the `detailRows` array and show any child rows
            dt.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            } );
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.checkbox .prod_active').each(function () {
                var self = $(this),
                    label = self.next(),
                    label_text = label.text();

                label.remove();
                self.iCheck({
                    checkboxClass : 'icheckbox_square-green',
                    insert:'<div class="icheck_square-icon"></div>'+label_text,
                    increaseArea: '20%'
                });
            });
            $('.prod_active').on('ifClicked', function (e) {
                id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('changeStatus') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id
                    },
                    success: function (data) {
                        //empty
                    },
                });
            });
        });
    </script>
@endsection