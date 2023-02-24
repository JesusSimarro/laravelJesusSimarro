@extends('layouts.app')

@section('scripts')
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
<div class="container">

    <a href="{{ url('alumno/create') }}" class="btn btn-success">Registrar alumno</a>
    @if (Session::has('mensaje'))
        <br/>
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
        </div>
    @endif

    <hr>

    <table class="table data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->id }}</td>
                    <td><img src="{{ asset('storage') . '/' . $alumno->foto }}" class="img-thumbnail img-fluid" width="100"/></td>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->apellido }}</td>
                    <td>{{ $alumno->email }}</td>
                    <td>{{ $alumno->edad }}</td>
                    <td>{{ $alumno->direccion }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ url('alumno/' . $alumno->id) }}" class="btn btn-primary">Ver</a>
                            <a href="{{ url('alumno/' . $alumno->id . '/edit') }}" class="btn btn-warning">Editar</a>

                            <form action="{{ url('alumno/' . $alumno->id) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }} <!-- Con esto hacemos que el método cambie a DELETE -->
                                <input type="submit" onclick="return confirm('Se va a eliminar el registro #{{ $alumno->id }}')" class="btn btn-danger" value="Eliminar">
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $alumnos->links() !!}
</div>
@endsection

@section('datatable')
<script>
    $(document).ready(function() {
        $('.data-table').DataTable({

        })
    })
</script>
@endsection