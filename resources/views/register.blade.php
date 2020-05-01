@extends('capas.app')

@section('title','register')
    
@section('content')
    <form action="" method="post">
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input id="nombres" class="form-control" type="text" name="">
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input id="correo" class="form-control" type="text" name="">
        </div>
        <div class="form-group">
            <label for="telefono">Telefono</label>
            <input id="telefono" class="form-control" type="number" name="">
        </div>
    </form>
@endsection