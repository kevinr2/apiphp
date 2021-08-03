<?php
date_default_timezone_set('America/Bogota');
 require_once '../clases/token.class.php';

$_token = new Token;
$fecha = date("Y-m-d H:i");
echo $_token->actualizarToken($fecha);



?>