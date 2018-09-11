@extends('layouts.app')

@section('content')

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
                <h4 class="mt-5 mb-5">{{ trans('unit_relateds.model_plural') }}</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('unit_relateds.unit_related.create') }}" class="btn btn-success" title="{{ trans('unit_relateds.create') }}">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($unitRelateds) == 0)
            <div class="panel-body text-center">
                <h4>{{ trans('unit_relateds.none_available') }}</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>{{ trans('unit_relateds.name') }}</th>
                            <th>{{ trans('unit_relateds.is_active') }}</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($unitRelateds as $unitRelated)
                        <tr>
                            <td>{{ $unitRelated->name }}</td>
                            <td>{{ ($unitRelated->is_active) ? 'Yes' : 'No' }}</td>

                            <td>

                                <form method="POST" action="{!! route('unit_relateds.unit_related.destroy', $unitRelated->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('unit_relateds.unit_related.show', $unitRelated->id ) }}" class="btn btn-info" title="{{ trans('unit_relateds.show') }}">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('unit_relateds.unit_related.edit', $unitRelated->id ) }}" class="btn btn-primary" title="{{ trans('unit_relateds.edit') }}">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="{{ trans('unit_relateds.delete') }}" onclick="return confirm(&quot;{{ trans('unit_relateds.confirm_delete') }}&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $unitRelateds->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection