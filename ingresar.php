<?php

    session_start();
    if(isset($_SESSION["registrado"])){
    header("Location: paginaPrincipal.php");
    }
    require_once "clases/FormularioIngresar.php";
    require_once "clases/JsonDb.php";
    require_once "clases/SQLdb.php";
    require_once "clases/Db.php";

    $dns ='mysql:host=127.0.0.1;dbname=ecommerce;port=3306';
    $db_user = 'root';
    $db_pass = 'root';

    //Booleano para definir si se utiliza SQL o JSON para guardar los datos
    $SQL = true;

    $errores = [];

    if ($_POST) {

    $errores = FormularioIngresar::validar($_POST,$SQL,$dns, $db_user, $db_pass);

    if(isset($_POST["recordarme"])){
        setcookie("usuario", $_POST["usuario"], time()+3600*24*7);
        setcookie("password", $_POST["contraseña"], time()+3600*24*7);
      } else if (!isset($_POST["recordarme"])) {
            if($_COOKIE){
                setcookie("usuario", $_POST["usuario"], time()-3600*24*7);
                setcookie("password", $_POST["contraseña"], time()-3600*24*7);
            }
      }
    }
?>
<!DOCTYPE html>
  <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ingresar</title>
        <link rel="shortcut icon" href="imagenes/logo_chico.png" />
        <link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=ABeeZee|Open+Sans|Righteous" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/ingresarStyle.css">
    </head>
    <body>
        <div class="contenedor">
              <div class="container">
                <div class="logo"><img src="imagenes/logo2.png"></div>
              </div>
              <nav class="sticky-top">
                  <div>
                    <ul class="menu text-center">
                      <li><a href="paginaPrincipal.php">Principal</a></li><li><a href="preguntas.php">Preguntas </a></li><li><a href="registro.php">Registrarse</a></li><li class="active"><a href="ingresar.php">Ingresar</a></li>
                    </ul>
                </div>
              </nav>
            <main>
                <section>
                    <div class="text-center">
                        <h1>Ingresa</h1>
                        <form class="row" action="#" method="post">
                            <input type='hidden' name='submitted' id='submitted' value='1' />
                            <span>
                            <label class="col-xl-6">Nombre de Usuario</label>
                            <input class="col-xl-6 form-control" type="text" name="usuario" id='username' value="<?php if(isset($_COOKIE["usuario"])){ echo $_COOKIE["usuario"];} else if($_POST){ if(!$errores["usuario"]){ echo $_POST["usuario"];}}?>"
                             placeholder = "<?php  if($_POST){if(isset($errores)){if($errores["usuario"]){ echo($errores["usuario"]); } else {echo ""; }}} ?>">
                             <span style="color: red"  class='error'>
                                          <?php
                                              if (isset($errores['username'])) {
                                                  echo "El username ingresado no es valido";
                                              }
                                          ?>
                             </span>
                            </span>
                            <span>
                            <label for="password" class="col-xl-6">Contraseña</label>
                            <input class="col-xl-6 form-control" type="password" name="contraseña" value="<?php if(isset($_COOKIE["password"])){ echo $_COOKIE["password"];}?>"
                            id='password' maxlength="50"
                            placeholder = "<?php if($_POST){if(isset($errores)){if($errores["password"]) { echo($errores["password"]); } else {echo ""; }}}?>">
                            </span>
                            <section class="col-xl-6">
                                <label for="recordarme">Recordarme</label>
                                <input class="recordarme" type="checkbox" name="recordarme" value="1">
                            </section>
                            <input class="boton" type="submit" value="Ingresar">
                          </form>
                          <a href="#">Olvidé mi contraseña</a>
                    </div>
                </section>
            </main>
            <footer class="footer-general">
              <div>
                <ul>
                  <li><a href="https://www.instagram.com/?hl=es-la" target="blank"><div class="footer-icons"><i class="fa fa-instagram fa-2x"></i></div></a></li>
                  <li><a href="https://twitter.com/?lang=es/" target="blank"><div class="footer-icons"><i class="fa fa-twitter fa-2x"></i></div></a></li>
                  <li><a href="https://es-la.facebook.com/" target="blank"><div class="footer-icons"><i class="fa fa-facebook fa-2x"></i></div></a></li>
                </ul>
              </div>
            </footer>
        </div>
    </body>
  </html>
