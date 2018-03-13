<html>
    <head>
        <title>Añadir contactos</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <h1>Añadir contactos</h1>
        <div class="header">
            <a href="index.php">Volver a la lista de contactos</a>
        </div>
        <form class="formulario" action="" method="GET">
            <input type='text' name="nombre" placeholder="Añadir nombre" required>
            <input type='text' name="mail" placeholder="Añadir e-mail" required>
            <input type='submit' name="submit" value='Insertar'>
        </form>
        <?php
        require_once 'includes/db.php';
        require_once 'includes/functions.php';
        session_start();
        if (isset($_GET['submit'])) {
          //Seleccionar la base de datos
            $selectdb = "use relacion;";
            $ok = conecta()->exec($selectdb);
            
            //<----------------VERIFICAR SI LA CONEXION ES EFECTIVA-------------->
            if ($ok === false) {
                echo "<p class='errorborrar'> No se ha podido seleccionar la base de datos</p>";
                echo "<p class='errorborrar'>{$conexion->errorInfo()[2]}</p>";
            }

            //Tabla de contactos
            $add = ("insert into contactos (nombre,mail) values(:nombre, :email);");
            $statement = conecta()->prepare($add);
            $nombre = "{$_GET['nombre']}";
            $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $email = "{$_GET['mail']}";
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $ok= $statement->execute();
            
            if ( $ok===false) {
              $_SESSION["mensajeError"] = "El contacto  " . $nombre . ", " . $email . " no se pudo añadir";
                echo mensajeError();
               
            } else {
                 $_SESSION["mensajeOk"] = "El contacto  " . $nombre . ", " . $email . " fué añadido correctamente";
                echo mensajeOk();
              }
        }
        ?>
    </table>
</body>
</html>