<?php

  class Validaciones{


//validar si hubo errores
static public function huboErrores($arrayDeErrores){
  foreach ($arrayDeErrores as $errores) {
      if (! empty($errores)) {
          return true;
      }
  }

  return false;
}

//validando $nombreDeUsuario

static public function validarNombreDeUsuario($nombreDeUsuario) {

    $errores = [];

    // Validar si se ingreso o no un nombre usuario
    if (! isset($nombreDeUsuario)) {
        $errores[] = "Por favor complete el campo username";
    }
    // Validar que el nombre de usuario sea alfanumerico y de longitud minima 5
    if (! ctype_alnum($nombreDeUsuario)) {
        $errores[] = "El username debe ser alfanumerico";
    }

    if (strlen($nombreDeUsuario) < 5) {
        $errores[] = "La longitud del username debe ser mayor o igual a 5 caracteres";
    }

    return $errores;
}
//validando e-mail

static public function validarEmail($email, $confirmacion) {

    $errores = [];

    // Validar si se ingreso o no un mail
    if (! isset($email)) {
        $errores[] = "Por favor complete el campo e-mail";
    }

    // Validar que el mail ingresado sea valido
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El mail ingresado no es valido";
    }

    // Validar que el mail y la confirmacion coincidan
    if ($email != $confirmacion) {
        $errores[] = "Los mails ingresados son distintos";
    }

    return $errores;
}

//validando $password

static public function validarPassword($password, $confirmacion) {

    $errores = [];

    // Validar si se ingreso o no un password
    if (! isset($password)) {
        $errores[] = "Por favor complete el campo contraseña";
    }
    // Validar que el password tenga longitud minima 5
    if (strlen($password) < 5) {
        $errores[] = "La longitud del contraseña debe ser mayor o igual a 5 caracteres";
    }
    // Validar que la confirmacion del password coincida
    if ($password != $confirmacion) {
        $errores[] = "Las contraseñas ingresadas son distintas";
    }

    return $errores;
}

static public function validarAvatar($file) {
    if($file["error"] === UPLOAD_ERR_OK) {
        $nombre = $file["name"];
        $ext = pathinfo($nombre, PATHINFO_EXTENSION);
        if ($ext == "jpg") {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
  }
 ?>
