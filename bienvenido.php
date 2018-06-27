<?php
session_start();
if(!isset($_SESSION["registrado"])){
  header("Location: ingresar.php");
}
?>

<!DOCTYPE html>
  <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenido</title>
        <link rel="shortcut icon" href="imagenes/logo_chico.png" />
        <link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=ABeeZee|Open+Sans|Righteous" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bienvenidoStyle.css">
    </head>
    <body>
        <div class="contenedor">
              <div class="container">
                <div class="logo"><img src="imagenes/logo2.png"></div>
              </div>
              <nav class="sticky-top">
                  <div>
                    <ul class="menu text-center">
                      <li><a href="paginaPrincipal.php">Principal</a></li><li><a href="preguntas.php">Preguntas </a></li><li><a href="registro.php">Registrarse</a></li><li><a href="ingresar.php">Ingresar</a></li>
                    </ul>
                </div>
              </nav>
            <main>
                <h1>Bienvenido</h1>
                <span><h3>¡Gracias por haberte logeado <?=$_SESSION["usuario"]?>!</h3></span>
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
