<?php
include_once('captcha.php');
include_once('administradorDeContactos.php');
include_once('contacto.php');


//asignacion de la bariable json en caso de recivir un json (en proceso)
$json = file_get_contents('php://input');
$datos = json_decode($json);

//Asignacion de variables para el codigo de accion
$operacion = $_POST["accion"];

//asignacion de varibales para cliente
// $id = $_POST['id'];
// $nombre = $_POST['nombre'];
// $email = $_POST['email'];
// $asunto = $_POST['asunto'];
// $mensaje = $_POST['mensaje'];


//Variables para las operaciones del api (se pueden vambiar dependiendo de las necesidades de la pagina)
//Aqui se anota el nombre que tenga el boton dependiendo del caso

$casoAgregar = "nuevoContacto";
$casoEliminar = "eliminarContacto";
$casoDarDeBaja = "baja";
$casoVerRegistro = "VerContacto";
$casoVerTodo = "VerContactos";

//variable que se usa como separador al momento de posterar un registro

$separador = ',';

function verificarCaptcha()
{
    $captcha = $_POST['g-recaptcha-response'];
    $cap = new Captcha($captcha);
    return $cap->dameEstatus();
}


function nuevoContacto()
{
    $nombre = $_POST['con_nombre'];
    $email = $_POST['con_correo'];
    $asunto = $_POST['con_asunto'];
    $mensaje = $_POST['con_mensaje'];
    $coneccion = new administradorContactos();
    $coneccion->nuevoContacto($nombre, $email, $asunto, $mensaje);
    return true;
}



// function verRegistro()
// {
//     $id = $_POST['id'];
//     $admin = new administradorContactos();
//     echo json_encode($admin->verContacto($id));
// }
// //operaciones del api
// function verTodo()
// {
//     $admin = new administradorContactos();
//     echo json_encode($admin->verContactos());
// }

switch ($operacion) {
    case $casoAgregar:
        if (verificarCaptcha()) {
            if (nuevoContacto()) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "Captcha incorrecto";
        }
        break;
        // case $casoEliminar:
        //     $sql = "DELETE FROM `contacto` WHERE `contacto`.`id` = $id";
        //     break;
        // case $casoDarDeBaja:
        //     $sql = "UPDATE `contacto` SET `activo` = 0 WHERE `contacto`.`id` = $id";
        //     break;
        // case $casoVerRegistro:
        //     verRegistro();
        //     break;

        // case $casoVerTodo:
        //     verTodo();
        //     break;
}

//mensaje en caso de que algun dato falle
