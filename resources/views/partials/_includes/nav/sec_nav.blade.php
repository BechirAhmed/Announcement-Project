<ul class="secNav">
    @foreach($categories as $category)
        {{--@if($category->products->count())--}}
                <li><a href="{{ route('category', ['catSlug' => $category->slug]) }}" class="link-noUnderline">{{ $category->name }}</a></li>
        {{--@endif--}}
    @endforeach
</ul>