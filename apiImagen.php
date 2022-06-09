<?php


$id_proyecto = $_POST['id'];
$carpetaDestino = '/Empleados/Imagenes/';
$nombreGenericoImagen = "_imagen";
$nombreRegistroVersionAntigua = "_Old";
$pesoMaxicoImagen = 2000000;
$nombreCompuestoImagen = "default.txt";
$nombre_imagen = $_FILES['archivo']['name'];
$tipo_Imgaen = $_FILES['archivo']['type'];
$tamanio_imagen = $_FILES['archivo']['size'];

$casoPng = ".png";
$casoJpeg = ".jpg";


if (($operacion == $casoActualizar || $operacion == $casoAgregar) & $tamanio_imagen != 0) {
   //comprovadores de peso y tipo de imagen

   if ($tamanio_imagen < $pesoMaxicoImagen) {
      if ($tipo_Imgaen == "image/jpeg" || $tipo_Imgaen == "image/png") {
         //mueve la imagen a la carpeta seleccionada 
         move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $carpetaDestino . $nombre_imagen);
         chmod($carpetaDestino . $nombre_imagen, 0777);
         switch ($tipo_Imgaen) {
            case "image/jpeg":
               $nombreCompuestoImagen = $carpetaDestino . $id_proyecto . "Galeria" . random_int(0, 40000) . $nombreGenericoImagen . $casoJpeg;
               break;
            case "image/png":
               $nombreCompuestoImagen = $carpetaDestino . $id_proyecto . "Galeria" . random_int(0, 40000) . $nombreGenericoImagen . $casoPng;
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

if (!$conn) {
   die("No se pudo conectar devido a: " . mysqli_connect_error());
}
