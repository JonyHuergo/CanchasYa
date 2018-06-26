<?php

  class Usuario{

    private $nombre;
    private $apellido;
    private $email;
    private $username;
    private $password;
    private $avatar;

    public function __construct($email, $username, $password, $nombre = null, $apellido = null, $avatar = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"){

      $this->email = $email;
      $this->username = $username;
      $this->password = password_hash($password, PASSWORD_BCRYPT);
      $this->nombre = $nombre;
      $this->apellido = $apellido;
      if(is_null($avatar)){
        $this->avatar = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
      } else{
        $this->avatar = $avatar;
      }


    }

    //SETTERS

    public function setNombre($nombre){
      $this->nombre = $nombre;
    }

    public function setApellido($apellido){
      $this->apellido = $apellido;
    }

    public function setEmail($email){
      $this->email = $email;
    }

    public function setUsername($username){
      $this->username = $username;
    }

    public function setAvatar($avatar){
      $this->avatar = $avatar;
    }

    //GETTERS

    public function getNombre(){
      return $this->nombre;
    }

    public function getApellido(){
      return $this->apellido;
    }

    public function getEmail(){
      return $this->email;
    }

    public function getUsername(){
      return $this->username;
    }

    public function getPassword(){
      return $this->password;
    }

    public function getAvatar(){
      return $this->avatar;
    }
  }
 ?>
