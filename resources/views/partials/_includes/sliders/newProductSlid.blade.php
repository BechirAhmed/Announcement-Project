

<div class="container p8">

    <h3 class="title is-3">NEWEST PRODUCTS</h3>

    <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
        <div class="resCarousel-inner">

            @foreach($products as $product)
                    <div class="item">
                        <div class="tile">
                            @foreach($product->subCategories as $subCategory)
                                @foreach($subCategory->categories as $category)
                                    <a href="{{ route('product', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}" class="link-noUnderline hvr-shadow">
                                @endforeach
                            @endforeach

{{--                                @if(count($product->photos))--}}
                                    <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif" class="prodImg">
                                {{--@else--}}
{{--                                    <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">--}}
                                {{--@endif--}}
                                <h1>{{ $product->name }}</h1>
                                @if($product->discount)
                                    <span>
                                        <span class="discountPrice is-bold">
                                                {{ $product->price }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                        </span>
                                        <span class="discount is-bold" style="color: #000">
                                                    {{ $product->discount }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                        </span>
                                    </span>
                                @else
                                    <span class="price is-bold">
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
                                    <span>
                                        {{$created}}
                                    </span>
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
                            </a>
                        </div>
                </div>
            @endforeach

        </div>
        <button class="btn leftRs">
            <i class="fa fa-caret-left"></i>
        </button>
        <button class="btn rightRs">
            <i class="fa fa-caret-right"></i>
        </button>
    </div>
</div>

