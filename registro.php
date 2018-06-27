<?php

 session_start();
 if(isset($_SESSION["registrado"])){
   header("Location: paginaPrincipal.php");
 }

require_once "clases/FormularioRegistro.php";
require_once "clases/Validador.php";
require_once "clases/JsonDb.php";
require_once "clases/SQLdb.php";
require_once "clases/Db.php";

$dns ='mysql:host=127.0.0.1;dbname=ecommerce;port=3306';
$db_user = 'root';
$db_pass = 'root';

//Booleano para definir si se utiliza SQL o JSON para guardar los datos
$SQL = true;

if($SQL){
  Db::inicializar($dns,$db_user,$db_pass);
  $SQLdb = new SQLdb($dns,$db_user,$db_pass);
} else {
  $user = JsonDb::usuarioNuevo();
}

$errores = [];

// Validar si se completo o no el formulario
if ($_POST) {

  $errores=FormularioRegistro::validar($_POST,$_FILES);


  if (! Validador::huboErrores($errores)) {

    if(!$SQL){

      if (JsonDb::crearUsuario($user)) {
        header("Location: paginaPrincipal.php");
      } else {
        exit("Ha ocurrido un error inesperado");
      }

    } else {

      $usuario = new Usuario($_POST["email"],$_POST["username"],$_POST["password"],$_POST["nombre"],$_POST["apellido"],$_POST["avatar_url"]);

      $nombre = $usuario->getNombre();
      $apellido = $usuario->getApellido();
      $email = $usuario->getEmail();
      $username = $usuario->getUsername();
      $password = $usuario->getPassword();
      $avatar = $usuario->getAvatar();

      $SQLdb->PDO->beginTransaction();

      try {
       $smt = $SQLdb->PDO->exec("INSERT INTO usuarios (nombre, apellido, email, username, password, avatar)
                                 VALUES ('$nombre','$apellido','$email','$username','$password','$avatar');");
       $SQLdb->PDO->commit();
      }
      catch(PDOException $Exception) {

       $SQLdb->PDO->rollBack();
       echo $Exception->getMessage();
      }
      header("Location: paginaPrincipal.php");
    }

  }
}
?>

<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <title>Registrarse</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="imagenes/logo_chico.png" />

  <link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=ABeeZee|Open+Sans|Righteous" rel="stylesheet">

  <link rel="stylesheet" href="css/registroStyle.css">
</head>

<body>

  <div class="container">
    <div class="logo"><img src="imagenes/logo2.png"></div>
  </div>

  <nav class="sticky-top">
    <ul class="menu text-center">
      <li><a href="paginaPrincipal.php">Principal</a></li><li><a href="preguntas.php">Preguntas</a></li><li class="active"><a href="registro.php">Registrarse</a></li><li><a href="ingresar.php">Ingresar</a></li>
    </ul>
  </nav>

  <main>
    <div class="banner">
      <br>

      <div class="area">

        <form role="form" action="registro.php" method="post" enctype="multipart/form-data">

          <?php if (Validador::huboErrores($errores)) : ?>
            <div id="errores" class="alert alert-danger">
              <ul>
                <?php foreach($errores as $bolsaDeErrores) : ?>
                  <?php foreach($bolsaDeErrores as $error) : ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <div>
            <label for="nombre">Nombre</label>
            <br/>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : ""; ?>" placeholder="Ingrese Nombre">
            <br/>
          </div>

          <div>
            <label for="apellido">Apellido</label>
            <br/>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= isset($_POST['apellido']) ? $_POST['apellido'] : ""; ?>" placeholder="Ingrese Apellido">
            <br/>
          </div>

          <div>
            <label for="username">Nombre de Usuario</label>
            <br/>
            <input type="text" class="form-control" id="username" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ""; ?>" placeholder="Ingrese Nombre de Usuario">
            <br/>
          </div>

          <div>
            <label for="email">Email</label>
            <br/>
            <input type="text" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ""; ?>" placeholder="Ingrese Email">
            <br/>
          </div>

          <div>
            <label for="email-confirm">Confirmar Email</label>
            <br/>
            <input type="text" class="form-control" id="email-confirm" name="email_confirm" value="" placeholder="Ingrese Confirmación Email">
            <br/>
          </div>

          <div>
            <label for="password">Contraseña</label>
            <br/>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese Contraseña">
            <br/>
          </div>

          <div>
            <label for="password-confirm">Confirmar Contraseña</label>
            <br/>
            <input type="password" class="form-control" id="password-confirm" name="password_confirm" placeholder="Ingrese Confirmación Contraseña">
            <br/>
          </div>

          <div class="form">
            <label>Avatar</label>
            <br/>
            <input type="file" name="avatar"/>
            <br/>
          </div>

          <div class="form">
            <label> Fecha de Nacimiento</label>
            <br/>
            <input type="date" name="fechaNacimiento">
            <br/>
          </div>

          <input class="boton pull-right" type="submit" name="botonSubmit" value="Registrarme"/>
        </form>
      </div>


    </div>

    <footer class="footer-general">
      <div>
        <ul>
          <li><a href="https://www.instagram.com/?hl=es-la" target="blank"><div class="footer-icons"><i class="fa fa-instagram fa-2x"></i></div></a></li>
          <li><a href="https://twitter.com/?lang=es/" target="blank"><div class="footer-icons"><i class="fa fa-twitter fa-2x"></i></div></a></li>
          <li><a href="https://es-la.facebook.com/" target="blank"><div class="footer-icons"><i class="fa fa-facebook fa-2x"></i></div></a></li>
        </ul>
      </div>
    </footer>

  </main>

</body>
</html>
