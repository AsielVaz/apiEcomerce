<?php
include_once('adminProductos.php');


$accion = $_POST['accion'];
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoVerUnRegistro  = "verUno";
$casoAgregarOferta  = "oferta";
$casoEliminarOferta  = "eliminar-oferta";





function procesarImagen()
{

  $carpetaDestino = '/Imagenes/Productos/';
  $pesoMaxicoImagen = 2000000;
  $nombreCompuestoImagen = "default.txt";
  $nombre_imagen = $_FILES['archivo']['name'];
  $tipo_Imgaen = $_FILES['archivo']['type'];
  $tamanio_imagen = $_FILES['archivo']['size'];

  $casoPng = ".png";
  $casoJpeg = ".jpg";
  //comprovadores de peso y tipo de imagen

  if ($tamanio_imagen < $pesoMaxicoImagen) {
    if ($tipo_Imgaen == "image/jpeg" || $tipo_Imgaen == "image/png") {
      //mueve la imagen a la carpeta seleccionada 
      move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);
      chmod($carpetaDestino . $nombre_imagen, 0777);
      switch ($tipo_Imgaen) {
        case "image/jpeg":
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) . $casoJpeg;
          break;
        case "image/png":
          $nombreCompuestoImagen = $carpetaDestino . "Imagen" . rand(0, 40000) .  $casoPng;
          break;
      }
      rename($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen, $_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen);
      chmod($_SERVER['DOCUMENT_ROOT'] . $nombreCompuestoImagen, 0777);
      unlink($_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);

      return $nombreCompuestoImagen;
    } else {
      echo json_encode("El formato de la imagen no esta permitido");
    }
  } else {
    echo json_encode("La imagen supera el tamaño establecido");
  }
}

function procesarAlta()
{
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $imagen = procesarImagen();
  $pesoCantidad = $_POST['peso_cantidad'];
  $descripcion = $_POST['descripcion'];
  $categoria = $_POST['categoria'];
  $fechaCreacion = $_POST['fecha'];

  $admin = new administradorProductos();
  $admin->insertaProducto($nombre, $precio, $imagen, $descripcion, $categoria, $fechaCreacion, $pesoCantidad);
  echo "1";
}
function procesarAltaOferta()
{
  $producto = $_POST['producto'];
  $descuento = $_POST['descuento'];
  $admin = new administradorProductos();
  $admin->insertaOferta($producto, $descuento);
  echo "1";
}
function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorProductos();
  $admin->eliminaProducto($id);
  echo "1";
}
function procesarBajaOferta()
{
  $id = $_POST['id'];
  $admin = new administradorProductos();
  $admin->eliminaOferta($id);
  echo "1";
}
function procesarVerRegistros()
{
}

function procesarVerUnRegistro()
{
  $id = $_POST['id'];
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
  case $casoAgregarOferta:
    procesarAltaOferta();
    break;
  case $casoEliminarOferta:
    procesarBajaOferta();
    break;
}
