<?php

include_once('conectorBD.php');
class Categoria
{
  public $categoria;
  public $id;
  public $animal;
  public $imagen;
  public $tipo;
  public $cantidadProductos;
}


class administradorCategorias extends conector
{
  public function insertaCategoria($imagen, $categoria, $animal, $tipo)
  {
    $sql = 'INSERT INTO categoria (categoria, animal, imagen, tipo) 
    values ("' . $categoria . '","' . $animal . '","' . $imagen . '","' . $tipo . '");';
    $this->ejecutar($sql);
  }
  public function dameOrden()
  {
  }
  public function eliminaCategoria($id)
  {
    $sql = 'DELETE FROM categoria WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  public function dameCantidadProductos($categoria, $animal)
  {
    $suma = 0;
    $sql = 'SELECT count(producto.id) as suma
    FROM producto 
    INNER JOIN categoria ON producto.categoria = categoria.id 
    WHERE categoria.categoria = "' . $categoria . '" AND animal = "' . $animal . '";';

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma = $row['suma'];
    }
    //print_r(json_encode($arregloProductos));
    return $suma;
  }
  public function dameCategorias()
  {
    $arregloProductos = array();
    $sql = "SELECT id, categoria, animal, imagen, tipo FROM categoria;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $cat = new Categoria();
      $cat->id = $row['id'];
      $cat->categoria = $row['categoria'];
      $cat->animal = $row['animal'];
      $cat->imagen = $row['imagen'];
      $cat->tipo = $row['tipo'];
      $cat->cantidadProductos = $this->dameCantidadProductos($cat->categoria, $cat->animal);
      $arregloProductos[] = $cat;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloProductos;
  }
  public function modificaOrden()
  {
  }
}
