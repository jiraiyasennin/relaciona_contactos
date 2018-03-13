<html>
    <head>
        <title>Relacionar Contactos</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <h1>Relacionar Contactos</h1>
        <div class="header">
            <a href="index.php">Volver a la lista de contactos</a>
        </div>
        <form action="" method="GET">
            <table class="menurelacionar">
                <tr>
                    <th>Id</th><th>Nombre</th><th>mail</th><th>Selecciona</th>
                </tr>

                <?php
                require_once 'includes/db.php';
                session_start();
                if (isset($_GET['Relacionar'])) {
//<--------------GUARDO LA ID DEL CONOCEDOR EN LA VARIABLE $id_conocedor------------------->
                    $id_conocedor = $_SESSION['relacionar'] = $_GET['Relacionar'];

                    $query = ("select id, nombre, mail from contactos where id not in(select id_conocido from relacion where relacion.id_conocedor= $id_conocedor) and id<>$id_conocedor;");
                    $statement = conecta()->prepare($query);
                    $statement->execute();
                    $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultados as $datos => $valor) {
                        $id = $valor['id'];
                        $nombre = $valor['nombre'];
                        $mail = $valor['mail'];
                        ?>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $mail ?></td>
                            <td><input type="checkbox" name="contacto[]" value="<?php echo $id ?>"></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table><br>
            <input class="inputrelacionar" type ="submit" name ="submit" value="Relaciona los contactos seleccionados">
        </form>

        <?php
        if (isset($_GET['submit'])) {
            $id_conocedor = $_SESSION['relacionar'];

            foreach ($_GET['contacto'] as $key => $value) {

                $id_conocido = $_GET['contacto'][$key];
                print_r($id_conocido);

                $query = ("insert into relacion (id_conocedor,id_conocido)values($id_conocedor, $id_conocido);");
                $statement = conecta()->prepare($query);
                $statement->execute();
            }
            if ($query != false) {
                echo "Contactos agregados";
                header("Location: index.php");
            }
        }
        ?>
    </body>
</html>