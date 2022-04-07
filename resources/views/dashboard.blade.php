{{--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lgin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p>hola mundo</p>
            </div>
        </div>
    </div>
</x-app-layout>--}}
@extends('adminlte::page')

@section('title','Dashboar')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <p>Welcome to this beautiful admin panel.</p>
        </div>

        <div class="card-body">
           <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit dolores est excepturi quis incidunt. Ratione, minus temporibus ea quasi non nam enim aperiam sunt? Unde esse molestias dolores blanditiis similique!</p>
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
