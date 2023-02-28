<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

//agregamos una clase para borrar
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //guardamos la informacion en una variable y la enviamos directamente al index
        $datos['empleados']=Empleado::paginate(1);

        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            //validamos luego lel formato de imagen a almacenar
            //'Foto'=>'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido'
            //validamos luego que la imagen es requerida
            //'Foto.required'=>'La foto es requerida'
        ];

        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje=['Foto.required'=>'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);


        //$datosEmpleado = request()->all();
        //recolectamos la informacion de lo que trae el request y le omitimos el valor del token
        $datosEmpleado = request()->except('_token');

        //validamos los datos que trae el request y el archivo que tiene el nombre de Foto se agrega la extencion
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        //hacemos uso del modelo empleado y con ello mandamos los datos a la DB
        Empleado::insert($datosEmpleado);

        //mostramos la informacion que estamos enviando mediante el formulario
        //return response()->json($datosEmpleado);
        return redirect('empleado')->with('mensaje','Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //buscamos el registro mediante el id y se redirecciona a editar
        $empleado=Empleado::findOrFail($id);
        return view('empleado.editar', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //recepcionamos la informacion pero omitimos los valores del token y metodo
        $datosEmpleado = request()->except('_token','_method');

        //verificamos si la foto existe y se adjunta el nombre a la foto y sino se va a mantener la anterior
        if ($request->hasFile('Foto')) {
            //se busca la informacion nuevamente con el id
            $empleado=Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        //buscamos el registro que coincida con el id que se recibe y se actualiza
        Empleado::where('id','=',$id)->update($datosEmpleado);
        //se busca la informacion nuevamente con el id
        $empleado=Empleado::findOrFail($id);
        //se retorna nuevamente al listado
        //return view('empleado.editar', compact('empleado'));

        //agregamos mediante el controlador y le pasamos el id del empleado a elminar
        return redirect('empleado')->with('mensaje','Empleado Modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        //se busca la informacion nuevamente con el id
        $empleado=Empleado::findOrFail($id);

        //validamos si la foto existe en el storage
        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }

        //agregamos mediante el controlador y le pasamos el id del empleado a elminar
        return redirect('empleado')->with('mensaje','Empleado borrado');
    }
}
