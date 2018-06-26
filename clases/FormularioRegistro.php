<?php

require_once "clases/Validador.php";

  class FormularioRegistro{

    static public function validar($usuario,$files){
      $errores = [
        "username" => [],
        "email" => [],
        "password" => []
     ];

     if(isset($usuario["nombre"])){
       $user["nombre"] = $usuario["nombre"];
     }
     if(isset($usuario["apellido"])){
       $user["apellido"] = $usuario["apellido"];
     }
     $erroresEnNombreDeUsuario = Validador::validarNombreDeUsuario($usuario["username"]);
     if (empty($erroresEnNombreDeUsuario)) {
       $user["username"] = $usuario["username"];
     } else {
       $errores["username"] = $erroresEnNombreDeUsuario;
     }
     //Validar password
     $erroresEnPassword = Validador::validarPassword($usuario["password"], $usuario["password_confirm"]);
     if (empty($erroresEnPassword)) {
       $user["password"] = $usuario["password"];
     } else {
       $errores["password"] = $erroresEnPassword;
     }
     //Validar  email
     $erroresEnMail = Validador::validarEmail($usuario["email"], $usuario["email_confirm"]);
     if (empty($erroresEnMail)) {
       $user["email"] = $usuario["email"];
     } else {
       $errores["email"] = $erroresEnMail;
     }
     if (isset($files["avatar"]) && Validador::validarAvatar($files["avatar"])) {
       $user["avatar_url"] = $files["avatar"];
     }

     return $errores;
    }

  }

 ?>
