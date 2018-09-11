@extends('layouts.app')

@section('content')
    @if(Auth::user()->id == $product->user_id || Auth::user()->hasRole('admin'))
        <div class="panel panel-default">

            <div class="panel-heading clearfix">

                <div class="pull-left">
                    <h4 class="mt-5 mb-5">{{ !empty($product->name) ? $product->name : 'Product' }}</h4>
                </div>
                <div class="btn-group btn-group-sm pull-right" role="group">

                    <a href="{{ route('products.product.index') }}" class="btn btn-primary" title="Show All Product">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('products.product.create') }}" class="btn btn-success" title="Create New Product">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="m-l-5 m-r-5">
                        <h2 class="page-heading">Add images to your product <span id="counter"></span></h2>
                        <form method="post" action="{{ url('/images-save', $product->id) }}"
                              enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                            {{ csrf_field() }}
                            <div class="dz-message @if(count($product->photos)) ? hidden : '' @endif">
                                <div class="col-xs-8">
                                    <div class="message" style="background-color: #ffffff">
                                        <p>Drop files here or Click to Upload</p>
                                    </div>
                                </div>
                            </div>
                            @if(count($product->photos))
                                @foreach($product->photos as $photo)
                                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                        <div class="dz-image">
                                            <img src="{{ asset('images/'.$photo->resized_name) }}" alt="">
                                        </div>
                                        <div class="dz-details">
                                            <div class="dz-filename">
                                                <span>{{$photo->original_name}}</span>
                                            </div>
                                        </div>
                                        <a class="remove-img" data-id="{{$photo->id}}" id="{{$photo->id}}">Remove file</a>
                                    </div>
                                @endforeach
                            @endif
                            <div class="fallback">
                                <input type="file" name="file" multiple>
                            </div>
                        </form>
                    </div>
                </div>

                {{--Dropzone Preview Template--}}
                <div id="preview" style="display: none;">

                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image"><img data-dz-thumbnail /></div>

                        <div class="dz-details">
                            <div class="dz-size"><span data-dz-size></span></div>
                            <div class="dz-filename"><span data-dz-name></span></div>
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>



                        <div class="dz-success-mark">

                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                <title>Check</title>
                                <desc>Created with Sketch.</desc>
                                <defs></defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                </g>
                            </svg>

                        </div>
                        <div class="dz-error-mark">

                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                <title>error</title>
                                <desc>Created with Sketch.</desc>
                                <defs></defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <hr class="m-t-20">
                <form method="POST" action="{{ route('products.product.update', $product->id) }}" id="edit_product_form" name="edit_product_form" accept-charset="UTF-8" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('products.form', [
                                                'product' => $product,
                                              ])

                    <div class="field">
                        <div class="columns has-background-info">
                            <div class="column is-one-fifth is-offset-four-fifths">
                                <input class="button is-primary is-fullwidth" type="submit" value="Update">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @else
        @include('errors.404')
    @endif
@endsection

@section('footer_scripts')
    <script>
//        $(document).ready(function () {
//            $('.remove-img').on('click', function (e) {
//                e.preventDefault();
//                $.ajaxSetup({
//                    headers: {
//                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                    }
//                });
//                var id = $(this).attr("id");
//                $.ajax({
//                    url: '/images-delete',
//                    data: {id: id, _token: $('[name="_token"]').val()},
//                    dataType: 'json',
//                    success: function (data) {
////                        total_photos_counter--;
////                        $("#counter").text("# " + total_photos_counter);
//                        console.log("Success "+data.id);
//                    },
//                    error: function (data) {
//                        console.log("Error "+data.id);
//                    }
//                });
//            });
//        });
    </script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/product-images-dz.js') }}"></script>
    {{--@include('scripts.product-images-dz')--}}

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                activeButton: "{!! old('is_active', $product)->is_active ? 1 : 0 !!}",
                preferredButton: "{!! old('preferred', $product)->preferred ? 1 : 0 !!}"
            }
        });
    </script>
@endsection