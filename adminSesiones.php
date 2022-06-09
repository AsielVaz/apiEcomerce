<?php

session_start();
$_SESSION['sesionUsuario'] = array();
$_SESSION['sesionUsuario']['id'] = intval($_POST['id']);
$_SESSION['sesionUsuario']['permisos'] = intval($_POST['permiso']);
echo "1";
