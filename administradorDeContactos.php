<?php

include_once('conectorBD.php');
include_once('contacto.php');


class administradorContactos extends conector
{

    public function nuevoContacto($nombre, $email, $asunto, $mensaje)
    {


        // $sql = "INSERT INTO contacto (mensaje, nombre, email, asunto, activo) 
        // VALUES ('" . $contacto->dameMensaje() . "', '" . $contacto->dameNombre() . "', '" . $contacto->dameEmail() . "' , '" . $contacto->dameAsunto() . "', 1)";
        $sql = "INSERT INTO contacto (nombre, email, asunto, mensaje) VALUES ( '$nombre', '$email', '$asunto', '$mensaje');";

        $this->ejecutar($sql);

        return true;
    }



    // public function verContacto($id)
    // {


    //     $cont = new Contacto();
    //     $arregloContactos = array();
    //     $sql = "SELECT id, nombre, mensaje, email, asunto 
    //     FROM contacto
    //     WHERE id = $id";

    //     $result = $this->ejecutar($sql);

    //     if ($result->num_rows > 0) {
    //         //asignacion de valor al row para sacar los registros (en este caso solo 1)
    //         $row = $result->fetch_assoc();
    //         //asignacion de varibales recicaladas
    //         $cont->fijaId($row['id']);
    //         $cont->fijaNombre($row['nombre']);
    //         $cont->fijaEmail($row['email']);
    //         $cont->fijaAsunto($row['asunto']);
    //         $cont->fijaMensaje($row['mensaje']);
    //         //publicacion del registro completo en la pagina para el uso que se le quiera dar
    //         return $cont;
    //     } else {
    //         echo "0 results";
    //     }
    // }


    // public function verContactos()
    // {

    //     $arregloContactos = array();
    //     $sql = "SELECT id, nombre, mensaje, email, asunto, 
    //        FROM contacto";

    //     $result = $this->ejecutar($sql);

    //     if ($result->num_rows > 0) {
    //         //asignacion de valor al row para sacar los registros (en este caso solo 1)
    //         //asignacion de varibales recicaladas
    //         while ($row = $result->fetch_assoc()) {
    //             $cont = new Contacto();
    //             $cont->fijaId($row['id']);
    //             $cont->fijaNombre($row['nombre']);
    //             $cont->fijaEmail($row['email']);
    //             $cont->fijaAsunto($row['asunto']);
    //             $cont->fijaMensaje($row["mensaje"]);
    //             $arregloContactos[] = $cont;
    //         }
    //         //publicacion del registro completo en la pagina para el uso que se le quiera dar
    //         return $arregloContactos;
    //     } else {
    //         echo "0 results";
    //     }
    // }
    // public function eliminarContacto()
    // {
    // }
}
