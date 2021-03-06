<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;


class VideosController extends Controller
{
    public function crear(Request $req){

        $respuesta = ["status" => 1,"msg"=> "" ];        
        $datos = $req ->getContent();

        //VALIDAR EL JSON hola pepe

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parametro para que en su lugar lo devuelva como array.
        
        //VALIDAR LOS DATOS

        $video = new Video();
        $video->titulo = $datos->titulo;
        $video->foto = $datos->foto;
        $video->enlace = $datos->enlace;
        $video->visto = $datos->visto = 0;
        $video->curso_id = $datos->curso_id;


        //Escribir en la base de datos
        try{
            $video->save();
            $respuesta['msg'] = "Video guardado con id ".$video->id;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();

            
        }

       return response()->json($respuesta);
    
        

    }
public function listar(){


        $respuesta = ["status" => 1,"msg"=> "" ];
        try{
            $videos = Video::all();
            $respuesta['datos'] = $videos;

        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
            
        }

        
        return response() ->json($respuesta);
    }
    
    public function ver($id){

        $respuesta = ["status" => 1,"msg"=> "" ];
        try{
            $video = Video::find($id);
            $respuesta['datos'] = $video;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
    
            
        }
    
       return response()->json($respuesta);
    
    }
}
