@extends('adminlte::page')
@section('content_header')
    <div class="d-flex justify-content-between mt-2">
        @yield('header')
    </div>
@endsection

@section('content')
    @yield('content')
@endsection

@section('js')
    @yield('js')
@endsection
