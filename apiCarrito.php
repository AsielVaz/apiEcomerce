<?php
include_once('adminCarrito.php');
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
  $cantidad = $_POST['cantidad'];
  $status = $_POST['status'];
  $fecha = $_POST['fecha'];
  $idUsuario = $_POST['id_usuario'];
  $admin = new administradorCarrito();
  $admin->insertaCarrito($idUsuario, $idProducto, $fecha, $status, $cantidad);
  echo "1";
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorCarrito();
  $admin->eliminaCarrito($id);
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
