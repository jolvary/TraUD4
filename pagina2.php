<!DOCTYPE html>
<html>
    <?php 

        error_reporting(E_ALL ^ E_NOTICE);

       include_once('Funciones.php');
       session_start();
       if(empty($_SESSION["idUsu"])) {
           header("Location: login.php");
           exit;
       }

       if(!empty($_POST['crear'])) {
           
            createPostWordpress($_POST['title'], $_POST['content']);

       }

    ?>
    <head>
        <meta charset="UTF-8">
        <title>Proyecto 7</title>
    </head>
    <body>
        <center>
        <h1>Zona Personal</h1>
        <br>
        <form method="POST" action="pagina2.php">
            <label for="title">Título: </label>
            <input type="text" name="title">
            <label for="content">Contenido: </label>
            <input type="text" name="content">
            <input class="boton" TYPE="submit" name="crear" value="crear">
        </form>
        <br><br><br>
        <form id="wp" method="POST" action="/wordpress/wp-login.php">
            <input type="hidden" name="log" value="<?php echo $_SESSION["nombre"]; ?>">
            <input type="hidden" name="pwd" value="<?php echo $_SESSION["password"]; ?>">
        <input form="wp" class="boton" TYPE="submit" name="acceso" value="Acceder a WordPress">
        </form>
        <br>
        <form id="espocm" method="POST" action="/EspoCRM-7.0.9/#">
            <input type="hidden" name="log" value="<?php echo $_SESSION["nombre"]; ?>">
            <input type="hidden" name="pwd" value="<?php echo $_SESSION["password"]; ?>">
        <input form="espocm" class="boton" TYPE="submit" name="acceso" value="Acceder a EspoCRM">
        </form>
        </center>
    </body>
</html>