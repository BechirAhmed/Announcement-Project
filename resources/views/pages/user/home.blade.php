@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->full_name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    @include('panels.welcome-panel')

@endsection

@section('footer_scripts')
@endsection