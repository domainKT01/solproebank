<div class="card">
   
    <div card-heard>
        <input class="form-control" placeholder="Type what you want to search for">
        <a class="btn btn-outline-success" href="{{ route('admin.providers.create') }}">Create</a>
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
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{$proveedor->id}}</td>
                        <td>{{$proveedor->tax_identification}}</td>
                        <td>{{$proveedor->name}}</td>
                        <td>{{$proveedor->city}}</td>
                        <td>{{$proveedor->state}}</td>
                        <td with="10px">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.providers.edit', $proveedor)}}">Editar</a>
                        </td>
                        <td with="10px">
                            <form action="{{route('admin.providers.destroy', $proveedor)}}" method="POST">
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
