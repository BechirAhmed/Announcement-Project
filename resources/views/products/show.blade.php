@extends('layouts.app')

@section('template_linked_css')
    <style>
        .bigImage{
            width: 100%;
            height: 400px;
        }
        .smallImage{
            width: 200px;
            height: 100px;
        }
        .secRow{
            margin: 0;
        }
        .topMargin20{
            margin-top: 20px;
        }
        span.button {
            width: 25px;
            height: 25px;
            border-radius: 25px;
        }
        .is_active_tag{
            margin-left: 5px;
            margin-right: -5px;
        }
        .is_active_tag:before{
            background: #7b7a7a70;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: inline;
        }
        .tags{
            display: inline-flex;
        }
    </style>
@endsection

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="columns">
            <div class="column">
                <span class="pull-left">
                    <h4 class="mt-5 mb-5">{{ isset($product->name) ? $product->name : 'Product' }}</h4>
                </span>
            </div>
            <div class="column">
                @if($product->is_active)
                    <span class="tag is-info is-medium">
                      Active
                      <i class="mdi mdi-check is_active_tag is-small has-color-white"></i>
                    </span>
                @else
                    <span class="tag is-danger is-medium">
                        Not Active
                        <i class="mdi mdi-close is_active_tag is-small has-color-white"></i>
                    </span>
                @endif

                @if($product->preferred)
                    <span class="tag is-success is-medium">
                        Preferred &nbsp;&nbsp; <i class="mdi mdi-star mdi-24px is_active_tag has-color-gold"></i>
                    </span>
                @endif
                    {{--<a class="tag is-success is-medium link-noUnderline active" data-id="{{$product->id}}">--}}
                        {{--@if($product->sold)--}}
                            {{--YES--}}
                        {{--@else--}}
                            {{--NO--}}
                        {{--@endif--}}
                    {{--</a>--}}
                    <div class="tags has-addons active-status">
                        <span class="tag is-primary is-medium">Sold</span>
                        @if($product->sold)
                            <a class="tag is-success is-medium link-noUnderline active" data-id="{{$product->id}}">YES</a>
                        @else
                            <a class="tag is-danger is-medium link-noUnderline active" data-id="{{$product->id}}">NO</a>
                        @endif
                    </div>
            </div>
            <div class="column">
                <div class="pull-right">
                    <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}" accept-charset="UTF-8">
                        <input name="_method" value="DELETE" type="hidden">
                        {{ csrf_field() }}
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('products.product.index') }}" class="button is-primary is-small" title="Show All Product">
                                <span class="mdi mdi-format-list-bulleted-type mdi-24px" aria-hidden="true"></span>
                            </a>

                            <a href="{{ route('products.product.create') }}" class="button is-success is-small" title="Create New Product">
                                <span class="mdi mdi-shape-polygon-plus mdi-24px" aria-hidden="true"></span>
                            </a>

                            <a href="{{ route('products.product.edit', $product->id ) }}" class="button is-info is-small" title="Edit Product">
                                <span class="mdi mdi-circle-edit-outline mdi-24px" aria-hidden="true"></span>
                            </a>

                            <button type="submit" class="button is-danger is-small" title="Delete Product" onclick="return confirm(&quot;Delete Product??&quot;)">
                                <span class="mdi mdi-delete-sweep mdi-24px" style="margin-top: -10px" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <div class="container">
        <div class="columns m-t-20">
            <div class="column" style="border-right: 1px solid #ccc;">
                <div class="image-gallery">
                    <main class="primary" style="background-image: url('@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif');"></main>
                    <aside class="thumbnails" style="width: 550px; @if($product->photos->count() > 5) overflow-x: scroll; @endif">
                        @php
                            $nb = 0;
                        @endphp
                        @foreach($product->photos as $photo)
                            <a class="{{ $nb == 0 ? 'selected ' : '' }}thumbnail" data-big="{{asset('images/'.$photo->image_name) }}">
                                <div class="thumbnail-image" style="background-image: url({{asset('images/'.$photo->resized_name) }})"></div>
                            </a>
                            @php
                                $nb++;
                            @endphp
                        @endforeach
                    </aside>
                </div>
            </div>
            <div class="column text-left">
                <h3 class="title is-3 text-left">
                    {{ $product->name }}
                </h3>
                <p class="prodDesc">
                    {{ $product->description }}
                </p>
                <div class="colors" style="margin: 20px 0">
                    <h4 class="title is-4">
                        Colors
                    </h4>
                    <span class="button is-primary"></span>
                    <span class="button is-info"></span>
                    <span class="button is-success"></span>
                    <span class="button is-danger"></span>
                    <span class="button is-warning"></span>
                    <span class="button has-background-green"></span>
                    <span class="button has-background-gold"></span>
                </div>
                <div class="prodPrice" style="margin-top: 20px">
                    @if($product->discount)
                        <table class="table">
                            <thead>
                                <th>Real Price</th>
                                <th>Discount Price</th>
                            </thead>
                            <tbody>
                                <td>
                                    <span class="discountPrice">
                                        {{ $product->price }}
                                        @foreach($product->unitRelateds as $unitRelated)
                                            {{ $unitRelated->name }}
                                        @endforeach
                                    </span>
                                </td>
                                <td>
                                    <span class="discount" style="color: #000">
                                        {{ $product->discount }}
                                        @foreach($product->unitRelateds as $unitRelated)
                                            {{ $unitRelated->name }}
                                        @endforeach
                                    </span>
                                </td>
                            </tbody>
                        </table>
                    @else
                        <h4 class="title is-4">
                            Price
                        </h4>
                        <span class="price">
                            {{ $product->price }}
                            @foreach($product->unitRelateds as $unitRelated)
                                {{ $unitRelated->name }}
                            @endforeach
                        </span>
                    @endif
                </div>
                <h4 class="contctInfo title is-4">
                    Contact info
                </h4>
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Store</th>
                        <td>{{ optional($product->user)->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Tel</th>
                        <td>{{ optional($product->user)->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ optional($product->user)->email }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ optional($product->user)->adresse }}</td>
                    </tr>
                    <tr>
                        <th>Region</th>
                        <td>
                            @foreach($product->regions as $region)
                                {{$region->name}}
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function () {
            $('.active').on('click', function (e) {
                id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('soldStatus') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id
                    },
                    success: function (data) {
                        if(data.sold === true){
                            $('.active').removeClass("is-danger").addClass("is-success").html("YES");
                        }else {
                            $('.active').removeClass("is-success").addClass("is-danger").html("NO");
                        }
                    },
                });
            });
            $('.thumbnail').on('click', function() {
                var clicked = $(this);
                var newSelection = clicked.data('big');
                var $img = $('.primary').css("background-image","url(" + newSelection + ")");
                clicked.parent().find('.thumbnail').removeClass('selected');
                clicked.addClass('selected');
                $('.primary').empty().append($img.hide().fadeIn('slow'));
            });
        });
    </script>
@endsection