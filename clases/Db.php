<?php
require_once "clases/Usuario.php";
require_once "clases/SQLdb.php";

  class Db{

    private static function guardarDb() {

      $fp = fopen("userData.json", "r");

      if ($fp){
        while (($linea = fgets($fp)) !== false) {
          $users[] = json_decode($linea,true);
        }
        return $users;
      }
      fclose($fp);
    }

    public static function migrar($dns, $user, $password){

      $jsonDb = self::guardarDb();

      $SQLdb = new SQLdb($dns, $user, $password);

      $userArray = [];

      foreach($jsonDb as $data){
        $usuario = new Usuario($data["email"],
                    $data["username"],
                    $data["password"],
                    $data["nombre"],
                    $data["apellido"],
                    $data["avatar_url"]);

        $userArray[]=$usuario;
      }

      foreach($userArray as $user){
        $SQLdb->PDO->beginTransaction();

        try {
          $nombre = $user->getNombre();
          $apellido = $user->getApellido();
          $email = $user->getEmail();
          $username = $user->getUsername();
          $password = $user->getPassword();
          $avatar = $user->getAvatar();

          $smt = $SQLdb->PDO->exec("INSERT INTO usuarios (nombre, apellido, email, username, password, avatar)
                                    VALUES ('$nombre','$apellido','$email','$username','$password','$avatar');");
          $SQLdb->PDO->commit();
        }
        catch(PDOException $Exception) {

          $SQLdb->PDO->rollBack();
          echo $Exception->getMessage();
        }
      }
    }

    public static function inicializar($dns, $user, $password){
      $SQLdb = new SQLdb("mysql:host=127.0.0.1", $user, $password);

      $SQLdb->PDO->beginTransaction();

      try {
       $SQLdb->PDO->exec("CREATE SCHEMA IF NOT EXISTS e-commerce;");
       $SQLdb->PDO->commit();
      }
      catch(PDOException $Exception) {

       $SQLdb->PDO->rollBack();
       echo $Exception->getMessage();
      }

      $SQLdb = new SQLdb($dns, $user, $password);

      $SQLdb->PDO->beginTransaction();

      try {
       $SQLdb->PDO->exec("CREATE TABLE IF NOT EXISTS usuarios (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            nombre VARCHAR(40),
                            apellido VARCHAR(40),
                            email VARCHAR(40) NOT NULL,
                            username VARCHAR(30) NOT NULL UNIQUE,
                            password VARCHAR(100) NOT NULL,
                            avatar VARCHAR(300) NOT NULL
                            );");
       $SQLdb->PDO->commit();
      }
      catch(PDOException $Exception) {

       $SQLdb->PDO->rollBack();
       echo $Exception->getMessage();
      }
    }
  }
