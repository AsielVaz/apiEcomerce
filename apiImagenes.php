<?php
include_once("adminImagenes.php");
$accion = $_POST['accion'];
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoVerUnRegistro  = "verUno";




function procesarImagen()
{

  $carpetaDestino = '/Imagenes/Productos/ImagenDeProducto/';
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
          $nombreCompuestoImagen = $carpetaDestino . "ImagenProducto" . rand(0, 40000) . $casoJpeg;
          break;
        case "image/png":
          $nombreCompuestoImagen = $carpetaDestino . "ImagenProducto" . rand(0, 40000) .  $casoPng;
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
  $idProducto = $_POST['id_producto'];
  $url = procesarImagen();
  $admin = new administradorImagenes();
  $admin->insertaImagen($idProducto, $url);
  echo "1";
}

function procesarBaja()
{
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
    break;
  case $casoVerRegistros:
    break;
  case $casoVerUnRegistro:
    break;
}
