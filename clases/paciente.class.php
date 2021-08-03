<?php 
require_once "conexion/conexion.php";
require_once "respuestas.class.php";
date_default_timezone_set('America/Bogota');

class Pacientes extends Conexion
{
    Private $pacienteid  = "";
    Private $dni  ="" ;    
    Private $nombre  ="" ;
    Private $direccion  ="" ;
    Private $codigoPostal  ="" ;    
    Private $genero  ="" ;
    Private $telefono  ="" ;
    Private $fechaNacimiento  ="0000-00-00" ;
    private $correo = "";
    private $token ;
    private $imagen = "";


    private $table ="pacientes";
    public function listarPacientes($pagina = 1){
        $inicio = 0;
        $cantidad=100;
        if ($pagina >1) {
            $inicio = ($cantidad * ($pagina-1))+1;
            $cantidad = $cantidad * $pagina;
        }
        $query ="SELECT PacienteId,Nombre,DNI,Telefono,Correo From ".$this->table . " LIMIT $inicio,$cantidad";
        $datos = parent::obtenerdatos($query);
        return($datos);      
    }
    public function obtenerPaciente($id){
      $query = "SELECT * FROM ".$this->table." WHERE PacienteId = '$id'";
      return parent::obtenerdatos($query); 
    }

    public function post($json){
         $_respuesta = new Respuestas; 
        $datos =json_decode($json,true);
        if (!isset($datos["token"])) {
          return $_respuesta->error_401("algo salio mal");
        }else{
            $this->token = $datos["token"];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if (!isset($datos["nombre"]) || !isset($datos["dni"]) || !isset($datos["correo"]) ) {
                    return $_respuesta->error_400();
                }else{
                    $this->nombre = $datos["nombre"];
                    $this->dni = $datos["dni"];
                     $this->correo = $datos["correo"];
                    if(isset($datos["telefono"])){ $this->telefono =$datos["telefono"];}
                    if(isset($datos["direccion"])){ $this->direccion =$datos["direccion"];}
                    if(isset($datos["codigoPostal"])){ $this->codigoPostal =$datos["codigoPostal"];}
                    if(isset($datos["genero"])){ $this->genero =$datos["genero"];}
                    if(isset($datos["fechaNacimiento"])){ $this->fechaNacimiento =$datos["fechaNacimiento"];}

                    if (isset($datos["imagen"])) {
                        $resp = $this->procesarImagen($datos["imagen"]);
                        $this->imagen =$resp;
                    }

                    $resp =$this->insertarPaciente();
                    if ($resp) {
                        $respuesta =$_respuesta->response;
                        $respuesta["result"]=array(
                            "pacienteId"=> $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuesta->error_500();
                    }
                }

            }else{
                return $_respuesta->error_401("token invalido o a caducado");
            }

        }
    }

    private function procesarImagen($img){
        $direccion = dirname(__DIR__)."\public\imagenes\\";
        $partes = explode(";base64",$img);
        $extencion = explode('/', mime_content_type($img))[1];
        $imagen_base64 = base64_decode($partes[1]);
        $file = $direccion . uniqid() ."." .$extencion;

        file_put_contents($file,$imagen_base64);
        $nuevadireccion = str_replace('\\','/',$file);

        return $nuevadireccion;
        
    } 

    
    private function insertarPaciente(){
        $query = "INSERT INTO ".$this->table. " (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo,img) VALUES 
        ('{$this->dni}','{$this->nombre}','{$this->direccion}','{$this->codigoPostal}','{$this->telefono}','{$this->genero}','{$this->fechaNacimiento}','{$this->correo}','{$this->imagen}')";

        $resp = parent::monQuery($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
    public function put($json){
        $_respuesta = new Respuestas;
        $datos =json_decode($json,true);
        if (!isset($datos["token"])) {
            return $_respuesta->error_401("algo salio mal");
          }else{
              $this->token = $datos["token"];
              $arrayToken = $this->buscarToken();
              if($arrayToken){
                if (!isset($datos["pacienteid"])) {
                    return $_respuesta->error_400();
                }else{
                    $this->pacienteid =$datos["pacienteid"];
                    if(isset($datos["nombre"])){ $this->nombre =$datos["nombre"];}
                    if(isset($datos["dni"])){ $this->dni =$datos["dni"];}
                    if(isset($datos["correo"])){ $this->correo =$datos["correo"];}
                    if(isset($datos["telefono"])){ $this->telefono =$datos["telefono"];}
                    if(isset($datos["direccion"])){ $this->direccion =$datos["direccion"];}
                    if(isset($datos["codigoPostal"])){ $this->codigoPostal =$datos["codigoPostal"];}
                    if(isset($datos["genero"])){ $this->genero =$datos["genero"];}
                    if(isset($datos["fechaNacimiento"])){ $this->fechaNacimiento =$datos["fechaNacimiento"];}
                    $resp =$this->modificarPaciente();
                   if ($resp) {
                        $respuesta =$_respuesta->response;
                        $respuesta["result"]=array(
                            "pacienteid"=> $this->pacienteid
                        );
                        return $respuesta;
                    }else{
                        return $_respuesta->error_500();
                    } 
                }
  
              }else{
                  return $_respuesta->error_401("token invalido o a caducado");
              }
          }
        
    }
    private function modificarPaciente(){
        $query ="UPDATE ".$this->table." SET DNI='{$this->dni}',Nombre ='{$this->nombre}',Correo ='{$this->correo}',
        Telefono ='{$this->telefono}',Direccion ='{$this->direccion}',CodigoPostal ='{$this->codigoPostal}',Genero ='{$this->genero}',
        FechaNacimiento ='{$this->fechaNacimiento}' WHERE PacienteId = '{$this->pacienteid}'";
        $resp = parent::monQuery($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
    public function delete($json){
        $_respuesta = new Respuestas;
        $datos =json_decode($json,true);
        if (!isset($datos["token"])) {
            return $_respuesta->error_401("algo salio mal");
          }else{
              $this->token = $datos["token"];
              $arrayToken = $this->buscarToken();
              if($arrayToken){
                if (!isset($datos["pacienteid"])) {
                    return $_respuesta->error_400();
                }else{
                    $this->pacienteid =$datos["pacienteid"];
                    $resp =$this->deletePaciente();
                    
                   if ($resp) {
                        $respuesta =$_respuesta->response;
                        $respuesta["result"]=array(
                            "pacienteid"=> $this->pacienteid
                        );
                        return $respuesta;
                    }else{
                        return $_respuesta->error_500();
                    } 
                }
              }else{
                  return $_respuesta->error_401("token invalido o a caducado");
              }
          }
       
    }
    public function deletePaciente(){
        $query ="DELETE FROM ".$this->table." WHERE PacienteId = '{$this->pacienteid}'";
        $resp = parent::monQuery($query);
        if($resp >=1){
            return $resp;
        }else{
            return 0;
        }
    }
    private function buscarToken(){
        $query="SELECT TokenId, UsuarioId,Estado FROM usuarios_token WHERE token='{$this->token}' AND Estado = 'Activo'";
        $resp = parent::obtenerdatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
    private  function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha ='$date' WHERE TokenId = $tokenid";
        $resp =parent::monQuery($query);
        if($resp >=1){
            return $resp;
        }else{
            return 0;
        }

    }
   

}



?>