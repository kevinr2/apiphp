<?php 

require_once "clases/respuestas.class.php";
require_once "clases/paciente.class.php";

 $_respuestas = new Respuestas;
    $_pacientes =new Pacientes;

 if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listarP= $_pacientes->listarPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarP);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $pacienteid =$_GET["id"];
        $datosPaciente = $_pacientes->obtenerPaciente($pacienteid);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
 }else if($_SERVER["REQUEST_METHOD"] == "POST"){
     //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos recibidos
    $datosArray = $_pacientes->post($postBody);
    header("content-type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
    $responseCode = $datosArray["result"]["error_id"];
    http_response_code($responseCode);
    }else{
            http_response_code(200);
    }
      echo  json_encode($datosArray);

 }else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datosArray = $_pacientes->put($postBody);
    header("content-type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
    $responseCode = $datosArray["result"]["error_id"];
    http_response_code($responseCode);
    }else{
            http_response_code(200);
    }
      echo  json_encode($datosArray);
   

}else if($_SERVER["REQUEST_METHOD"] == "DELETE"){
    $headers =getallheaders();
    if(isset($headers["token"]) && isset($headers["pacienteid"])){
        //recibimos los datos enviados por el header
        $send =[
            "token"=> $headers["token"],
            "pacienteid"=> $headers["pacienteid"]
        ];
        $postBody =json_encode($send);
        
    }else{
        $postBody = file_get_contents("php://input");
    }

    $datosArray = $_pacientes->delete($postBody);
    header("content-type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
    $responseCode = $datosArray["result"]["error_id"];
    http_response_code($responseCode);
    }else{
            http_response_code(200);
    }
      echo  json_encode($datosArray); 
}else{
    header("Content-Type: application/json");
    $datosArray= $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>