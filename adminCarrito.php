<?php

include_once('conectorBD.php');
include_once('adminProductos.php');
class Carrito
{
  public $id;
  public $idUsuario;
  public $producto;
  public $fechaInserta;
  public $status;
  public $cantidad;
}


class administradorCarrito extends conector
{
  public function insertaCarrito($idUsuario, $idProducto, $fechaInserta, $status, $cantidad)
  {
    $sql = 'INSERT INTO carrito (id_producto, id_cliente, estatus, fecha_inserta, cantidad) 
    VALUES (' . $idProducto . ',' . $idUsuario . ',"' . $status . '","' . $fechaInserta . '",' . $cantidad . ');';
    $this->ejecutar($sql);
  }
  public function dameCarrito()
  {
  }
  public function eliminaCarrito($id)
  {
    $sql = 'DELETE FROM carrito WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  public function dameCarritoId($id)
  {
    $adminProd = new administradorProductos();

    $arregloCarrito = array();
    $sql = "SELECT id, id_producto, id_cliente, cantidad,estatus, fecha_inserta FROM carrito WHERE id_cliente = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $carrito = new Carrito();
      $carrito->id = $row['id'];
      $carrito->idUsuario = $row['id_cliente'];
      $carrito->producto = $adminProd->dameProducto($row['id_producto']);
      $carrito->fechaInserta = $row['fecha_inserta'];
      $carrito->status = $row['estatus'];
      $carrito->cantidad = $row['cantidad'];

      $arregloCarrito[] = $carrito;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloCarrito;
  }
}
