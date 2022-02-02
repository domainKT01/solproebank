@extends('adminlte::page')

@section('title', 'Solproe')

@section('content_header')
    <h1>List Customers</h1>
@stop

@section('content')
    <div class="card">
        <div card-heard>
            <a class="btn btn-outline-success" href="{{ route('admin.requestorings.create') }}">Create</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-sm ">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">TAX IDENTIFICATION</th>
                        <th class="text-center">CUSTOMER</th>
                        <th class="text-center">CITY</th>
                        <th class="text-center">STATE</th>
                        <th class="text-center" colspan="2">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requestorings as $requestoring)
                        <tr>
                            <td width="10px">{{ $requestoring->ID_REQUESTORIG }}</td>
                            <td width="10px">{{ $requestoring->NIT }}</td>
                            <td class="col-md-4" width="12px">{{ $requestoring->DES_REQUESTORIG }}</td>
                            <td  width="10px">{{ $requestoring->DES_AREA }}</td>
                            <td width="10px">{{$requestoring->ID_STATE}}</td>

                            {{-- CREATE BUTTONS --}}
                            <td width="10px">
                                <a class="btn btn-outline-info btn-med float-right" href="{{ route('admin.requestorings.edit', $requestoring) }}">Edit</a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.requestorings.destroy', $requestoring) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger  ">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
