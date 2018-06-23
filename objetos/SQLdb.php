<?php

  class SQLdb extends Db{


    private $PDO:
    const OPT = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    public function __construct($dns, $user, $password){
      $this->PDO = new PDO($dns, $user, $password, self::OPT);
    }

  }

 ?>
