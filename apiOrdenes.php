<?php

include_once('adminOrdenes.php');

$accion = $_POST['accion'];
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoOrdenTienda = "tienda";
$casoVerUnRegistro  = "verUno";
$casoCambioStatus  = "estatus";






function procesarAlta()
{
  $idUsuario = $_POST['id_usuario'];
  $pagado = $_POST['pagado'];
  $fecha = $_POST['fecha'];
  $tipo = $_POST['tipo'];
  $id = $_POST['id'];
  $admin = new administradorOrdenes();
  $admin->insertaOrden($id, $idUsuario, 0, $pagado, $fecha, $tipo);
  echo "1";
}

function generarOrdenCompra()
{
  $idUsuario = $_POST['id_usuario'];
  $pagado = $_POST['pagado'];
  $fecha = $_POST['fecha'];
  $tipo = $_POST['tipo'];
  $id = $_POST['id'];
  $admin = new administradorOrdenes();
  $admin->insertaOrden($id, $idUsuario, 0, $pagado, $fecha, $tipo);
  $admin->generarOrdenTienda($idUsuario, $id);
  echo "1";
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorOrdenes();
  $admin->eliminaOrden($id);
  echo "1";
}

function procesarVerRegistros()
{
}

function procesarCambioEstatus()
{
  $id = $_POST['id'];
  $estatus = $_POST['estatus'];
  $admin = new administradorOrdenes();
  $admin->actualizarEstatusOrden($id, $estatus);
  echo "1";
}

function procesarCambioMonto()
{
  $id = $_POST['id'];
  $monto = $_POST['monto'];
  $admin = new administradorOrdenes();
  $admin->modificaOrden($id, $monto);
}
function procesarVerUnRegistro()
{
}


switch ($accion) {
  case $casoAgregar:
    ProcesarAlta();
    break;
  case $casoEliminar:
    ProcesarBaja();
    break;
  case $casoModificar:
    procesarCambioMonto();
    break;
  case $casoOrdenTienda:
    generarOrdenCompra();
    break;
  case $casoVerUnRegistro:
    break;
  case $casoCambioStatus:
    procesarCambioEstatus();
    break;
}
