<?php

  class SQLdb{


    public $PDO;
    const OPT = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    public function __construct($dns, $user, $password){
      $this->PDO = new PDO($dns, $user, $password, self::OPT);
    }

    public function buscarUsuario($usuario){

      try {
       $query = $this->PDO->query("SELECT * FROM usuarios WHERE username = '$usuario'");
       $results = $query->fetchAll(PDO::FETCH_ASSOC);
      }catch( PDOException $Exception ) {
       echo $Exception->getMessage();
      }
      return $results[0];

    }

  }

 ?>
