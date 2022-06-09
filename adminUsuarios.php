<?php

include_once('conectorBD.php');
class Usuario
{
  public $nombre;
  public $id;
  public $apellidoPaterno;
  public $apellidoMaterno;
  public $email;
  public $constrasena;
  public $telefono;
  public $calle;
  public $ciudad;
  public $pais;
  public $direccion;
  public $tipoUsuario;
  public $imagen;

  public function __construct()
  {
    $this->id = 0;
  }
}


class administradorUsuarios extends conector
{
  public function insertaUsuario($nombre, $apellidoPaterno, $apellidoMaterno, $email, $constrasena, $telefono, $calle, $ciudad, $pais, $direccion)
  {
    $sql = 'INSERT INTO usuario (nombre,apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario) 
    values ("' . $nombre . '","' . $apellidoPaterno . '","' . $apellidoMaterno . '","' . $email . '","' . sha1($constrasena) . '","' . $telefono . '","' . $calle . '","' . $ciudad . '","' . $pais . '","' . $direccion . '" , 0);';
    $this->ejecutar($sql);
  }
  public function dameUsuario($email, $pass)
  {
    $usuario = new Usuario();
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen
    FROM usuario 
    WHERE email = "' . $email . '" and contrasena ="' . sha1($pass) . '";';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $usuario->id = $row['id'];
        $usuario->imagen = $row['imagen'];
        $usuario->nombre = $row['nombre'];
        $usuario->apellidoPaterno = $row['apellido_paterno'];
        $usuario->apellidoMaterno = $row['apellido_materno'];
        $usuario->email = $row['email'];
        $usuario->constrasena = $row['contrasena'];
        $usuario->telefono = $row['telefono'];
        $usuario->calle = $row['calle'];
        $usuario->ciudad = $row['ciudad'];
        $usuario->pais = $row['pais'];
        $usuario->direccion = $row['direccion'];
        $usuario->tipoUsuario = $row['tipo_usuario'];
      }
      return $usuario;
    } else {
      return $usuario;
    }

    //print_r(json_encode($arregloProductos));
    return $usuario;
  }
  public function dameUsuarioId($id)
  {
    $usuario = new Usuario();
    $sql = 'SELECT id, nombre, apellido_paterno, apellido_materno, email, contrasena, telefono, calle, ciudad, pais, direccion, tipo_usuario, imagen
    FROM usuario 
    WHERE id = ' . $id . ';';
    $result = $this->ejecutar($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $usuario->id = $row['id'];
        $usuario->nombre = $row['nombre'];
        $usuario->imagen = $row['imagen'];
        $usuario->apellidoPaterno = $row['apellido_paterno'];
        $usuario->apellidoMaterno = $row['apellido_materno'];
        $usuario->email = $row['email'];
        $usuario->constrasena = $row['contrasena'];
        $usuario->telefono = $row['telefono'];
        $usuario->calle = $row['calle'];
        $usuario->ciudad = $row['ciudad'];
        $usuario->pais = $row['pais'];
        $usuario->direccion = $row['direccion'];
        $usuario->tipoUsuario = $row['tipo_usuario'];
      }
      return $usuario;
    } else {
      return $usuario;
    }

    //print_r(json_encode($arregloProductos));
    return $usuario;
  }
  public function eliminaUsuario($id)
  {
    $sql = 'DELETE FROM usuario WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }
  function dameUsuarios()
  {
  }

  function actualizarUsuario($id, $nombre, $apellidoPaterno, $apellidoMaterno, $email, $contrasena, $telefono, $calle, $ciudad, $pais, $direccion)
  {

    $sql = 'UPDATE usuario SET nombre = "' . $nombre . '", apellido_paterno = "' . $apellidoPaterno . '", apellido_materno = "' . $apellidoMaterno . '", email = "' . $email . '", contrasena = "' . sha1($contrasena) . '"  WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function actualizarDireccion($id, $calle, $ciudad, $pais, $direccion)
  {

    $sql = 'UPDATE usuario SET calle = "' . $calle . '", ciudad = "' . $ciudad . '", pais = "' . $pais . '", direccion = "' . $direccion . '" WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  function asignarImagen($id, $imagen)
  {
    $sql = 'UPDATE usuario SET imagen = "' . $imagen . '" WHERE id = ' . $id . ';';
    $this->ejecutar($sql);
  }

  public function modificaProducto()
  {
  }
}
