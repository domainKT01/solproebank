@extends('adminlte::page')

@section('title', 'Solproe')

@section('content_header')
    <h1>Customers Create</h1>
@stop

@section('content')
    <div class="card">
        <div class="card_body">
            {!! Form::open(['route' => 'admin.requestorings.store', 'autocomplete' => 'off']) !!}
            <div class="form-row ml-4 mt-4">
                <div class="form-group col-md-2">
                    {!! Form::label('TAX IDENTIFICATION', '') !!}
                    {!! Form::text('NIT', null, ['class' => 'form-control', 'placeholder' => 'Enter tax identification ']) !!}
                    @error('NIT')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group ">
                    {!! Form::label('CHECK DIGIT', '') !!}
                    <select name="" class="form-control">
                        <option selected>Digit</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option>...</option>
                    </select>
                    @error('CHECK_DIGITAL')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4 ">
                    {!! Form::label('TAX REGIME', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>Choose tax regime</option>
                        <option>...</option>
                    </select>
                    @error('REGIME')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    {{-- {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter tax regime']) !!} --}}
                </div>
                <div class="form-group col-md-4 ">
                    {!! Form::label('EMAIL FOR ELECTRONIC BILLING', '') !!}
                    {!! Form::email('correo', null, ['class' => 'form-control', 'placeholder' => 'Enter email for electronic billing']) !!}
                    @error('correo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-11 ml-4 mt-2">
                    {!! Form::label('CUSTOMER', '') !!}
                    {!! Form::text('DES_REQUESTORIG', null, ['class' => 'form-control', 'placeholder' => 'Enter customer name']) !!}
                    @error('DES_REQUESTORIG')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-11 ml-4 mt-2">
                {!! Form::label('ADDRESS', '') !!}
                {!! Form::text('DES_ADDRESS', null, ['class' => 'form-control', 'w-full', 'placeholder' => 'Enter address']) !!}
                @error('DES_ADDRESS')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-row ml-4 mt-4">
                <div class="form-group col-md-4">
                    {!! Form::label('LEGAL REPRESENTATIVE', '') !!}
                    {!! Form::text('persona_encargada', null, ['class' => 'form-control', 'placeholder' => 'Enter legal representative']) !!}
                    @error('persona_encargada')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group ">
                    {!! Form::label('CITIZENSHIP CARD', '') !!}
                    {!! Form::text('CITIZENSHIP_CARD', null, ['class' => 'form-control', 'placeholder' => 'Enter citizenshio card']) !!}
                    @error('CITIZENSHIP_CARD')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('PHONES LANDLINE', '') !!}
                    {!! Form::text('LANDLINE', null, ['class' => 'form-control', 'placeholder' => 'Enter landline']) !!}
                    @error('LANDLINE')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group ">
                    {!! Form::label('MOBILE PHONE', '') !!}
                    {!! Form::text('MOBILE', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile phone']) !!}
                    @error('MOBILE')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row ml-4 mt-2">
                <div class="form-group ">
                    {!! Form::label('ID_STATE', 'state') !!}
                    {!! Form::select('ID_STATE', $states, null, ['class' => 'form-control']) !!}
                    @error('ID_STATE')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4 ">
                    {!! Form::label('CODIGO', 'MUNICIPIOS') !!}
                    {!! Form::select('DES_AREA', $towns, null, ['class' => 'form-control']) !!}
                    @error('DES_AREA')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('NEIGHBORHOOD', '') !!}
                    <select id="inputState" class="form-control">
                        <option selected>Choose neighborhood</option>
                        <option>...</option>
                    </select>
                    @error('NEIGHBORHOOD')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row ml-4 mt-2">


            </div>
            {!! form::submit('Customer Create', ['class' => 'btn btn-success float-right mb-4 mr-2']) !!}
            {!! form::close() !!}
        </div>
    </div>

@stop
