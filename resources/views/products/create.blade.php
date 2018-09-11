@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            
            <span class="pull-left">
                <h4 class="mt-5 mb-5">Create New Product</h4>
            </span>

            <div class="btn-group btn-group-sm pull-right" role="group">
                {{--<a href="{{ route('products.product.index') }}" class="btn btn-primary" title="Show All Product">--}}
                    {{--<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>--}}
                {{--</a>--}}
            </div>

        </div>

        <div class="panel-body">
        
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

{{--            <form method="POST" action="{{ route('products.product.store') }}" accept-charset="UTF-8" id="create_product_form" name="create_product_form" class="form-horizontal">--}}
            <form id="myForm">
                {{ csrf_field() }}
            @include ('products.form', [
                                        'product' => null,
                                      ])

                <div class="field">
                    <div class="columns has-background-info">
                        <div class="column is-one-fifth is-offset-four-fifths">
                            {{--<input class="btn btn-primary" type="submit" value="Add" id="postSave">--}}
                            <button class="button is-success is-fullwidth" id="postSave">Add</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('footer_scripts')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
    </script>
    <script>

        $(document).ready(function(){
//            $('#imagesUpload').hide();
            $('#postSave').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: "{{ url('store') }}",
                method: 'post',
                data: {
//                    slug: $('#slug').val(),
                    sub_category_id: $('#sub_category_id').val(),
                    region_id: $('#region_id').val(),
                    unit_related_id: $('#unit_related_id').val(),
                    name: $('#name').val(),
                    description: $('#description').val(),
                    price: $('#price').val(),
                    discount: $('#discount').val(),
                    count: $('#count').val(),
                    color: $('#color').val()
                },
                success: function(result){
                    var loc = window.location;
                    window.location = "http://localhost:8000/products/" + result.product_id + "/edit";
                },
                error: function (result) {

                }
            });
        });
    });

    </script>
@endsection


