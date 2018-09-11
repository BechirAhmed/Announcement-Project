@extends('layouts.public')

@section('template_title')
    Stores
@endsection

@section('template_linked_css')
    <style>
        img.userAvatar {
            width: 34px;
            border-radius: 50%;
        }
        .info{
            display: -webkit-box;
            margin-top: 5px;
        }
        .avatarDiv {
            width: 55px;
            height: 55px;
            margin-top: 9px;
            padding: 0;
        }
        .infoDiv{
            margin-left: -15px;
            padding: 0 0 0 5px;
            z-index: 9999;
        }
        .nameDiv{
            box-sizing: border-box;
            background: #ffffffbf;
            white-space: nowrap;
        }
        .nameDiv:not(:hover) {
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="columns">
            @foreach($users as $user)
                <div class="column is-one-fifth">
                    <div class="cover">
                        <img src="{{$user->profile->cover }}" alt="{{$user->full_name}}">
                    </div>
                    <div class="info">
                        <div class="avatarDiv column is-one-quarter">
                            <img src="{{$user->profile->avatar }}" alt="{{$user->full_name}}" class="userAvatar">
                            <div class="avatar-halo svgIcon u-absolute txtColorGreenNormal" style="width: 38px; height: 55px; top:-36px; right:2px; position: relative;">
                                <svg viewBox="0 0 114 114" xmlns="http://www.w3.org/2000/svg" style="fill: #000">
                                    <path d="M7.66922967,32.092726 C17.0070768,13.6353618 35.9421928,1.75 57,1.75 C78.0578072,1.75 96.9929232,13.6353618 106.33077,32.092726 L107.66923,31.4155801 C98.0784505,12.4582656 78.6289015,0.25 57,0.25 C35.3710985,0.25 15.9215495,12.4582656 6.33077033,31.4155801 L7.66922967,32.092726 Z" fill-rule="evenodd"></path>
                                    <path d="M106.33077,81.661427 C96.9929232,100.118791 78.0578072,112.004153 57,112.004153 C35.9421928,112.004153 17.0070768,100.118791 7.66922967,81.661427 L6.33077033,82.338573 C15.9215495,101.295887 35.3710985,113.504153 57,113.504153 C78.6289015,113.504153 98.0784505,101.295887 107.66923,82.338573 L106.33077,81.661427 Z" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="infoDiv column is-two-quarter">
                            <?php
                            $now=Carbon\Carbon::now();
                            $creat_date = Carbon\Carbon::parse($user->created_at);
                            $last_update_date = Carbon\Carbon::parse($user->updated_at);
                            $created = $creat_date->diffForHumans($now);
                            $updated = $last_update_date->diffForHumans($now);
                            ?>
                            <div class="nameDiv">
                                <span class="nameSpan" style="background: #ffffffc2">
                                    <a href="{{ route('store', ['userName' => $user->name]) }}" class="link-noUnderline">
                                        {{$user->full_name}}
                                    </a>
                                </span>
                            </div>
                            <p>{{ $created }}</p>
                        </div>
                        <div class="follow column is-one-quarter">
                                @if(Auth::user())
                                    @if (auth()->user()->isFollowing($user->id))
                                        <form action="{{route('unfollow', ['id' => $user->id])}}" method="POST" style="margin-top: -4px;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-follow-{{ $user->id }}" class="button is-danger is-sm" title="unFollow the Store">
                                                <i class="mdi mdi-account-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{route('follow', ['id' => $user->id])}}" method="POST" style="margin-top: -4px;">
                                            {{ csrf_field() }}

                                            <button type="submit" id="follow-user-{{ $user->id }}" class="btn btn-success" title="Follow the Store">
                                                <i class="mdi mdi-account-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form action="{{route('follow', ['id' => $user->id])}}" method="POST" style="margin-top: -4px;">
                                        {{ csrf_field() }}

                                        <button type="submit" id="follow-user-{{ $user->id }}" class="button is-success" title="Follow the Store">
                                            <i class="mdi mdi-account-plus"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection