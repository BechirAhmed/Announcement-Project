@extends('layouts.app')

@section('template_title')
  Showing Users
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        @lang('usersmanagement.showing-all-users')
                    </span>

                    <div class="btn-group pull-right btn-group-xs">

                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                            <span class="sr-only">
                                Show Users Management Menu
                            </span>
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="/users/create">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Create New User
                                </a>
                            </li>
                            <li>
                                <a href="/users/deleted">
                                    <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                    Show Deleted User
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                @include('partials.search-users-form')

                <div class="table-responsive users-table">
                    <table class="table is-narrow is-fullwidth data-table">
                        <thead class="thead">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th class="hidden-xs">Email</th>
                                <th class="hidden-xs">Account Type</th>
                                <th class="hidden-xs">Full Name</th>
                                <th>Role</th>
                                <th class="hidden-sm hidden-xs hidden-md">Created</th>
                                <th class="hidden-sm hidden-xs hidden-md">Updated</th>
                                <th>Actions</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="users_table">
                            @foreach($users as $user)
                                @php
                                    Carbon\Carbon::setLocale('en');
                                    $now=Carbon\Carbon::now();
                                    $created_date = Carbon\Carbon::parse($user->created_at);
                                    $updated_date = \Carbon\Carbon::parse($user->updated_at);
                                    $created = $created_date->diffForHumans($now);
                                    $updated = $created_date->diffForHumans($now);
                                @endphp
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td class="hidden-xs"><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                    <td class="hidden-xs">{{$user->user_type}}</td>
                                    <td class="hidden-xs">{{$user->full_name}}</td>
                                    <td>
                                        @foreach ($user->roles as $user_role)

                                            @if ($user_role->name == 'User')
                                                @php $labelClass = 'is-info' @endphp

                                            @elseif ($user_role->name == 'Admin')
                                                @php $labelClass = 'is-success' @endphp

                                            @elseif ($user_role->name == 'Unverified')
                                                @php $labelClass = 'is-danger' @endphp

                                            @else
                                                @php $labelClass = 'is-light' @endphp

                                            @endif

                                            <b-tag type="{{$labelClass}}" rounded>{{ $user_role->name }}</b-tag>

                                        @endforeach
                                    </td>
                                    <td class="hidden-sm hidden-xs hidden-md">{{$created}}</td>
                                    <td class="hidden-sm hidden-xs hidden-md">{{$updated}}</td>
                                    <td style="padding: 0;vertical-align: middle;">
                                        <div style="display: inline-flex;">

                                            {!! Form::open(array('url' => 'users/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            <a class="button is-danger is-small m-r-5" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?" data-toggle="modal" type="button">
                                                <b-icon
                                                        icon="delete-empty"
                                                        size="is-small">
                                                </b-icon>
                                            </a>
                                            {{--{!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span> <span class="hidden-xs hidden-sm hidden-md"> User</span>', array('class' => 'button is-danger is-small','type' => 'button','data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}--}}
                                            {!! Form::close() !!}
                                            <a class="button is-small is-success m-r-5" href="{{ URL::to('users/' . $user->id) }}" data-toggle="tooltip" title="Show">
                                                <b-icon
                                                        icon="eye"
                                                        size="is-small">
                                                </b-icon>
                                            </a>
                                            <a class="button is-small is-info" href="{{ URL::to('users/' . $user->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                <b-icon
                                                        icon="account-edit"
                                                        size="is-small">
                                                </b-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="search_results"></tbody>
                    </table>

                    <span id="user_count"></span>
                    <span id="user_pagination">
                        {{ $users->links() }}
                    </span>



                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}

    {{-- @if(config('laravelusers.enableSearchUsers')) --}}
        @include('scripts.search-users')
    {{-- @endif --}}

@endsection
