
@extends('layouts.main')

@section('header')
    <h1>{{ $title ?? '' }}</h1>
@endsection
@section('content')

<style>
table.dataTable thead th {
    color: black !important;
    background-color: white !important;
    /* border-bottom: 2px solid var(--color-bordes) !important; */
}
</style>

{{ $slot }}
@endsection


