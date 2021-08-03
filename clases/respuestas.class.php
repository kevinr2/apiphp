<?php 

class  Respuestas
{
    public $response =[
        "status"=> "ok",
        "result"=> array()
    ];

    public function error_405()
    {
        $this->response['status']="error";
        $this->response['result']=array(
            "error_id"=> "405",
            "error_msg"=>"Metodo no permitido"
        );
        return $this->response;
    }
    public function error_200($string="Datos incorrectos")
    {
        $this->response['status']="error";
        $this->response['result']=array(
            "error_id"=> "200",
            "error_msg"=>$string
        );
        return$this->response;
    }
    public function error_400()
    {
        $this->response['status']="error";
        $this->response['result']=array(
            "error_id"=> "400",
            "error_msg"=>"datos enviadors incompletos o formato incompletos"
        );
        return $this->response;
    }
    public function error_500($string="Datos incorrectos")
    {
        $this->response['status']="error";
        $this->response['result']=array(
            "error_id"=> "500",
            "error_msg"=>$string
        );
        return$this->response;
    }
    public function error_401($string="token incorrecto")
    {
        $this->response['status']="error";
        $this->response['result']=array(
            "error_id"=> "401",
            "error_msg"=>$string
        );
        return$this->response;
    }





}



?>