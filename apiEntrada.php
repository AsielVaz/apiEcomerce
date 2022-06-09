<?php
include_once('adminEntradas.php');
$accion = $_POST['accion'];
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoVerUnRegistro  = "verUno";




function procesarImagen()
{
  $ruta = 0;

  return $ruta;
}

function procesarAlta()
{
  $idProducto = $_POST['id_producto'];
  $idOrden = $_POST['id_orden'];
  $proovedor = $_POST['proovedor'];
  $precioUnidad = $_POST['precio_unidad'];
  $cantidad = $_POST['cantidad'];
  $fecha = $_POST['fecha'];
  $lote = $_POST['lote'];
  $serie = $_POST['serie'];


  $admin = new administradorEntradas();
  $admin->insertaEntrada($idProducto, $idOrden, $proovedor, $precioUnidad, $cantidad, $fecha, $lote, $serie);
  echo "1";
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorEntradas();
  $admin->eliminaEntrada($id);
  echo "1";
}

function procesarVerRegistros()
{
}


function procesarVerUnRegistro()
{
}


switch ($accion) {
  case $casoAgregar:
    procesarAlta();
    break;
  case $casoEliminar:
    procesarBaja();
    break;
  case $casoVerRegistros:
    break;
  case $casoVerUnRegistro:
    break;
}
