@extends('adminlte::page')

@section('title', 'Dashboar')

@section('content_header')
    <h1>Providers Create</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <div>{{ session('info') }}</div>
        </div>
    @endif
    <div class="card">
        <div class="card_body">
            {!! Form::open(['route' => 'admin.providers.store']) !!}
            
            @include('admin.providers.partials.form')
            {!! form::submit('Providers Create', ['class' => 'btn btn-primary']) !!}
            {!! form::close() !!}
        </div>
    </div>
@stop
