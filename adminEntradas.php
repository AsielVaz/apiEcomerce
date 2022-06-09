<?php

include_once('conectorBD.php');
class Entrada
{
  public $idOrden;
  public $id;
  public $proovedor;
  public $precioUnidad;
  public $cantidad;
  public $producto;
}


class administradorEntradas extends conector
{
  public function insertaEntrada($idProducto, $idOrden, $proovedor, $precioUnidad, $cantidad, $fecha, $lote, $serie)
  {
    $sql = 'INSERT INTO entradas(id_producto, id_orden, proovedor, precio_unidad, cantidad, serie, caducidad, lote) 
    VALUES (' . $idProducto . ', "' . $idOrden . '","' . $proovedor . '",' . $precioUnidad . ',' . $cantidad . ', "' . $serie . '", "' . $fecha . '", "' . $lote . '");';
    $this->ejecutar($sql);
  }
  public function dameEntrada()
  {
  }
  public function eliminaEntrada($id)
  {
    $sql = 'DELETE FROM entradas WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function procesarVerRegistrosIdOrden($id_orden)
  {
    $arregloEntradas = array();
    $sql = "SELECT entradas.id, nombre,id_producto, id_orden, proovedor, precio_unidad, cantidad 
    FROM entradas
    INNER JOIN  producto
    ON producto.id = entradas.id_producto
    WHERE id_orden = '$id_orden';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $entrada = new Entrada();
      $entrada->id = $row['id'];
      $entrada->idOrden = $row['id_orden'];
      $entrada->proovedor = $row['proovedor'];
      $entrada->precioUnidad = $row['precio_unidad'];
      $entrada->cantidad = $row['cantidad'];
      $entrada->producto = $row['nombre'];
      $arregloEntradas[] = $entrada;
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
