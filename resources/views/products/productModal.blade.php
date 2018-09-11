
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close link-noUnderline" data-dismiss="modal" aria-hidden="true" id="modalClose">
                    {{--<i class="fa fa-close"></i>--}}
                    <svg class="close-svg" viewPort="0 0 12 12" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <line x1="1" y1="11"
                              x2="11" y2="1"
                              stroke="white"
                              stroke-width="2"/>
                        <line x1="1" y1="1"
                              x2="11" y2="11"
                              stroke="white"
                              stroke-width="2"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6" style="border-right: 1px solid #ccc;">
                        <div class="image-gallery">
                            <main class="primary" style="background-image: url('@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif');"></main>
                            <aside class="thumbnails">
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
                    <div class="col-md-6 text-left">
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
                            <span style="background: #0f4bac; margin-left: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span style="background: #c70202;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span style="background: #ffeb00;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                        <div class="prodPrice" style="margin-top: 20px">
                            <h4 class="title is-4">
                                Price
                            </h4>
                            <h5 class="title is-5" style="margin-left: 20px;">{{ $product->price }} {{optional($product->unitRelated)->name}}</h5>
                        </div>
                        <h4 class="contctInfo title is-4">
                            Contact info
                        </h4>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Store</th>
                                <td>{{ optional($product->user)->name }}</td>
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
                                <th>Adress</th>
                                <td>{{ optional($product->user)->adresse }}</td>
                            </tr>
                            <tr>
                                <th>Region</th>
                                <td>{{ optional($product->region)->name }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
