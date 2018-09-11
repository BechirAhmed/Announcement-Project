@extends('layouts.app')

@section('template_linked_css')
    <style>
        .cat-item{
            padding: 0;
            height: 300px;
            box-shadow: 1px 1px 1px 1px #ccc;
            margin: 1px 10px;
        }
        .cat-info{
            padding: 5px 10px;
        }
        .cat-name{
            margin-top: 10px;
            font-size: 20px;
        }
        .cat-desc{
            margin-top: 10px;
        }
        .act-state{
            background-color: forestgreen;
            color: #fff;
            position: absolute;
            bottom: 0;
            padding: 0 6px;
            box-shadow: 1px 1px 1px 1px #ccc;
        }
        .deact-state{
            background-color: #E53935;
            color: #fff;
            position: absolute;
            bottom: 0;
            padding: 0 6px;
            box-shadow: 1px 1px 1px 1px #ccc;
        }
    </style>
@endsection

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($category->name) ? $category->name : 'Category' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('categories.category.index') }}" class="btn btn-primary" title="Show All Category">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('categories.category.create') }}" class="btn btn-success" title="Create New Category">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('categories.category.edit', $category->id ) }}" class="btn btn-primary" title="Edit Category">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Category" onclick="return confirm(&quot;Delete Category??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body" style="height: 350px; background: url({{ asset('images/754ca65c8bf2642ac4d39541231b3562393b233f.jpg') }}) no-repeat; background-size: cover">
        <dl class="dl-horizontal">
            <dt>Slug</dt>
            <dd>{{ $category->slug }}</dd>
            <dt>Name</dt>
            <dd>{{ $category->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $category->description }}</dd>
            <dt>Image</dt>
            <dd>{{ basename($category->image) }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($category->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

    <div class="container">
        <div class="row">
            @foreach($subCategories as $subCategory)
                <a href="{{ route('sub_categories.sub_category.show', $subCategory->id ) }}">
                    <div class="col-md-3 cat-item">
                        <img src="{{ asset('images/66b63b85ab943f3f491c60a66ecff1b993de4d24.png') }}" alt="{{ $subCategory->name }}" width="100%">

                        <div class="cat-info">
                            <h1 class="cat-name">{{$subCategory->name}}</h1>
                            <p class="cat-desc">{{ $subCategory->description }}</p>
                        </div>

                        <span class="{{ ($subCategory->is_active) ? 'act-state' : 'deact-state' }}">
                            {{ ($subCategory->is_active) ? 'Activated' : 'Deactivated' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

    </div>

@endsection