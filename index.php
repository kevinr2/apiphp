<?php 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Pruebas</title>
    <link rel="stylesheet" href="asset/style.css" >
    
</head>
<body>
    <section class="header">
             <h1>Api de pruebas</h1>
    </section>
<div  class="container">
   
    <div class="info">
        <h3>Auth - login</h3>
        <br>
        <code>
           POST  /auth
           <br>
           {
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
               "password": "" -> REQUERIDO
               <br>
            }
        
        </code>
        
    </div>  
    <br>
    <div class="info">   
        <h3>Pacientes</h3>
        <br>
        <code>
           GET  /paciente?page=$numeroPagina
           <br>
           GET  /paciente?id=$idPaciente
        </code>
        <code>
           POST  /paciente
           <br> 
           {
            <br> 
               "nombre" : "",               -> REQUERIDO
               <br> 
               "dni" : "",                  -> REQUERIDO
               <br> 
               "correo":"",                 -> REQUERIDO
               <br> 
               "codigoPostal" :"",             
               <br>  
               "genero" : "",        
               <br>        
               "telefono" : "",       
               <br>       
               "fechaNacimiento" : "",      
               <br>         
               "token" : ""                 -> REQUERIDO        
               <br>       
           }
        </code>
    </div>
    <br>
    <div class="info">
        <h3> PUT  /pacientes</h3>
        <br>
        <code>
           {
            <br> 
               "nombre" : "",               
               <br> 
               "dni" : "",                  
               <br> 
               "correo":"",                 
               <br> 
               "codigoPostal" :"",             
               <br>  
               "genero" : "",        
               <br>        
               "telefono" : "",       
               <br>       
               "fechaNacimiento" : "",      
               <br>         
               "token" : "" ,                -> REQUERIDO        
               <br>       
               "pacienteid" : ""   -> REQUERIDO
               <br>
           }
          
        </code>
    </div>
        <br>
    <div class="info"> 
        <code>
           
          <h3> DELETE  /pacientes</h3>
           <br> 
           {   
               <br>    
               "token" : "",                -> REQUERIDO        
               <br>       
               "pacienteid" : ""   -> REQUERIDO
               <br>
           }
        </code>
    </div>

</div>
    
</body>
</html>