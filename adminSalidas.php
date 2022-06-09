<?php

include_once('conectorBD.php');
class Salida
{
  public $idOrden;
  public $id;
  public $cantidad;
  public $producto;
  public $precioUnidad;
}


class administradorSalidas extends conector
{
  public function insertaSalida($idProducto, $idOrden, $cantidad)
  {
    $sql = 'INSERT INTO salidas(id_producto, id_orden, cantidad) 
    VALUES (' . $idProducto . ', ' . $idOrden . ',' . $cantidad . ');';
    $this->ejecutar($sql);
  }
  public function dameSalida()
  {
  }
  public function eliminaSalida($id)
  {
    $sql = 'DELETE FROM salidas WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function procesarVerRegistrosIdOrden($id_orden)
  {
    $arregloEntradas = array();
    $sql = "SELECT salidas.id, nombre,id_producto, id_orden, cantidad, precio
    FROM salidas
    INNER JOIN  producto
    ON producto.id = salidas.id_producto
    WHERE id_orden = '$id_orden';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $salida = new Salida();
      $salida->id = $row['id'];
      $salida->idOrden = $row['id_orden'];
      $salida->precioUnidad = $row['precio'];
      $salida->cantidad = $row['cantidad'];
      $salida->producto = $row['nombre'];
      $arregloEntradas[] = $salida;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloEntradas;
  }


  public function dameEntradas()
  {
  }
  public function modificaEntrada()
  {
  }
}
