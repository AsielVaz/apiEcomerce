<?php

include_once('adminCategorias.php');
$accion = $_POST['accion'];
$casoAgregar = "agregar";
$casoEliminar = "eliminar";
$casoModificar = "modificar";
$casoVerRegistros = "ver";
$casoVerUnRegistro  = "verUno";




function procesarImagen()
{

  $carpetaDestino = '/Imagenes/Categorias/';
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
  $imagen = procesarImagen();
  $categoria = $_POST['categoria'];
  $animal = $_POST['animal'];
  $tipo = $_POST['tipo'];
  $admin = new administradorCategorias();
  $admin->insertaCategoria($imagen, $categoria, $animal, $tipo);
  echo "1";
}

function procesarBaja()
{
  $id = $_POST['id'];
  $admin = new administradorCategorias();
  $admin->eliminaCategoria($id);
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
    procesarVerRegistros();
    break;
  case $casoVerUnRegistro:
    procesarVerUnRegistro();
    break;
}
