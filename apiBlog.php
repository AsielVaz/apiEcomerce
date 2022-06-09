
<?php

include_once('adminBlog.php');

$accion = $_POST['accion'];
$casoAgregarBlog = "agregar-blog";
$casoEliminarBlog = "eliminar-blog";
$casoAgregarParrafo = "agregar-parrafo";
$casoEliminarParrafo = "eliminar-parrafo";
$casoAgregarComentario = "agregar-comentario";
$casoEliminarComentario = "eliminar-comentario";


function procesarImagen()
{

    $carpetaDestino = '/Imagenes/Blog/';
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


function agregarBlog()
{
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];
    $imagen = procesarImagen();
    $admin = new administradorBlog();
    $admin->insertaBlog($titulo, $contenido, $fecha, $usuario, $imagen);
    echo "1";
}

function eliminarBlog()
{
    $id = $_POST['id'];
    $admin = new administradorBlog();
    $admin->eliminaBlog($id);
    echo "1";
}

function agregarParrafo()
{
    $idBlog = $_POST['idBlog'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $tipo = $_POST['tipo'];
    $admin = new administradorBlog();
    $admin->insertaParrafo($idBlog, $titulo, $contenido, $tipo);
    echo "1";
}

function eliminarParrafo()
{
    $id = $_POST['id'];
    $admin = new administradorBlog();
    $admin->eliminaParrafo($id);
    echo "1";
}

function agregarComentario()
{
    $idBlog = $_POST['id-blog'];
    $comentario = $_POST['comentario'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];
    $admin = new administradorBlog();
    $admin->insertaComentario($idBlog, $comentario, $fecha, $usuario);
    echo "1";
}

function eliminarComentario()
{
    $id = $_POST['id'];
    $admin = new administradorBlog();
    $admin->eliminaComentario($id);
    echo "1";
}


switch ($accion) {
    case $casoAgregarBlog:
        agregarBlog();
        break;
    case $casoEliminarBlog:
        eliminarBlog();
        break;
    case $casoAgregarParrafo:
        agregarParrafo();
        break;
    case $casoEliminarParrafo:
        eliminarParrafo();
        break;
    case $casoAgregarComentario:
        agregarComentario();
        break;
    case $casoEliminarComentario:
        eliminarComentario();
        break;
    default:
        echo json_encode("Accion no reconocida");
        break;
}
