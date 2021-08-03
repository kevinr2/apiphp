<?php 
require_once 'conexion/conexion.php';
date_default_timezone_set('America/Bogota');

class Token extends Conexion
{
    public function actualizarToken($fecha){
        $query ="UPDATE usuarios_token SEt Estado ='Inactivo' WHERE Fecha < '$fecha'";
        $verificar = parent::monQuery($query);
        if ($verificar > 0) {
        return true;
        }else{
            return 0;
        }
    }

}



?>