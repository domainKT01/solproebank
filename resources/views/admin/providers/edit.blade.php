
@extends('adminlte::page')

@section('title','Dashboar')

@section('content_header')
    <h1>Edit Providers</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <div>{{session('info')}}</div>
        </div>
        
    @endif
    <div class="card">
        {!! Form::model($providers, ['route'=>['admin.providers.update',$providers],'method'=>'put']) !!}
         @include('admin.providers.partials.form')

         {{!!form::submit('Update',['class'=>'btn btn.primary']) !!}}
        {!! Form::close() !!}

    </div>
    
@stop


