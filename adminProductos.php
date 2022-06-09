<?php

include_once('conectorBD.php');
class Producto
{
  public $nombre;
  public $id;
  public $fechaCreacion;
  public $imagen;
  public $precio;
  public $descripcion;
  public $categoria;
  public $pesoCantidad;
  public $animal;
  public $stock;
  public $tipo;

  public function __construct()
  {
    $this->id = 0;
  }
}

class Oferta
{
  public $id;
  public $producto;
  public $descuento;
  public function __construct()
  {
    $this->id = 0;
  }
}


class administradorProductos extends conector
{
  public function insertaProducto($nombre, $precio, $imagen, $descripcion, $categoria, $fecha, $cantidadPeso)
  {
    $sql = 'INSERT INTO producto (nombre, precio, imagen_portada, descripcion, categoria, fecha_creacion, cantidad_peso)
        values ("' . $nombre . '", ' . $precio . ', "' . $imagen . '", "' . $descripcion . '", "' . $categoria . '","' . $fecha . '" , "' . $cantidadPeso . '");';
    $this->ejecutar($sql);
  }
  public function dameCantidadProductos()
  {
  }
  public function insertaOferta($prodcuto, $descuento)
  {
    $sql = 'INSERT INTO ofertas (id_producto,porcentaje_descuento) VALUES (' . $prodcuto . ',' . $descuento . ');';
    $this->ejecutar($sql);
  }
  public function dameProducto($id)
  {
    $prod = new Producto();
    $sql = "SELECT producto.id, categoria.categoria, categoria.tipo, animal, nombre, precio, imagen_portada, descripcion, fecha_creacion, cantidad_peso 
    FROM producto INNER JOIN categoria ON producto.categoria = categoria.id
    WHERE producto.id = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $prod->id = $row['id'];
      $prod->nombre = $row['nombre'];
      $prod->imagen = $row['imagen_portada'];
      $prod->precio = $row['precio'];
      $prod->categoria = $row['categoria'];
      $prod->descripcion = $row['descripcion'];
      $prod->fechaCreacion = $row['fecha_creacion'];
      $prod->pesoCantidad = $row['cantidad_peso'];
      $prod->animal = $row['animal'];
      $prod->tipo = $row['tipo'];
      $prod->stock = $this->dameStokProducto($prod->id);
    }
    //print_r(json_encode($arregloProductos));
    return $prod;
  }

  public function dameUltimaOferta()
  {
    $oferta = new Oferta();
    $sql = "SELECT * FROM ofertas;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $oferta->id = $row['id'];
      $oferta->producto = $this->dameProducto($row['id_producto']);
      $oferta->descuento = $row['porcentaje_descuento'];
    }
    //print_r(json_encode($arregloProductos));
    return $oferta;
  }

  public function dameOferta($id)
  {
    $oferta = new Oferta();
    $sql = "SELECT * FROM ofertas WHERE id_producto = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $oferta->id = $row['id'];
      $oferta->producto = $this->dameProducto($row['id_producto']);
      $oferta->descuento = $row['porcentaje_descuento'];
    }
    //print_r(json_encode($arregloProductos));
    return $oferta;
  }

  public function dameOfertas()
  {

    $sql = "SELECT * FROM ofertas;";
    $arregloOfertas = array();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $oferta = new Oferta();
      $oferta->id = $row['id'];
      $oferta->producto = $this->dameProducto($row['id_producto']);
      $oferta->descuento = $row['porcentaje_descuento'];
      $arregloOfertas[] = $oferta;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloOfertas;
  }

  public function eliminaProducto($id)
  {
    $sql = 'DELETE FROM producto WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  public function eliminaOferta($id)
  {
    $sql = 'DELETE FROM ofertas WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  function dameProductos()
  {
    $arregloProductos = array();
    $sql = "SELECT producto.id, categoria.categoria, categoria.tipo, animal, nombre, precio, imagen_portada, descripcion, fecha_creacion, cantidad_peso 
    FROM producto INNER JOIN categoria ON producto.categoria = categoria.id
    ORDER BY nombre;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $prod = new Producto();
      $prod->id = $row['id'];
      $prod->nombre = $row['nombre'];
      $prod->imagen = $row['imagen_portada'];
      $prod->precio = $row['precio'];
      $prod->categoria = $row['categoria'];
      $prod->descripcion = $row['descripcion'];
      $prod->fechaCreacion = $row['fecha_creacion'];
      $prod->pesoCantidad = $row['cantidad_peso'];
      $prod->animal = $row['animal'];
      $prod->tipo = $row['tipo'];
      $prod->stock = $this->dameStokProducto($prod->id);
      $arregloProductos[] = $prod;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloProductos;
  }

  function dameProductosRango($min, $max)
  {

    $arregloProductos = array();
    $sql = "SELECT producto.id, categoria.categoria, categoria.tipo, animal, nombre, precio, imagen_portada, descripcion, fecha_creacion, cantidad_peso 
    FROM producto INNER JOIN categoria ON producto.categoria = categoria.id WHERE precio BETWEEN $min AND $max
    ORDER BY nombre;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $prod = new Producto();
      $prod->id = $row['id'];
      $prod->nombre = $row['nombre'];
      $prod->imagen = $row['imagen_portada'];
      $prod->precio = $row['precio'];
      $prod->categoria = $row['categoria'];
      $prod->descripcion = $row['descripcion'];
      $prod->fechaCreacion = $row['fecha_creacion'];
      $prod->pesoCantidad = $row['cantidad_peso'];
      $prod->animal = $row['animal'];
      $prod->tipo = $row['tipo'];
      $prod->stock = $this->dameStokProducto($prod->id);
      $arregloProductos[] = $prod;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloProductos;
  }

  public function dameProductoCategoria($categoria, $animal)
  {

    $arregloProductos = array();
    $sql = 'SELECT producto.id, categoria.categoria, categoria.tipo, animal, nombre, precio, imagen_portada, descripcion, fecha_creacion, cantidad_peso 
    FROM producto INNER JOIN categoria ON producto.categoria = categoria.id WHERE categoria.categoria = "' . $categoria . '" AND animal = "' . $animal . '"
    ORDER BY nombre;';

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $prod = new Producto();
      $prod->id = $row['id'];
      $prod->nombre = $row['nombre'];
      $prod->imagen = $row['imagen_portada'];
      $prod->precio = $row['precio'];
      $prod->categoria = $row['categoria'];
      $prod->descripcion = $row['descripcion'];
      $prod->fechaCreacion = $row['fecha_creacion'];
      $prod->pesoCantidad = $row['cantidad_peso'];
      $prod->animal = $row['animal'];
      $prod->tipo = $row['tipo'];
      $prod->stock = $this->dameStokProducto($prod->id);
      $arregloProductos[] = $prod;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloProductos;
  }

  function dameProductosBuscados($busqueda)
  {
    $arregloProductos = array();
    $sql = 'SELECT producto.id, categoria.categoria, categoria.tipo, animal, nombre, precio, imagen_portada, descripcion, fecha_creacion, cantidad_peso 
    FROM producto INNER JOIN categoria ON producto.categoria = categoria.id WHERE nombre LIKE "%' . $busqueda . '%"
    ORDER BY nombre;';

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $prod = new Producto();
      $prod->id = $row['id'];
      $prod->nombre = $row['nombre'];
      $prod->imagen = $row['imagen_portada'];
      $prod->precio = $row['precio'];
      $prod->categoria = $row['categoria'];
      $prod->descripcion = $row['descripcion'];
      $prod->fechaCreacion = $row['fecha_creacion'];
      $prod->pesoCantidad = $row['cantidad_peso'];
      $prod->animal = $row['animal'];
      $prod->tipo = $row['tipo'];
      $prod->stock = $this->dameStokProducto($prod->id);
      $arregloProductos[] = $prod;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloProductos;
  }
  function dameEntradas($id)
  {
    $suma = 0;
    $sql = 'SELECT SUM(cantidad) as entrada FROM entradas where id_producto = ' . $id . ';';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma += intval(($row['entrada']));
    }

    return $suma;
  }

  function dameCarrito($id)
  {
    $suma = 0;
    $sql = 'SELECT SUM(cantidad) as carritoT FROM carrito where id_producto = ' . $id . ';';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma += intval(($row['carritoT']));
    }

    return $suma;
  }
  function dameSalidas($id)
  {
    $suma = 0;
    $sql = 'SELECT SUM(cantidad) as salidaT FROM salidas where id_producto = ' . $id . ';';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma += intval(($row['salidaT']));
    }

    return $suma;
  }

  function dameProductosCont()
  {
    $suma = 0;
    $sql = 'SELECT count(id) as total FROM producto;';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma += intval(($row['total']));
    }

    return $suma;
  }

  function dameOfertasCont()
  {
    $suma = 0;
    $sql = 'SELECT count(id) as total FROM ofertas;';
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $suma += intval(($row['total']));
    }

    return $suma;
  }
  function dameStokProducto($id)
  {
    return $this->dameEntradas($id) - ($this->dameCarrito($id) + $this->dameSalidas($id));
  }
  public function modificaProducto()
  {
  }
}
