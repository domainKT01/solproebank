<div class="card">

    <div class="card-heard">
        <div class="input-group mb-3 mt-3">
            <input wire:model="search" class="form-control mt-2 ml-4 mr-4 "
                placeholder="Type what you want to search for">
            <div class="input-group-btn">
                <a class="btn btn-outline-info btn-med mr-2 mt-2"
                    href="{{ route('admin.providers.create') }}">Create</a>
                {{-- <button class="btn btn-outline-info btn-sm float-right mr-4">Create</button> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered table-sm ">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">TAX IDENTIFICATION</th>
                    <th class="text-center">PROVIDERS</th>
                    <th class="text-center">CITY</th>
                    <th class="text-center">STATE</th>
                    <th class="text-center" colspan="2">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->name }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->phones }}</td>
                        <td>{{ $proveedor->Cod_city }}</td>
                        <td with="10px">
                            <a class="btn btn-primary btn-sm"
                                href="{{ route('admin.providers.edit', $proveedor) }}">Editar</a>
                        </td>
                        <td with="10px">
                            <form action="{{ route('admin.providers.destroy', $proveedor) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class=" btn btn-danger btn-sm" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
