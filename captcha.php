<?php


class Captcha
{
    private $ip;
    private $captcha;
    private $respuesta;
    private $atributos;
    private $estatus;
    private $secretKey;

    function __construct($recap)
    {
        // include_once('../env/variablesEntorno.php');
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->captcha = $recap;
        $this->secretKey = "6Ld_OMkfAAAAAGgJ7YfM11KUtKjLaoC-lRnyBetY";
        $this->respuesta = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=$this->secretKey&response=$this->captcha&remoteip=$this->ip"
        );
        $this->atributos = json_encode($this->respuesta);

        if (strlen($this->captcha) > 0) {
            if ($this->atributos['success']) {
                $this->estatus = true;
            } else {
                $this->estatus = false;
            }
        } else {
            $this->estatus = false;
        }
    }

    public function dameEstatus()
    {
        return $this->estatus;
    }
}
