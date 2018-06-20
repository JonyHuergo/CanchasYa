<?php
  session_start();
  if(isset($_SESSION["registrado"])){
    header("Location: paginaPrincipal.html");
    }
  // require_once "funciones/validaciones.php";
  require_once "objetos/validaciones.php";
  require_once "funciones/funcionesUsuarios.php";

  $errores = [
      "username" => [],
      "email" => [],
      "password" => []
  ];

  $user = usuarioNuevo();

  // Validar si se completo o no el formulario
  if ($_POST) {

      $erroresEnNombreDeUsuario = Validaciones::validarNombreDeUsuario($_POST["username"]);

  if (empty($erroresEnNombreDeUsuario)) {
    $user["username"] = $_POST["username"];
  } else {
    $errores["username"] = $erroresEnNombreDeUsuario;
  }



//Validar password
  $erroresEnPassword = Validaciones::validarPassword($_POST["contrasena"], $_POST["contrasena_confirm"]);

  if (empty($erroresEnPassword)) {
    $user["contrasena"] = $_POST["contrasena"];
  } else {
    $errores["contrasena"] = $erroresEnPassword;
  }

//Validar  email
  $erroresEnMail = Validaciones::validarEmail($_POST["email"], $_POST["email_confirm"]);

  if (empty($erroresEnMail)) {
    $user["email"] = $_POST["email"];
  } else {
    $errores["email"] = $erroresEnMail;
  }

  if (isset($_FILES["avatar"]) && Validaciones::validarAvatar($_FILES["avatar"])) {
    $user["avatar_url"] = $_FILES["avatar"];
  }

      if (! Validaciones::huboErrores($errores)) {
          if ($bytes=crearUsuario($user)) {
      header("Location: paginaPrincipal.html");
    } else {
      exit("Ha ocurrido un error inesperado");
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
            <li><a href="paginaPrincipal.html">Principal</a></li><li><a href="preguntas.html">Preguntas</a></li><li class="active"><a href="registro.php">Registrarse</a></li><li><a href="ingresar.php">Ingresar</a></li>
          </ul>
    </nav>

    <main>
      <div class="banner">
      <br>

      <div class="area">

          <form role="form" action="registro.php" method="post" enctype="multipart/form-data">

                <?php if (Validaciones::huboErrores($errores)) : ?>
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
            <label for="contrasena">Contraseña</label>
            <br/>
            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese Contraseña">
            <br/>
            </div>

            <div>
            <label for="contrasena-confirm">Confirmar Contraseña</label>
            <br/>
            <input type="password" class="form-control" id="contrasena-confirm" name="contrasena_confirm" placeholder="Ingrese Confirmación Contraseña">
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
