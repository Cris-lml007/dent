
@extends('layouts.main')

@section('header')
    <h1>{{ $title ?? '' }}</h1>
@endsection
@section('content')
{{ $slot }}
@endsection
