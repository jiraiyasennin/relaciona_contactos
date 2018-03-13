<html>
    <head>
        <title>Instalación de la base de datos</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <h1>Instalación de la base de datos</h1>
        <?php
        //Código para crear la base de datos
        try {
            $conexion = new PDO("mysql:host=localhost", "root", "");
            $conexion->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<p style='error'>{$e->getMessage()}</p>";
        }
        $sql = "DROP DATABASE  IF EXISTS relacion; 
             CREATE DATABASE relacion; ";

        $ok = $conexion->exec($sql);

        if ($ok === false) {
            echo "<p class='error'> No se ha podido crear la base de datos</p>";
            echo "<p class='ok'>Aunque muestre error al crear la base de datos, ya se ha creado,
          el problema es que la función exec siempre mostrará valor false si no modifica ninguna
          fila (Rows).</p>";
            echo "<h2 class='error'>{$conexion->errorInfo()[2]}</h2>";
        } else {
            echo "<h2 class='ok'>Base de datos creada</h2>";
        }

        //Seleccionar la base de datos
        $selectdb = "use relacion;";
        $ok = $conexion->exec($selectdb);
        if ($ok === false) {
            echo "<p class='error'> No se ha podido seleccionar la base de datos</p>";
            echo "<p class='error'>{$conexion->errorInfo()[2]}</p>";
        } else {
            echo "<p class='ok'>Base de datos seleccionada</p>";
        }

        //Crear la tabla contactos
        $tabla1 = "create table contactos(
        id int(10) PRIMARY KEY AUTO_INCREMENT, 
        nombre varchar(20), 
        mail varchar(20));";

        $bd = $conexion->exec($tabla1);

        if ($bd === false) {
            echo "<p class='error'>La tabla contactos no ha sido creada</p>";
            echo "<h2 class='error'>{$conexion->errorInfo()[2]}</h2>";
        } else {
            echo "<p class='ok'>La tabla contactos ha sido creada</p>";
        }

        //Crear la tabla relacion
        $tabla1 = "create table relacion(id_conocedor int(10), id_conocido int(10)
        ,PRIMARY KEY(id_conocedor, id_conocido),
        FOREIGN KEY(id_conocedor) REFERENCES contactos(id)ON DELETE CASCADE ON UPDATE CASCADE, 
        FOREIGN KEY(id_conocido) REFERENCES contactos(id) ON DELETE CASCADE ON UPDATE CASCADE);";

        $crea = $conexion->exec($tabla1);

        if ($crea === false) {
            echo "<p class='error'>La tabla relación no ha sido creada</p>";
            echo "<h2 class='error'>{$conexion->errorInfo()[2]}</h2>";
        } else {
            echo "<p class='ok'>La tabla relación ha sido creada</p>";
        }

        //Insertar datos en las tablas
        $datos = "insert into contactos(nombre,mail)
                            values('cesar', 'cesar@server'),( 'maria', 'maria@server'),
                                    ('jose','jose@server'),('carlos','carlos@server'),('roger','roger@server'),
                                    ('winston','winston@server'),('joseph','joseph@server'),
                                    ('stan','stan@server'),('wanda','wanda@server'),
                                    ('malcolmx','malcolmx@server'),('jfk','jfk@server'),
                                    ('salvadorpa','salvadorpa@server'),('krishnamurti','krishnamurti@server'),
                                    ('vladimirp','vladimirp@server'),('lechwalesa','lechwalesa@server'),
                                    ('xavierx','xavierx@server'),('michael','michael@server'),
                                    ('harryhaller','harryhaller@server'),('ichigo','ichigo@server'),
                                    ('ivanpetrovich','ivanpetrovich@server'),('johnwayne','johnwayne@server');";

        $crea2 = $conexion->exec($datos);

        if ($crea2 === false) {
            echo "<p class='error'>Los datos no han sido introducidos correctamente</p>";
            echo "<h2 class='error'>{$conexion->errorInfo()[2]}</h2>";
        } else {
            echo "<p class='ok'>Los datos han sido introducidos correctamente</p>";
            echo "<a href='../index.php'>Ir al inicio</a>";
        }
        ?>

    </body>
</html>