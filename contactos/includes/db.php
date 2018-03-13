<?php

function conecta() {
    try {
        $conexion = new PDO("mysql:host=localhost", "root", "");
        $conexion->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "<p style='error'>{$e->getMessage()}</p>";
    }
    //Seleccionar la base de datos
    $selectdb = "use relacion;";
    $ok = $conexion->exec($selectdb);
    if ($ok === false) {
        echo "<p class='error'> No se ha podido seleccionar la base de datos</p>";
        echo "<p class='error'>{$conexion->errorInfo()[2]}</p>";
    }
    return $conexion;
}

?>