@extends('layouts.app')

@section('template_title')
    Welcome {{ Auth::user()->full_name }}
@endsection

@section('head')
@endsection

@section('template_linked_css')
    <style>
        .is-left{
            float: left;
        }
    </style>
@endsection

@section('content')

    @include('panels.welcome-panel')

@endsection

@section('footer_scripts')
    <script>
//        $('.link-noUnderline').click(function (event) {
//            // Avoid the link click from loading a new page
//            event.preventDefault();
//
//            // Load the content from the link's href attribute
//            $('.content').load($(this).attr('href'));
//        });
    </script>
@endsection