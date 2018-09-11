@if(count($userProducts) == 0)
    <div class="panel-body text-center">
        <h4>No Products Available!</h4>
    </div>
@else

    <div class="container" style="margin-top: 30px">
        <div class="row">
            @php
                $nb = 1;
            @endphp
            @foreach($userProducts as $product)
    <div class="col-md-2 prodItem">
        @foreach($product->subCategories as $subCategory)
            @foreach($subCategory->categories as $category)
                <a href="{{ route('products.product.show', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}" class="link-noUnderline hvr-shadow" title="Show Product">
            @endforeach
        @endforeach
            @foreach($product->subCategories as $subCategory)
                @foreach($subCategory->categories as $category)
                    <span class="catName">{{ $category->name }}</span>
                @endforeach
            @endforeach
            @foreach($product->subCategories as $subCategory)
                <span class="subCatName">{{ $subCategory->name }}</span>
            @endforeach
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
        <span class="state {{ ($product->is_active) ? 'activate' : 'deactivate' }}">{{ ($product->is_active) ? 'Activated' : 'Deactivated' }}</span>
        <div class="form-btn">
            <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                {{--<div class="btn-group btn-group-xs pull-right" role="group">--}}
                <a data-toggle="modal" data-target="#exampleModal{{$product->id}}" class="button is-info is-small link-noUnderline" title="Show Product">

                    <span class="fa fa-eye" aria-hidden="true"></span>
                </a>
                <a href="{{ route('products.product.edit', $product->id ) }}" class="button is-primary is-small link-noUnderline" title="Edit Product">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>

                <button type="submit" class="button is-danger is-small link-noUnderline" title="Delete Product" onclick="return confirm(&quot;Delete Product?&quot;)">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
                {{--</div>--}}

            </form>
        </div>
    </div>
    @include('products.productModal')

@endforeach

        </div>
    </div>

    <div class="">
        {!! $userProducts->render() !!}
    </div>

@endif