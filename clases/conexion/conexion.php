<?php

    class Conexion{
    
        private $server; 
        private $user;
        private $password;
        private $database;   
        private $port;
        private $conexion;


        function __construct(){
            $listadatos = $this->datosConexion();
            foreach ($listadatos as $key => $value) {
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
                     
             }
            $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
            if($this->conexion->connect_errno){
                echo "algo salio mal";
                die();
            }
        }

        private function datosConexion(){
            $direccion = dirname(__FILE__);
            $jsondata = file_get_contents($direccion. "/" . "config");
            return json_decode($jsondata, true);
        }

        private function convertirUTF8($array){
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, "utf-8", true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }

        public function obtenerdatos($query){
            $result = $this->conexion->query($query);
            $resutlA = array();
            foreach ($result as $key) {
                $resutlA[] =$key;
            }
            return $this->convertirUTF8($resutlA);
        }

        public function monQuery($sql){
            $result = $this->conexion->query($sql);
            return $this->conexion->affected_rows;
        }

        //funcion echa para los insert
        public function monQueryId($sql){
            $result = $this->conexion->query($sql);
            $filas = $this->conexion->affected_rows;
            if($filas >=1){
                return $this->conexion->insert_id;
            }else{
                return 0;
            }
        }

        //incriptar
        protected function encriptar($string){
            
            return md5($string);
        }

    }



?>