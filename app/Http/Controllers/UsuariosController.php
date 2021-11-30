<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Curso;


class UsuariosController extends Controller
{
    public function crear(Request $req){

        $respuesta = ["status" => 1,"msg"=> "" ];        
        $datos = $req ->getContent();

        //VALIDAR EL JSON hola pepe

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parametro para que en su lugar lo devuelva como array.
        
        //VALIDAR LOS DATOS

        $usuario = new Usuario();
        $usuario->nombre = $datos->nombre;
        $usuario->foto = $datos->foto;
        $usuario->email = $datos->email;
        $usuario->contraseña = $datos->contraseña;
        $usuario->activado = $datos->activado = 1;

        if(isset($datos->email))
            $usuario->email = $datos->email;

        //Escribir en la base de datos
        try{
            $usuario->save();
            $respuesta['msg'] = "Usuario guardada con id ".$usuario->id;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();

            
        }

       return response()->json($respuesta);
    
        

    }


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

    public function editar(Request $req,$id){

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
    
        

    }public function ver($id){

        $respuesta = ["status" => 1,"msg"=> "" ];
        try{
            $usuario = Usuario::find($id);
            $respuesta['datos'] = $usuario;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
    
            
        }
    
       return response()->json($respuesta);
    
    }
    public function comprar_curso($curso_id,$usuario_id){
        $respuesta = ["status" => 1, "msg" => ""];

        $usuario = Usuario::find($usuario_id);
        $curso = Curso::find($curso_id);
       

        if($usuario && $curso){
            $usuario->cursos()->attach($curso);
            $respuesta['msg'] = "El usuario ".$usuario->nombre. " ha comprado el curso ".$curso->titulo;
        }else{
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Usuario o Curso no encontrado: ";
        }
        return response()->json($respuesta);

    }

    public function adquiridos($usuario_id){

        $respuesta = ["status" => 1, "msg" => ""];

        $usuario = Usuario::find($usuario_id);
        

        if($usuario){
            $comprados = $usuario->cursos;
            $respuesta['Cursos'] = $comprados;
        }else{
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Usuario no encontrado: ";
        }
        return response()->json($respuesta);

    }

}
