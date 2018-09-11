@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($unitRelated->name) ? $unitRelated->name : 'Unit Related' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('unit_relateds.unit_related.destroy', $unitRelated->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('unit_relateds.unit_related.index') }}" class="btn btn-primary" title="{{ trans('unit_relateds.show_all') }}">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('unit_relateds.unit_related.create') }}" class="btn btn-success" title="{{ trans('unit_relateds.create') }}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('unit_relateds.unit_related.edit', $unitRelated->id ) }}" class="btn btn-primary" title="{{ trans('unit_relateds.edit') }}">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('unit_relateds.delete') }}" onclick="return confirm(&quot;{{ trans('unit_relateds.confirm_delete') }}?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ trans('unit_relateds.name') }}</dt>
            <dd>{{ $unitRelated->name }}</dd>
            <dt>{{ trans('unit_relateds.description') }}</dt>
            <dd>{{ $unitRelated->description }}</dd>
            <dt>{{ trans('unit_relateds.is_active') }}</dt>
            <dd>{{ ($unitRelated->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

@endsection