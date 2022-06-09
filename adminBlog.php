<?php

include_once('conectorBD.php');
include_once("adminUsuarios.php");
include_once("estilizarFecha.php");

class Blog
{
  public $id;
  public $titulo;
  public $contenido;
  public $fecha;
  public $usuario;
  public $imagen;

  public function __construct()
  {
    $this->id = 0;
  }
}

class Parrafo
{
  public $id;
  public $idBlog;
  public $titulo;
  public $contenido;
  public $tipo;

  public function __construct()
  {
    $this->id = 0;
  }
}

class Comentario
{
  public $id;
  public $idBlog;
  public $contenido;
  public $fecha;
  public $usuario;

  public function __construct()
  {
    $this->id = 0;
  }
}


class administradorBlog extends conector
{
  public function insertaBlog($titulo, $contenido, $fecha, $usuario, $imagen)
  {
    $sql = 'INSERT INTO blog (titulo,contenido,fecha,id_usuario,imagen) 
    VALUES ("' . $titulo . '", "' . $contenido . '","' . $fecha . '",' . $usuario . ',"' . $imagen . '");';
    $this->ejecutar($sql);
  }

  public function eliminaBlog($id)
  {
    $sql = "DELETE FROM blog WHERE id = $id";
    $this->ejecutar($sql);
  }
  public function insertaParrafo($blog, $titulo, $contenido, $tipo)
  {
    $sql = 'INSERT INTO parrafo_blog (id_blog,titulo,contenido,tipo) 
    VALUES (' . $blog . ', "' . $titulo . '","' . $contenido . '",' . $tipo . ');';
    $this->ejecutar($sql);
  }

  public function eliminaParrafo($id)
  {
    $sql = "DELETE FROM parrafo_blog WHERE id = $id";
    $this->ejecutar($sql);
  }

  public function insertaComentario($blog, $comentario, $fecha, $usuario)
  {
    $sql = 'INSERT INTO comentario_blog (id_blog,comentario,fecha,id_usuario) 
    VALUES (' . $blog . ', "' . $comentario . '","' . $fecha . '",' . $usuario . ');';
    $this->ejecutar($sql);
  }
  public function eliminaComentario($id)
  {
    $sql = "DELETE FROM comentario_blog WHERE id = $id";
    $this->ejecutar($sql);
  }


  public function dameBlog($id)
  {

    $blog = new Blog();
    $adminUser = new administradorUsuarios();
    $sql = "SELECT * FROM blog WHERE id = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $blog->id = $row['id'];
      $blog->usuario = $adminUser->dameUsuarioId($row['id_usuario']);
      $blog->titulo = $row['titulo'];
      $blog->contenido = $row['contenido'];
      $blog->fecha = estilizarFecha($row['fecha']);
      $blog->imagen = $row['imagen'];
    }
    //print_r(json_encode($arregloProductos));
    return $blog;
  }

  public function dameBlogs()
  {
    $adminUser = new administradorUsuarios();
    $arregloBlogs = array();
    $sql = "SELECT * FROM blog;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $blog = new Blog();
      $blog->id = $row['id'];
      $blog->usuario = $adminUser->dameUsuarioId($row['id_usuario']);
      $blog->titulo = $row['titulo'];
      $blog->contenido = $row['contenido'];
      $blog->fecha = estilizarFecha($row['fecha']);
      $blog->imagen = $row['imagen'];
      $arregloBlogs[] = $blog;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloBlogs;
  }



  public function dameUltimosTresBlogs()
  {
    $sql = "SELECT * FROM blog ORDER BY id DESC LIMIT 3;";
    $result = $this->ejecutar($sql);
    $arregloBlogs = array();
    while ($row = $result->fetch_assoc()) {
      $blog = new Blog();
      $blog->id = $row['id'];
      $blog->imagen = $row['imagen'];
      $blog->titulo = $row['titulo'];
      $blog->fecha = estilizarFecha($row['fecha']);
      $arregloBlogs[] = $blog;
    }
    return $arregloBlogs;
  }

  public function buscaBlogs($busqueda)
  {
    $sql = 'SELECT * FROM blog WHERE titulo LIKE "%' . $busqueda . '%" OR contenido LIKE "%' . $busqueda . '%";';
    $result = $this->ejecutar($sql);
    $arregloBlogs = array();
    while ($row = $result->fetch_assoc()) {
      $blog = new Blog();
      $blog->id = $row['id'];
      $blog->imagen = $row['imagen'];
      $blog->titulo = $row['titulo'];
      $blog->fecha = estilizarFecha($row['fecha']);
      $arregloBlogs[] = $blog;
    }
    return $arregloBlogs;
  }

  public function dameParrafos($idBlog)
  {

    $arregloParrafos = array();
    $sql = "SELECT * FROM parrafo_blog WHERE id_blog = $idBlog;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $parrafo = new Parrafo();
      $parrafo->id = $row['id'];
      $parrafo->idBlog = $row['id_usuario'];
      $parrafo->titulo = $row['titulo'];
      $parrafo->contenido = $row['comentario'];
      $parrafo->tipo = $row['fecha'];

      $arregloParrafos[] = $parrafo;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloParrafos;
  }
  public function dameComentarios($idBlog)
  {
    $adminUser = new administradorUsuarios();
    $arregloComentarios = array();
    $sql = "SELECT * FROM comentario_blog WHERE id_blog = $idBlog;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $comentario = new Comentario();
      $comentario->id = $row['id'];
      $comentario->usuario = $adminUser->dameUsuarioId($row['id_usuario']);
      $comentario->contenido = $row['comentario'];
      $comentario->fecha = $row['fecha'];

      $arregloComentarios[] = $comentario;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloComentarios;
  }

  public function dameComentariosVistaPrevia($idBlog)
  {
    $adminUser = new administradorUsuarios();
    $arregloParrafos = array();
    $sql = "SELECT * FROM comentario_blog WHERE id_blog = $idBlog LIMIT 0, 10 ;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $parrafo = new Parrafo();
      $parrafo->id = $row['id'];
      $parrafo->usuario = $adminUser->dameUsuarioId($row['id_usuario']);
      $parrafo->titulo = $row['titulo'];
      $parrafo->contenido = $row['contenido'];
      $parrafo->tipo = $row['fecha'];

      $arregloParrafos[] = $parrafo;
    }
    //print_r(json_encode($arregloProductos));
    return $arregloParrafos;
  }
}
