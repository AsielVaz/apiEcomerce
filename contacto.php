<?php

class Contacto
{

    public $id;
    public $nombre;
    public $email;
    public $asunto;
    public $mensaje;

    public function __construct()
    {
        $this->id = 1;
        $this->nombre = "Default";
        $this->email = "Default";
        $this->asunto = "Default";
        $this->mensaje = "Dafult";
    }

    public function fijaId($id)
    {
        $this->id = $id;
    }
    public function fijaNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function fijaEmail($email)
    {
        $this->email = $email;
    }
    public function fijaAsunto($asunto)
    {
        $this->asunto = $asunto;
    }
    public function fijaMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    public function dameId()
    {
        return $this->id;
    }
    public function dameNombre()
    {
        return $this->nombre;
    }
    public function dameEmail()
    {
        return $this->email;
    }
    public function dameAsunto()
    {
        return $this->asunto;
    }
    public function dameMensaje()
    {
        return $this->mensaje;
    }
}
