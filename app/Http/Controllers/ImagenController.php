<?php

namespace App\Http\Controllers;

use App\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //almacena las imagenes
    public function store(Request $request)
    {
        $ruta_imagen = $request->file('file')->store('establecimientos', 'public');

        //Resize la imagen
        $imagen = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 450);
        $imagen->save();

        //almacenar imagen con modelo
        $imagenDB = new Imagen;
        $imagenDB->id_establecimiento = $request['uuid'];
        $imagenDB->ruta_imagen = $ruta_imagen;

        $imagenDB->save();

        //retornar respuesta
        $respuesta = [
            'archivo' => $ruta_imagen
        ];

        return response()->json($respuesta);
        
        //return $request->all();
        //return $request->file('file');
    }

    //delete imagenes with axios
    public function destroy(Request $request){

        $imagen = $request->get('imagen');

        if(File::exists('storage/' . $imagen)) 
        {
            File::delete('storage/' . $imagen);
        }

        /*$respuesta = [
            'imagen_aliminar' => $imagen
        ];*/

        $respuesta = [
            'mensaje' => 'Imagen eliminada',
            'imagen' => $imagen
        ];

        //primera forma de eliminar la imagen de la BD
        //Imagen::where('ruta_imagen', '=', $imagen)->delete(); 
        $imagenEliminar = Imagen::where('ruta_imagen', '=', $imagen)->firstOrFail();
        Imagen::destroy($imagenEliminar->id);
        
        return response()->json($respuesta);
    }
}
