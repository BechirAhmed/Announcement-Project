
{{--<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">--}}
    {{--<label for="slug" class="col-md-2 control-label">Slug</label>--}}
    {{--<div class="col-md-10">--}}
        {{--<input class="form-control" name="slug" type="text" id="slug" value="{{ old('slug', optional($product)->slug) }}" minlength="1" placeholder="Enter slug here...">--}}
        {{--{!! $errors->first('slug', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="field">
    <div class="columns">
        <div class="column has-background-info is-one-fifth">
            {{--<label class="label">Add</label>--}}
        </div>
        <div class="column has-background-info">
            <label for="sub_category_id" class="label has-text-white">Sub Category</label>
        </div>
        <div class="column has-background-info">
            <label for="region_id" class="label has-text-white">Region</label>
        </div>
        <div class="column has-background-info">
            <label for="unit_related_id" class="label has-text-white">Unit Related</label>
        </div>
        <div class="column has-background-info">
            <label for="price" class="label has-text-white">Price</label>
        </div>
        <div class="column has-background-info">
            <label for="discount" class="label has-text-white">Discount</label>
        </div>
    </div>
    <div class="columns">
        <div class="column has-background-info is-one-fifth">
            {{--<label class="label">New Product</label>--}}
        </div>
        <div class="column has-background-success">
            <select class="form-control" id="sub_category_id" name="sub_category_id">
                <option value="" style="display: none;" {{ old('sub_category_id', optional($product)->sub_category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select sub category</option>
                @foreach ($subCategories as $key => $subCategory)
                    <option value="{{ $key }}" {{ (is_array(old('subCategories')) && in_array($key, old('subCategories')))
                     || (in_array($key, $checkedSubCategories) && !is_array(old('subCategories'))) ? "selected" : "" }}>
                        {{ $subCategory }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('sub_category_id', '<p class="help is-danger">:message</p>') !!}
        </div>
        <div class="column has-background-primary">
            <select class="form-control" id="region_id" name="region_id">
                <option value="" style="display: none;" {{ old('region_id', optional($product)->region_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select region</option>
                <option value="all" {{ old('region_id', optional($product)->region_id ?: '') == '' ? 'selected' : '' }} >All</option>
                @foreach ($regions as $key => $region)
                    <option value="{{ $key }}" {{ (is_array(old('regions')) && in_array($key, old('regions')))
                     || (in_array($key, $checkedRegions) && !is_array(old('regions'))) ? "selected" : "" }}>
                        {{ $region }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('region_id', '<p class="help is-danger">:message</p>') !!}
        </div>
        <div class="column has-background-danger">
            <select class="form-control" id="unit_related_id" name="unit_related_id">
                <option value="" style="display: none;" {{ old('unit_related_id', optional($product)->unit_related_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select unit related</option>
                @foreach ($unitRelateds as $key => $unitRelated)
                    <option value="{{ $key }}" {{ (is_array(old('unitRelateds')) && in_array($key, old('unitRelateds')))
                     || (in_array($key, $checkedUnits) && !is_array(old('unitRelateds'))) ? "selected" : "" }}>
                        {{ $unitRelated }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('unit_related_id', '<p class="help is-danger">:message</p>') !!}
        </div>
        <div class="column has-background-warning">
            <input class="form-control" name="price" type="text" id="price" value="{{ old('price', optional($product)->price) }}" minlength="1" placeholder="Enter price here...">
            {!! $errors->first('price', '<p class="help is-danger">:message</p>') !!}
        </div>
        <div class="column has-background-gold">
            <input class="form-control" name="discount" type="text" id="discount" value="{{ old('discount', optional($product)->discount) }}" minlength="1" placeholder="Enter discount here...">
            {!! $errors->first('discount', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>


<div class="field">
    <div class="columns">
        <div class="column has-background-info is-one-fifth">
            <label for="name" class="label has-text-white">Name</label>
        </div>
        <div class="column">
            <input class="input" name="name" type="text" id="name" value="{{ old('name', optional($product)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
            {!! $errors->first('name', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>

<div class="field">
    <div class="columns">
        <div class="column has-background-info is-one-fifth">
            <label for="description" class="label has-text-white">Description</label>
        </div>
        <div class="column">
            <textarea class="textarea" name="description" cols="50" rows="10" id="description" minlength="1" maxlength="1000">{{ old('description', optional($product)->description) }}</textarea>
            {!! $errors->first('description', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>

@if(Auth::user()->user_type === 'business')
    <div class="field">
        <div class="columns">
            <div class="column has-background-info is-one-fifth">
                <label for="count" class="label has-text-white">Count</label>
            </div>
            <div class="column">
                <input class="input" name="count" type="number" id="count" value="{{ old('count', optional($product)->count) }}" placeholder="Enter count here...">
                {!! $errors->first('count', '<p class="help is-danger">:message</p>') !!}
            </div>
        </div>
    </div>
@endif

<div class="field">
    <div class="columns">
        <div class="column has-background-info is-one-fifth">
            <label for="color" class="label has-text-white">Color</label>
        </div>
        <div class="column">
            {{--<input class="form-control" name="color" type="text" id="color" value="{{ old('color', optional($product)->color) }}" minlength="1" placeholder="Enter color here...">--}}
            <select name="color" id="color" class="select">
                <option value="" disabled selected>Select Color</option>
                <option value="#D50000" class="has-background-red">Red</option>
                <option value="#E91E63" class="has-background-pink">Pink</option>
                <option value="#9C27B0" class="has-background-purple">Purple</option>
                <option value="#2196F3" class="has-background-info">Blue</option>
                <option value="#3F51B5" class="has-background-dark-info">Dark Blue</option>
                <option value="#03A9F4" class="has-background-light-info">Light Blue</option>
                <option value="#4CAF50" class="has-background-green">Green</option>
                <option value="#8BC34A" class="has-background-light-green">Light Green</option>
                <option value="#FFEB3B" class="has-background-yellow">Yellow</option>
                <option value="#FFC107" class="has-background-gold">Gold</option>
                <option value="#FF9800" class="has-background-orange">Orange</option>
                <option value="#FF5722" class="has-background-deep-orange">Deep Orange</option>
                <option value="#795548" class="has-background-brown">Brown</option>
                <option value="#9E9E9E" class="has-background-grey">Grey</option>
                <option value="#607D8B" class="has-background-blue-grey">Blue Grey</option>
                <option value="#000000" class="has-background-black">Black</option>
                <option value="#FFFFFF">White</option>
            </select>
            {!! $errors->first('color', '<p class="help is-danger">:message</p>') !!}
        </div>

        {{--<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">--}}
            {{--<label for="is_active" class="col-md-2 control-label">Is Active</label>--}}
            {{--<div class="col-md-10">--}}
                {{--<div class="checkbox">--}}
                    {{--<label for="is_active_1">--}}
                        {{--<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($product)->is_active) == '1' ? 'checked' : '' }}>--}}
                        {{--Yes--}}
                    {{--</label>--}}
                {{--</div>--}}

                {{--{!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}--}}
            {{--</div>--}}
        {{--</div>--}}
        @role('admin', true)
        <div class="column">
            <b-field>
                <b-radio-button v-model="activeButton"
                                native-value="1"
                                type="is-info"
                                name="is_active"
                                id="is_active">
                    <b-icon icon="check"></b-icon>
                    <span>Active</span>
                </b-radio-button>

                <b-radio-button v-model="activeButton"
                                native-value="0"
                                type="is-danger"
                                name="is_active"
                                id="is_active">
                    <b-icon icon="close"></b-icon>
                    <span>Not Active</span>
                </b-radio-button>
            </b-field>
        </div>
        <div class="column">
            <b-field>
                <b-radio-button v-model="preferredButton"
                                native-value="1"
                                type="is-info"
                                name="preferred"
                                id="preferred">
                    <b-icon icon="check"></b-icon>
                    <span>Preferred</span>
                </b-radio-button>

                <b-radio-button v-model="preferredButton"
                                native-value="0"
                                type="is-danger"
                                name="preferred"
                                id="preferred">
                    <b-icon icon="close"></b-icon>
                    <span>Not Preferred</span>
                </b-radio-button>
            </b-field>
        @endrole
    </div>
</div>