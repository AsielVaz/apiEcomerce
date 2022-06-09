<?php

include_once('conectorBD.php');
include_once('adminProductos.php');
include_once('adminCarrito.php');
include_once('adminSalidas.php');
include_once("adminPagoOfline.php");
include_once("adminUsuarios.php");

class Orden
{
  public $id;
  public $idUsuario;
  public $monto;
  public $pagado;
  public $fecha;
  public $tipo;
  public $comprovante;
  public $direccionEnvio;

  public function __construct()
  {
    $this->id = "Default";
  }
}


class administradorOrdenes extends conector
{
  public function insertaOrden($id, $idUsuario, $monto, $pagado, $fecha, $tipo)
  {
    $adminUser = new administradorUsuarios();
    $usuario = $adminUser->dameUsuarioId($idUsuario);
    $direccion = $usuario->ciudad . " " . $usuario->direccion . " " . $usuario->calle . " " . $usuario->pais;

    $sql = 'INSERT INTO orden (id, id_usuario, monto, pagado, fecha_inserta, tipo, direccion_envio) 
    values ("' . $id . '",' . $idUsuario . ',' . $monto . ',' . $pagado . ',"' . $fecha . '", "' . $tipo . '", "' . $direccion . '");';

    $this->ejecutar($sql);
  }


  public function actualizarEstatusOrden($orden, $estatus)
  {
    $sql = 'UPDATE orden
    SET pagado= ' . $estatus . ' WHERE id = "' . $orden . '";';
    $this->ejecutar($sql);
  }
  public function dameOrden($id)
  {
    $adminPagos = new administradorPagosOfline();

    $ord = new Orden();
    $sql = "SELECT id, id_usuario,direccion_envio, monto, pagado, fecha_inserta, tipo FROM orden WHERE id  = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $ord->id = $row['id'];
      $ord->idUsuario = $row['id_usuario'];
      $ord->pagado = $row['pagado'];
      $ord->fecha = $row['fecha_inserta'];
      $ord->tipo = $row['tipo'];
      $ord->direccionEnvio = $row['direccion_envio'];

      $ord->comprovante = $adminPagos->damePagoOrden($ord->id);
      if ($ord->tipo == "entrada") {
        $ord->monto = $this->dameMontoEntradas($ord->id);
      } else if ($ord->tipo == "salida") {
        $ord->monto = $this->dameMontoOrdenSalidas($ord->id);
      }
    }
    //print_r(json_encode($arregloProductos));
    return $ord;
  }

  public function eliminaOrden($id)
  {
    $sql = 'DELETE FROM orden WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  public function modificarOrden($id, $monto)
  {
    $sql = "UPDATE orden
            SET monto = $monto
            WHERE id = $id;";

    $this->ejecutar($sql);
  }
  public function dameMontoOrdenSalidas($id)
  {
    $sql = "SELECT sum(precio * cantidad) as total
      FROM producto
      INNER JOIN salidas
      ON producto.id = salidas.id_producto
      WHERE id_orden = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return floatval($row['total']);
    }
    return 0;
  }
  public function dameMontoEntradas($id)
  {
    $sql = "SELECT sum(precio_unidad * cantidad) as total
    FROM entradas
    WHERE id_orden = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return floatval($row['total']);
    }
    return 0;
  }

  public function dameOrdenesPendientes()
  {
    $adminPagos = new administradorPagosOfline();
    $arregloOrdenes = array();
    $sql = "SELECT id, id_usuario, monto, pagado, fecha_inserta, tipo FROM orden WHERE pagado = 2;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $ord = new Orden();
      $ord->id = $row['id'];
      $ord->idUsuario = $row['id_usuario'];

      $ord->pagado = $row['pagado'];
      $ord->fecha = $row['fecha_inserta'];
      $ord->tipo = $row['tipo'];
      $ord->comprovante = $adminPagos->damePagoOrden($ord->id);
      if ($ord->tipo == "entrada") {
        $ord->monto = $this->dameMontoEntradas($ord->id);
      } else if ($ord->tipo == "salida") {
        $ord->monto = $this->dameMontoOrdenSalidas($ord->id);
      }
      $arregloOrdenes[] = $ord;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloOrdenes;
  }
  public function dameOrdenesPagadas()
  {
    $adminPagos = new administradorPagosOfline();
    $arregloOrdenes = array();
    $sql = "SELECT id, id_usuario, direccion_envio, monto, pagado, fecha_inserta, tipo FROM orden WHERE pagado = 1;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $ord = new Orden();
      $ord->id = $row['id'];
      $ord->idUsuario = $row['id_usuario'];
      $ord->direccionEnvio = $row['direccion_envio'];
      $ord->pagado = $row['pagado'];
      $ord->fecha = $row['fecha_inserta'];
      $ord->tipo = $row['tipo'];
      $ord->comprovante = $adminPagos->damePagoOrden($ord->id);
      if ($ord->tipo == "entrada") {
        $ord->monto = $this->dameMontoEntradas($ord->id);
      } else if ($ord->tipo == "salida") {
        $ord->monto = $this->dameMontoOrdenSalidas($ord->id);
      }
      $arregloOrdenes[] = $ord;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloOrdenes;
  }
  public function dameOrdenes()
  {
    $adminPagos = new administradorPagosOfline();
    $arregloOrdenes = array();
    $sql = "SELECT id, id_usuario, monto, pagado, fecha_inserta, tipo FROM orden;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $ord = new Orden();
      $ord->id = $row['id'];
      $ord->idUsuario = $row['id_usuario'];

      $ord->pagado = $row['pagado'];
      $ord->fecha = $row['fecha_inserta'];
      $ord->tipo = $row['tipo'];
      $ord->comprovante = $adminPagos->damePagoOrden($ord->id);
      if ($ord->tipo == "entrada") {
        $ord->monto = $this->dameMontoEntradas($ord->id);
      } else if ($ord->tipo == "salida") {
        $ord->monto = $this->dameMontoOrdenSalidas($ord->id);
      }
      $arregloOrdenes[] = $ord;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloOrdenes;
  }
  public function dameOrdenesId($id)
  {
    $adminPagos = new administradorPagosOfline();
    $arregloOrdenes = array();
    $sql = "SELECT id, id_usuario, monto, pagado, fecha_inserta, tipo FROM orden WHERE id_usuario = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $ord = new Orden();
      $ord->id = $row['id'];
      $ord->idUsuario = $row['id_usuario'];

      $ord->pagado = $row['pagado'];
      $ord->fecha = $row['fecha_inserta'];
      $ord->tipo = $row['tipo'];
      $ord->comprovante = $adminPagos->damePagoOrden($ord->id);
      if ($ord->tipo == "entrada") {
        $ord->monto = $this->dameMontoEntradas($ord->id);
      } else if ($ord->tipo == "salida") {
        $ord->monto = $this->dameMontoOrdenSalidas($ord->id);
      }
      $arregloOrdenes[] = $ord;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloOrdenes;
  }
  public function generarOrdenTienda($idusuario, $id)
  {
    $adminCarrito = new administradorCarrito();
    $adminSalidas = new administradorSalidas();
    $carrito = $adminCarrito->dameCarritoId($idusuario);
    foreach ($carrito as $car) {
      $adminSalidas->insertaSalida($car->producto->id, $id, $car->cantidad);
      $adminCarrito->eliminaCarrito($car->id);
    }
  }



  public function modificaOrden()
  {
  }
}
