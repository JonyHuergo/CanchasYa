<?php
require_once "clases/JsonDb.php";
require_once "clases/SQLdb.php";


  class FormularioIngresar{

    static public function validar($data,$SQL,$dns = null, $db_user = null, $db_pass = null){

      $errores = [
        "usuario" => "",
        "password" => ""
      ];

      if (!$data["usuario"]){
        $errores["usuario"] = "El usuario debe ser completado";
      }
      if (!$data["contraseña"]){
        $errores ["password"] = "La contraseña debe ser completada";
      }
      if ($data["usuario"] && $data["contraseña"]){
        if($SQL){
          $SQLdb = new SQLdb($dns, $db_user, $db_pass);
          $usuario = $SQLdb->buscarUsuario($data["usuario"]);
        } else{
          $usuario = JsonDb::buscarUsuario($data["usuario"]);
        }

       if ($usuario) {
        $passwordValidado = password_verify($data["contraseña"], $usuario["password"]);
        if ($passwordValidado) {
          $_SESSION["registrado"]=true;
          $_SESSION["usuario"]=$data["usuario"];
          header("Location: bienvenido.php");
          die();
        } else {
          $errores ["password"] = "Contraseña incorrecta";
        }
      } else {
        $errores ["usuario"] = "El usuario introducido no está registrado";
      }
    }
    return $errores;
    }

  }

?>
