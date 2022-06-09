<?php

include_once('conectorBD.php');
class Imagen
{
  public $id;
  public $idProducto;
  public $url;

  public function __construct()
  {
    $this->id = 0;
  }
}


class administradorImagenes extends conector
{
  public function insertaImagen($idProducto, $url)
  {
    $sql = 'INSERT INTO imagenes (id_producto, url) values (' . $idProducto . ',"' . $url . '"); ';
    $this->ejecutar($sql);
  }
  public function dameImagenesDeProducto($id)
  {
    $imagenes = array();
    $sql = "SELECT id, id_producto, url FROM imagenes
    WHERE id_producto = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $imagen = new Imagen();
      $imagen->id = $row['id'];
      $imagen->idProducto = $row['id_producto'];
      $imagen->url = $row['url'];
      $imagenes[] = $imagen;
    }
    //print_r(json_encode($arregloProductos));
    return $imagenes;
  }
  public function eliminaImagen($id)
  {
    $sql = 'DELETE FROM imagenes WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
}
