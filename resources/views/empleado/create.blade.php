@extends('layouts.app')

@section('content')
<div class="container">

Formulario de creacion de empleado

<form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data" >
@csrf

<!--incluimos el formulario de form.blade reutilziando codigo-->
@include('empleado.form',['modo'=>'crear'])

</form>
</div>
@endsection