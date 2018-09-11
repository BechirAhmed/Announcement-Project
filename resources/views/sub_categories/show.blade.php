@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($subCategory->name) ? $subCategory->name : 'Sub Category' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('sub_categories.sub_category.destroy', $subCategory->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('sub_categories.sub_category.index') }}" class="btn btn-primary" title="Show All Sub Category">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('sub_categories.sub_category.create') }}" class="btn btn-success" title="Create New Sub Category">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('sub_categories.sub_category.edit', $subCategory->id ) }}" class="btn btn-primary" title="Edit Sub Category">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Sub Category" onclick="return confirm(&quot;Delete Sub Category??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Slug</dt>
            <dd>{{ $subCategory->slug }}</dd>
            <dt>Category</dt>
            <dd>{{ optional($subCategory->category)->name }}</dd>
            <dt>Name</dt>
            <dd>{{ $subCategory->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $subCategory->description }}</dd>
            <dt>Image</dt>
            <dd>{{ basename($subCategory->image) }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($subCategory->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

@endsection