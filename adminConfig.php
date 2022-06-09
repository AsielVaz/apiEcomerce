<?php
include_once('conectorBD.php');


class Configuracion extends conector
{

    public function getConfig($config)
    {
        $sql = 'SELECT config FROM configuraciones WHERE parametros = "' . $config . '"';
        $result = $this->ejecutar($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['config'];
        }
    }
}
