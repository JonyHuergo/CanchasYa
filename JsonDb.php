<?php

class JsonDb{

  static function usuarioNuevo() {
    return [
      "nombre" => null,
      "apellido" => null,
      "email" => null,
      "avatar_url" => "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
    ];
  }

  static function crearUsuario($usuario) {
    // hashear el password del usuario
    $usuario["contrasena"] = password_hash($usuario["contrasena"], PASSWORD_BCRYPT);

    // detectar si se ha subido un avatar y generar la URL
    if (is_array($usuario["avatar_url"])) {;

      $nombre = $usuario["avatar_url"]["name"];
      $archivo = $usuario["avatar_url"]["tmp_name"];
      $ext = pathinfo($nombre, PATHINFO_EXTENSION);

      $miArchivo = dirname(__FILE__);
      $miArchivo = $miArchivo . "/avatars/";
      $miArchivo = $miArchivo . $usuario["username"] . "_profile" .  $ext;

      $movido = move_uploaded_file($archivo, $miArchivo);;

      $usuario["avatar_url"] = $miArchivo;
    }
    // transformar el usuario a json

    $jsonUser = json_encode($usuario);
    // escribir el json en el archivo
    $fp = fopen("userData.json", "a+");
    $bytesEscritos = fwrite($fp, $jsonUser . PHP_EOL);
    fclose($fp);

    return $bytesEscritos;
  }

  /**
  * Esta funcion busca un usuario, en caso de existir retorna un
  * array asociativo con los datos del usuario, en caso de no existir
  * devuelve el valor false.
  */
  static public function buscarUsuario($username) {

    $fp = fopen("userData.json", "r");

    if ($fp){
      while (($linea = fgets($fp)) !== false) {
        $user = json_decode($linea,true);
        if($user["username"] == $username) {
          return $user;
        }
      }
      return false;
    }
    fclose($fp);

  }

}

?>
