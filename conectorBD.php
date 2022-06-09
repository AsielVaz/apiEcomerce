<?php

class conector
{

    private $servername;
    private $database;
    private $username;
    private $password;

    public function __construct()
    {

        $this->servername = "";
        $this->database = "";
        $this->username = "";
        $this->password = "";
        $this->apikeycaptcha = "";
    }
    public function ejecutar($query)
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("No se pudo conectar devido a: " . mysqli_connect_error());
        }
        $result = mysqli_query($conn, $query);
        return $result;
    }
}
