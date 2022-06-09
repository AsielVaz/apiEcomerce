<?php
include_once('adminSalidas.php');
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
  $cantidad = $_POST['cantidad'];



  $admin = new administradorSalidas();
  $admin->insertaSalida($idProducto, $idOrden, $cantidad);
  echo "1";
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorSalidas();
  $admin->eliminaSalida($id);
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
