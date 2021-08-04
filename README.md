## Api php
```sh
POST /auth
{
"usuario" :"", -> REQUERIDO
"password": "" -> REQUERIDO
}
```
- Numero de paginas de pacientes(1,2,3) dividad de 100 en 100
```sh
GET /pacientes?page=$numeroPagina
```
- Es necesario tener el token para hacer el POST
```sh
GET /pacientes?id=$idPaciente POST /pacientes
{
"nombre" : "", -> REQUERIDO
"dni" : "", -> REQUERIDO
"correo":"", -> REQUERIDO
"codigoPostal" :"",
"genero" : "",
"telefono" : "",
"fechaNacimiento" : "",
"token" : "" -> REQUERIDO
```
- PUT
```sh
} PUT /pacientes
{
"nombre" : "",
"dni" : "",
"correo":"",
"codigoPostal" :"",
"genero" : "",
"telefono" : "",
"fechaNacimiento" : "",
"token" : "" , -> REQUERIDO
"pacienteId" : "" -> REQUERIDO
```
- DELETE
```sh
} DELETE /pacientes
{
"token" : "", -> REQUERIDO
"pacienteId" : "" -> REQUERIDO
```
