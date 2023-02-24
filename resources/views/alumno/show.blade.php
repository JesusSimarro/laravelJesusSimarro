@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ url('alumno') }}">Volver a la lista</a>

    <hr>

    <h3>Nombre completo</h3> {{ $alumno->nombre . ' ' . $alumno->apellido }}

    <h3>Edad:</h3> {{ $alumno->edad }}

    <h3>Dirección:</h3> {{ $alumno->direccion }}

    <h3>Email:</h3> <a href="mailto:{{ $alumno->email }}" title="Enviar un mensaje">{{ $alumno->email }}</a>

    <h3>Imagen</h3> <img src="{{ asset('storage') . '/' . $alumno->foto }}" width="350">

</div>
@endsection