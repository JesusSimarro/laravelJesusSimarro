@if(count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ isset($alumno->nombre) ? $alumno->nombre : old('nombre') }}">
</div>

<div class="form-group">
    <label for="apellido">Apellido</label>
    <input type="text" class="form-control" name="apellido" id="apellido" value="{{ isset($alumno->apellido) ? $alumno->apellido : old('apellido') }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ isset($alumno->email) ? $alumno->email : old('email') }}">
</div>

<div class="form-group">
    <label for="edad">Edad</label>
    <input type="number" class="form-control" name="edad" id="edad" value="{{ isset($alumno->edad) ? $alumno->edad : old('edad') }}">
</div>

<div class="form-group">
    <label for="direccion">Dirección</label>
    <input type="text" class="form-control" name="direccion" id="direccion" value="{{ isset($alumno->direccion) ? $alumno->direccion : old('direccion') }}">
</div>

<div class="form-group">
    @if(isset($alumno->foto))
        <img src="{{ asset('storage') . '/' . $alumno->foto }}" class="img-thumbnail img-fluid" width="200"/>
        <br/>
    @endif
</div>

<label for="foto">Foto</label>
<input type="file" class="form-control" name="foto" id="foto">
<br/><br/>

<input type="submit" class="btn btn-success" value="{{ $modo }} alumno">
<a href="{{ url('alumno') }}" class="btn btn-primary">Volver</a>