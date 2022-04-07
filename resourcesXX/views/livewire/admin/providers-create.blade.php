<div class="card">
    <div class="card_body">

        {{-- {!! Form::open(['route' => 'admin.requestorings.store', 'autocomplete' => 'off']) !!} --}}
    
        <form action="{{ route('admin.providers.store') }}" method="post">
            
            @csrf
            <div class="form-row ml-4 mt-4">

                <div class="form-group col-md-2">
                    <label for="tax_identification">TAX IDENTIFICATION</label>
                    <input type="text" class="form-control" name="tax_identification" text-left
                        placeholder='Enter tax identification' required maxlength="12">
                    @error('tax_identification')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label for="check_digit">DIGIT</label>
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
                    </select>
                    @error('CHECK_DIGIT')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-2 ">
                    <label for="id_regime">REGIME</label>
                    <select name="" class="form-control">
                        <option selected>Choose digit</option>
                        <option value="Simplificado">Simplificado</option>
                        <option value="Comun">Comun</option>
                        <option value="Gran Contribuyente">Gran Contribuyente</option>
                        <option value="Autoretenedor">Autoretenedor</option>
                    </select>
                    @error('id_REGIME')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6 ">
                    <label for="email">EMAIL FOR ELECTRONIC BILLING</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email for electronic billing">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-group col-md-11 ml-4 mt-2">
                <label for="name">PROVIDERS</label>
                <input type="text" name="name" class="form-control" placeholder="Enter providers name" maxlength="50">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-11 ml-4 mt-2">
                <label for="address">ADDRESS</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address" maxlength="50">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row ml-4 mt-2">

                <div class="form-group col-md-2">
                    <label for="phones">PHONES LANDLINE</label>
                    <input type="text" name="phones" class="form-control" placeholder="Enter landline" maxlength="12">
                    @error('phones')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-2 ">
                    <label for="mobile">MOBILE</label>
                    <input type="text" name="mobile" class="form-control" placeholder="Enter mobile" maxlength="12">
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-row ml-4 mt-2">

                <div class="form-group ">
                    <label>STATE</label>                        
                    <select class="form-control"  name="id_state" wire:click="listarmunicipios($event.target.value)">
                        <option>Choose state</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->ID_STATE }}">{{ $estado->DES_STATE }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($municipios)
                    <div class="form-group ">
                        <label>TOWNS</label>
                        <select class="form-control" name="">
                            <option>Choose towns</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id_state}}">{{ $municipio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
            </div>
        </form>

    </div>      
</div>