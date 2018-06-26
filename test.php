<?php
require_once "clases/Usuario.php";
require_once "clases/SQLdb.php";

$usuario = new Usuario("hola@mail.com","username",12345,"Nombre","Apellido","Avatar");

var_dump($usuario);
