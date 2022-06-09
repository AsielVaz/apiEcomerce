<?php

include_once('conectorBD.php');
class PagoOfline
{
  public $id;
  public $idORden;
  public $idUsuario;
  public $url;

  public function __construct()
  {

    $this->id = 0;
  }
}


class administradorPagosOfline extends conector
{
  public function insertaPago($usuario, $orden, $url)
  {
    $sql = 'INSERT INTO pago_ofline (url,id_usuario,id_orden) values ("' . $url . '",' . $usuario . ',"' . $orden . '");';
    $this->ejecutar($sql);
  }
  public function damePagoOrden($id)
  {
    $pago = new PagoOfline();
    $sql = 'SELECT id,url,id_usuario,id_orden 
    FROM pago_ofline WHERE id_orden = "' . $id . '";';

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $pago->id = $row['id'];
      $pago->idORden = $row['id_orden'];
      $pago->idUsuario = $row['id_usuario'];
      $pago->url = $row['url'];
    }
    //print_r(json_encode($arregloProductos));
    return $pago;
  }
  public function eliminaPago($id)
  {
    $sql = 'DELETE FROM pago_ofline WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
}
