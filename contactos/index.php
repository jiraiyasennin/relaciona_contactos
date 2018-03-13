<html>
    <head>
        <title>Aplicación de buscar contactos</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <h1>Lista de contactos</h1>
        <div class="header">
            <a href="index.php">Index</a> <a href="nuevocontacto.php">Añadir nuevo contacto</a>
            <form class="formulario" action="" method="GET">
                <input type='text' name="buscar" placeholder="Búsqueda de contacto">
                <input type='submit' name="submit" value='Buscar'>
            </form>
        </div>
        <table class="index">
            <tr>
                <th>Id</th><th>Nombre</th><th>E-mail</th><th>Contactos</th><th>Relacionar</th><th>Borrar</th>
            </tr>
            <?php
            session_start();
            //Incluyo el archivo de la conexión y las funciones
            require_once 'includes/db.php';
            require_once 'includes/functions.php';
            
            
            if (isset($_GET['buscar']) && ($_GET['submit'])) {
                $buscar = $_SESSION['buscar'] = $_GET['buscar'];
                
                //<---------------Si se han introducido datos en la búsqueda se ejecuta esta función---------------->
                search($buscar);
            } else {
                 //<---------------Al cargar la página se hace una búsqueda automática---------------->
                select();
            }
            //<-------------Sección de mensajes al borrar---------->
            echo mensajeOk();
            echo mensajeError();
            ?>
        </table>
        <div class="footer">
            <p>Diseñado por Dostow Ugel</p>
        </div>
    </body>
</html>