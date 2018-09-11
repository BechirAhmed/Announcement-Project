@extends('layouts.public')

@section('template_linked_css')
    <style>
        @media (min-width:1200px){
            .ResSlid0 .item {
                width: 18%!important;
            }
        }

        .resCarousel-inner .item {
            /*border: 4px solid #eee;*/
            /*vertical-align: top;*/
            text-align: center;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }

        .resCarousel-inner .item .tile a,
        .banner .item {
            display: inline-grid;
            width: 100%;
            min-height: 150px;
            height: 150px;
            text-align: center;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }

        .resCarousel-inner .item h1 {
            vertical-align: middle;
            color: #000;
        }

        .banner .item div {
            /*background: url('images/fdaf282558d1827bccf942e74d60fe658d97fc9f.png') center top no-repeat;*/
            /*background-size: cover;*/
            min-height: 550px;
        }

        /*.item .tile div {*/
            /*!*background: url('images/fdaf282558d1827bccf942e74d60fe658d97fc9f.png') center center no-repeat;*!*/
            /*!*background-size: cover;*!*/
            /*height: 200px;*/
            /*color: white;*/
        /*}*/
        .item div .prodImg {
            height: 50px;
            max-width: 100%;
            margin: auto;
        }
    </style>
@endsection

@section('content')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                    $nb = 0;
                    $i = 0;
                ?>
                @foreach($preferrefProducts as $product)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $nb }}" class="@if($nb == 0) active @endif"></li>
                    <?php
                        $nb++;
                    ?>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">

                @foreach($preferrefProducts as $product)
                    <div class="carousel-item @if($i == 0) active @endif" style="background-image: url(@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif)">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $product->name }}</h3>
                            @if($product->discount)
                                <span class="discountPrice">
                                                {{ $product->price }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                            </span>
                                <span class="discount">
                                                {{ $product->discount }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                            </span>
                            @else
                                <span class="price">
                                                {{ $product->price }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                            </span>
                            @endif
                            @php
                                Carbon\Carbon::setLocale('en');
                                $now=Carbon\Carbon::now();
                                $created_date = Carbon\Carbon::parse($product->created_at);
                                $created = $created_date->diffForHumans($now);

                            @endphp
                            {{--<div>--}}
                                {{--<img src="{{$product->user->profile->avatar}}" alt="{{$product->user->full_name}}" class="storeAvatar" width="30" height="30">--}}
                                {{--<span style="margin: auto">--}}
                                        {{--<span>--}}
                                            {{--{{$product->user->full_name}}--}}
                                        {{--</span>--}}
                                        {{--<span>--}}
                                            {{--{{$created}}--}}
                                        {{--</span>--}}
                                    {{--</span>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <?php
                        $i++;
                    ?>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    @include('partials._includes.sliders.newProductSlid')

    @include('partials._includes.sliders.mostPopularSlid')

@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function(){
            $('#region').change(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/') }}",
                    method: 'post',
                    data: {
                        region_id: $('#region_id').val(),
                        },
                    success: function(result){
                        console.log(result.region_id);
                    },
                    error: function (result) {

                    }
                });
            });
        });
    </script>
@endsection