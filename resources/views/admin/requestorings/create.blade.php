@extends('adminlte::page')

@section('title', 'Solproe')

@section('content_header')
    <h1>Customers Create</h1>
@stop

@section('content')
    {{-- <div class="card">
        <div class="card-body">

            {!! Form::open(['route' => 'admin.requestorings.store']) !!}

            <span class="label label-success ">Success Label</span>

            <div class="form-row mr-4">
                <div class="form-group">
                    {!! Form::label('TAX IDENTIFICATION', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter tax identification ' ]) !!}
                </div>
                <div class="form-group mr-4">
                    {!! Form::label('CUSTOMER', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer name']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('ADDRESS', '') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter address ']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('CUSTOMER', '') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer name']) !!}
            </div>

            {!! Form::submit('Create customer', ['class' => 'btn btn-outline-success']) !!}
            {!! form::close() !!}
        </div>
    </div> --}}
    <div class="card">
        <div class="card_body">
            {!! Form::open(['route' => 'admin.requestorings.store']) !!}
            <div class="form-row ml-4 mt-4">
                <div class="form-group col-md-2">
                    {!! Form::label('TAX IDENTIFICATION', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter tax identification ']) !!}
                </div>
                <div class="form-group ">
                    {!! Form::label('CHECK DIGIT', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>choose check digit</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    {!! Form::label('CUSTOMER', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer name']) !!}
                </div>
            </div>

            <div class="form-group col-md-11 ml-4 mt-2">
                {!! Form::label('ADDRESS', '') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
            </div>
            <div class="form-row ml-4 mt-4">
                <div class="form-group col-md-6">
                    {!! Form::label('LEGAL REPRESENTATIVE', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter legal representative']) !!}
                </div>
                <div class="form-group ">
                    {!! Form::label('CITIZENSHIP CARD', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter citizenshio card']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('PHONES LANDLINE', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter landline']) !!}
                </div>
                <div class="form-group ">
                    {!! Form::label('MOBILE PHONE', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile phone']) !!}
                </div>
            </div>
            <div class="form-row ml-4 mt-2">
                <div class="form-group col-md-4 ">
                    {!! Form::label('STATE', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>choose state</option>
                        <option>...</option>
                    </select>
                    {{-- {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter city']) !!} --}}
                </div>
                <div class="form-group col-md-4 ">
                    {!! Form::label('CITY', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>choose city</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('NEIGHBORHOOD', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>Choose neighborhood</option>
                        <option>...</option>
                    </select>
                </div>
            </div>
            <div class="form-row ml-4 mt-2">
                <div class="form-group col-md-4 ">
                    {!! Form::label('TAX REGIME', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>Choose tax regime</option>
                        <option>...</option>
                    </select>
                    {{-- {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter tax regime']) !!} --}}
                </div>
                <div class="form-group col-md-4 ">
                    {!! Form::label('EMAIL FOR ELECTRONIC BILLING', '') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter email for electronic billing']) !!}
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
            {!! form::close() !!}
        </div>
    </div>

@stop
