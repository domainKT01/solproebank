<div class="form-row ml-4 mt-4">
    <div class="form-group col-md-2">
        {!! Form::label('TAX IDENTIFICATION', '') !!}
        {!! Form::text('tax_identification', null, ['class' => 'form-control', 'placeholder' => 'Enter tax identification ']) !!}
        @error('tax_identification')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group ">
        {!! Form::label('CHECK DIGIT', '') !!}
        <select id="inputState" class="form-control">
            <option selected>choose check digit</option>
            <option>...</option>
        </select>
        @error('CHECK_DIGITAL')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-8">
        {!! Form::label('PROVIDER', '') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter provider name']) !!}
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-row ml-4 mt-4">
    <div class="form-group col-md-4 ">
        <select name="" class="form-control">
            
            @foreach ($estados as $estado)
                <option value="{{ $estado->ID_STATE }}">{{ $estado->DES_STATE }}</option>
                <option>...</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4 ">
        {!! Form::label('CITY', '') !!}
        <select id="inputState" class="form-control">
            <option selected>choose city</option>
            <option>...</option>
        </select>
        @error('city')
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
    <div class="form-group col-md-8">
        {!! Form::label('ADDRESS', '') !!}
        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
        @error('address')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('PHONE', '') !!}
        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter phone']) !!}
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('EMAIL', '') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
