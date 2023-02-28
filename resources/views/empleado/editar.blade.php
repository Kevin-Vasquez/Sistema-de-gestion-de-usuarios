@extends('layouts.app')

@section('content')
<div class="container">

Formulario de edicion de empleado

<form action="{{ url('/empleado/'.$empleado->id) }}" method="post" enctype="multipart/form-data">

    @csrf
    {{ method_field('patch') }}
    <!--incluimos el formulario de form.blade reutilziando codigo-->
    <br>
    @include('empleado.form',['modo'=>'editar'])

</form>
</div>
@endsection