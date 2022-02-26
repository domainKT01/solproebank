
@extends('adminlte::page')

@section('title','Dashboar')

@section('content_header')
    <h1>List Providers</h1>
@stop

@section('content')
@livewire('admin.providers-index')

@stop
