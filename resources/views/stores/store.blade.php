@extends('layouts.public')

@section('content')
    <div class="prof-header" style="background: url({{ $user->profile->cover }}) no-repeat; background-size: cover">
        <div class="avatar">
            <img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="prof-img">
            <a id="editAvatar" class="button link-noUnderline is-hidden">Edit</a>
        </div>
    </div>
    <div class="container">
        <div class="prof-info" style="margin: 0.5% 0 6% 6%;">
            <div class="pull-left">
                <h3 class="store-name">
                    {{ $user->full_name }}
                </h3>
                {{--<p>Created : {{ $created }}</p>--}}
            </div>
        </div>
    </div>
    <div class="flex-container">

            @if(count($user->products) == 0)
                <div class="text-center">
                    <h4>{{ $user->full_name }} Does Not have any Products for Now!</h4>
                </div>
            @else

                <div class="container" style="margin-top: 30px">
                    <div class="row">
                        @php
                            $nb = 1;
                        @endphp
                        @foreach($user->products->where('is_active', true) as $product)
                            <div class="col-md-2 prodItem">
                                {{--@if($product->preferred)--}}
                                    {{--<span class="is-preferred">--}}
                                                    {{--<b-icon--}}
                                                            {{--icon="star"--}}
                                                            {{--type="is-warning">--}}

                                                    {{--</b-icon>--}}
                                                {{--</span>--}}
                                {{--@endif--}}
                                @foreach($product->subCategories as $subCategory)
                                    @foreach($subCategory->categories as $category)
                                        <a href="{{ route('product', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}" class="link-noUnderline">
                                    @endforeach
                                @endforeach
                                    {{--@foreach($product->subCategories as $subCategory)--}}
                                        {{--@foreach($subCategory->categories as $category)--}}
                                            {{--<span class="catName">{{ $category->name }}</span>--}}
                                        {{--@endforeach--}}
                                    {{--@endforeach--}}
                                    {{--@foreach($product->subCategories as $subCategory)--}}
                                        {{--<span class="subCatName">{{ $subCategory->name }}</span>--}}
                                    {{--@endforeach--}}
                                    {{--                                @foreach($photos as $photo)--}}
                                    <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif" alt="" class="prodImage">
                                    {{--@endforeach--}}
                                    <h4 class="prodName">{{ $product->name }}</h4>
                                    <div class="price">
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
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="">
                    {{--                {!! $allProducts->render() !!}--}}
                </div>

            @endif
    </div>
@endsection