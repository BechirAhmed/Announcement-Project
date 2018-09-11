@extends('layouts.app')

@section('template_linked_css')
    <style>
        .cat-item{
            padding: 0;
            height: 250px;
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
            padding: 0 1px;
            box-shadow: 1px 1px 1px 1px #ccc;
        }
        .form-btn {
            position: absolute;
            right: -1px;
            bottom: 0;
        }
        .button{
            height:2em;
        }
        .button.is-small{
            border-radius: 0;
        }
    </style>
@endsection
@section('content')
<div class="container">
    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Categories</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('categories.category.create') }}" class="btn btn-success" title="Create New Category">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($categories) == 0)
            <div class="panel-body text-center">
                <h4>No Categories Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">

            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-2 cat-item">
                        <a href="{{ route('categories.category.show', $category->id ) }}" class="link-noUnderline">
                            <img src="@if($category->image) {{asset($category->image) }} @else  {{ asset('images/slide2.png') }}@endif" alt="{{ $category->name }}" width="100%">

                            <div class="cat-info">
                                <h1 class="cat-name">{{$category->name}}</h1>
                                <p class="cat-desc">{{ $category->description }}</p>
                            </div>

                        </a>
                    <span class="{{ ($category->is_active) ? 'act-state' : 'deact-state' }}">
                            {{ ($category->is_active) ? 'Activated' : 'Deactivated' }}
                        </span>
                    <div class="form-btn">
                        <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}

                            <div class="btn-group btn-group-xs pull-right" role="group">
                                <a href="{{ route('categories.category.show', $category->id ) }}" class="button is-info is-small link-noUnderline" title="Show Category">
                                    <span class="fa fa-eye" aria-hidden="true"></span>
                                </a>
                                <a href="{{ route('categories.category.edit', $category->id ) }}" class="button is-primary is-small link-noUnderline" title="Edit Category">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>

                                <button type="submit" class="button is-danger is-small link-noUnderline" title="Delete Category" onclick="return confirm(&quot;Delete Sub Category?&quot;)">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </div>

                        </form>
                    </div>
            </div>
            @endforeach
            </div>

        <div class="">
            {!! $categories->render() !!}
        </div>
        
        @endif
        </div>
    </div>
</div>
@endsection