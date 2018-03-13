<!DOCTYPE HTML>
<?php

require_once 'db.php';

//[---------------------------------FUNCIONES DEL PROGRAMA----------------------------------------------]
//----------------------------FUNCION DE BUSQUEDA INICIAL--------------------------------------
function select() {
    $query = ("select * from contactos;");
    $statement = conecta()->prepare($query);
    $statement->execute();
    $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $datos => $valor) {
        $id = $valor['id'];
        $nombre = $valor['nombre'];
        $mail = $valor['mail'];
        ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $mail; ?></td>
            <td>
                <ul>
                    <?php relacionados($id) ?>
                </ul>
            </td>
            <td><a class="relacionar" href="relacionar.php?Relacionar=<?php echo $id; ?>">Ir</a></td>
            <td><a class="borrar" href="includes/functions.php?Borrar=<?php echo $id; ?>">Borrar</a></td>
        </tr>
        <?php
    }
}

//----------------------------FUNCION DE BUSCAR UNA CADENA DE CARACTERES ESPECIFICA--------------------------------------
function search($buscar) {
    //Tabla de contactos
    $query = ("select * from contactos where nombre like :buscar or mail like :buscar;");
    $statement = conecta()->prepare($query);
    $search = "%{$buscar}%";
    $statement->bindParam(':buscar', $search);
    $statement->execute();
    $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $datos => $valor) {
        $id = $valor['id'];
        $nombre = $valor['nombre'];
        $mail = $valor['mail'];
        ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $mail; ?></td>
            <td>
                <ul>
                    <?php relacionados($id); ?>
                </ul>
            </td>
            <td><a class="relacionar" href="relacionar.php?Relacionar=<?php echo $id; ?>">Ir</a></td>
            <td><a class="borrar" href="includes/functions.php?Borrar=<?php echo $id; ?>">Borrar</a></td>
        </tr>
        <?php
    }
}

//<--------------FUNCIÓN DE BORRAR UN CONTACTO-------------------------------//
function borrar($borrar) {
    //Tabla de contactos
    $query = ("DELETE  from contactos where id= :borrar;");
    $statement = conecta()->prepare($query);
    $cambio = "{$borrar}";
    $statement->bindParam(':borrar', $cambio);
    $statement->execute();
    }

//----------------------------FUNCION DE BORRAR UN REGISTRO ESPECIFICO--------------------------------------

if (isset($_GET['Borrar'])) {
    
    session_start();

    //Guardo el id del registro a borrar en la variable de sesión
    $_SESSION['borrar'] = $_GET['Borrar'];
    $ok = borrar($_SESSION['borrar']);

    if ($ok === false) {
        $_SESSION["mensajeError"] = "El registro no pudo borrarse";
        header("Location:../index.php");
    } else {
        $_SESSION["mensajeOk"] = "El registro " . $_SESSION['borrar'] . " fué borrado correctamente";
        header("Location:../index.php");
    }
}

//<--------------Enviar mensajes de Error al borrar-------------------------------//
function mensajeError() {
    if (isset($_SESSION["mensajeError"])) {
        $Output = "<div class=\"errorborar\">";
        $Output .= htmlentities($_SESSION["mensajeError"]);
        $Output .= "</div>";
        $_SESSION["mensajeError"] = null;
        return $Output;
    }
}

//<--------------Enviar mensajes de Ok al borrar-------------------------------//
function mensajeOk() {
    if (isset($_SESSION["mensajeOk"])) {
        $Output = "<div class=\"okborrar\">";
        $Output .= htmlentities($_SESSION["mensajeOk"]);
        $Output .= "</div>";
        $_SESSION["mensajeOk"] = null;
        return $Output;
    }
}

//<--------------FUNCION QUE BUSCA LOS RELACIONADOS----------------->
function relacionados($id) {
    $query = ("select id from contactos, relacion where relacion.id_conocido=contactos.id 
                        and id_conocedor=$id;");
    $statement = conecta()->prepare($query);
    $statement->execute();
    $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $valor => $value) {
        $id = $value['id'];
        echo "<li>($id)</li>";
    }
}
?>