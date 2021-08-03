<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";
date_default_timezone_set('America/Bogota');

class Auth extends Conexion {
   
    public function login($json){

        $_respuestas = new Respuestas;
        $datos = json_decode($json, true);
        if(!isset($datos['usuario']) || !isset($datos["password"])){
            //error con los campos
            return $_respuestas->error_400();
        }else{
           
            $usuario = $datos['usuario'];
            $password =$datos["password"];
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);
            if($datos){
                //verificar constraseña
                if($password== $datos[0]["Password"]){
                    if($datos[0]['Estado'] == 'Activo'){
                        //crear token
                        $verificar =$this->insertarToken($datos[0]['UsuarioId']);
                        if ($verificar) {
                            
                            $result = $_respuestas->response;
                            $result["result"]= array(
                                "token"=>$verificar
                            );
                            return $result;
                        }else{
                            //error al guardar 
                            return $_respuestas->error_500("Error interno,");
                        }
                    }else{
                        return $_respuestas->error_200("no esta inactivo");
                    }
                }else{
                     return $_respuestas->error_200("no es valido");
                }
               

            }else{
                return $_respuestas->error_200("el usuario $usuario no existe");
                
            }
        }
    }
    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioId,Password,Estado FROM usuarios WHERE Usuario ='$correo'";
        $datos = parent::obtenerdatos($query);
        if(isset($datos[0]["UsuarioId"])){
            return $datos;
        }else{
            echo "hay un error aca";
            return  0;
        }
    }
    private function insertarToken($usuarioid){
        $val =true;
        
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date =date("Y-m-d H:i");
        $estado ="Activo";
        $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha) VALUES ('$usuarioid','$token','$estado','$date')";
        $verifica =parent::monQuery($query);
        if($verifica){
            return $token;
        }else{
            return 0;
        }
    }
}


?>