<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursosController extends Controller
{
    public function crear(Request $req){

        $respuesta = ["status" => 1,"msg"=> "" ];        
        $datos = $req ->getContent();

        //VALIDAR EL JSON hola pepe

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parametro para que en su lugar lo devuelva como array.
        
        //VALIDAR LOS DATOS

        $curso = new Curso();
        $curso->titulo = $datos->titulo;
        $curso->portada = $datos->portada;
        $curso->descripcion = $datos->descripcion;

        //Escribir en la base de datos
        try{
            $curso->save();
            $respuesta['msg'] = "Curso guardado con id ".$curso->id;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();

            
        }

       return response()->json($respuesta);
    
        

    }
/*

    public function desactivar($id){

        $respuesta = ["status" => 1,"msg"=> "" ];
        $usuario = Usuario::find($id);

        if($usuario && $usuario->activado == 1){
            try{
                $usuario->activado = 0;
                $usuario->save();
                $respuesta['msg'] = "Usuario desactivado";
            }catch(\Exception $e){
                $respuesta['status'] = 0;
                $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
    
                
            }

        }else if(!$usuario->activado == 1){
            $respuesta["msg"] = "Usuario ya esta desactivado";
            $respuesta["Status"] = 0;
        }else{
            $respuesta["msg"] = "Persona no encontrada";
            $respuesta["Status"] = 0;
        }

        return response()->json($respuesta);
    }
*/
    /*public function editar(Request $req,$id){

        $respuesta = ["status" => 1,"msg"=> "" ];
        
        $datos = $req ->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parametro para que en su lugar lo devuelva como array.
        
        //VALIDAR LOS DATOS

        $usuario = Usuario::find($id);

        if ($usuario->activado == 1){
            if(isset($datos->nombre))
                $usuario->nombre = $datos->nombre;

            if(isset($datos->foto))
                $usuario->foto = $datos->foto;

            if(isset($datos->contraseña))
                $usuario->contraseña = $datos->contraseña;

        //Escribir en la base de datos
            try{
                $usuario->save();
                $respuesta['msg'] = "Usuario actualizada ";
            }catch(\Exception $e){
                $respuesta['status'] = 0;
                $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
            }
        }else {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "El usuario esta desactivado";
        }

       

       return response()->json($respuesta);
    
        

    }
    */

    public function listar(Request $busqueda){

        $respuesta = ["status" => 1, "msg" => ""];
        try{

            if($busqueda -> has('busqueda')){

               $cursos = Curso::select(['titulo','portada'])                        
                        ->withCount('videos as videos_curso')    
                        ->where('titulo','like','%'. $busqueda -> input('busqueda').'%')
                        ->get();

            }else{
                $cursos = Curso::select(['titulo','portada'])                        
                        ->withCount('videos as videos_curso')    
                        ->get();
               
            }
            
            $respuesta['datos'] = $cursos;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }
    
    public function ver($id){

        $respuesta = ["status" => 1,"msg"=> "" ];
        try{
            $curso = Curso::find($id);
            $respuesta['datos'] = $curso;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
    
            
        }
    
       return response()->json($respuesta);
    
    }
}
