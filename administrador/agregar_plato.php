<?php
//Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Permite crear la lista con las distintas categorías de los platos*/
$categorias = ["Carnes", "Pastas", "Pizzas", "Postres", "Bebidas", "Vinos"];
$mensaje = "";

/*Si los datos del formulario se reciben mediante el método POST asigna los distintos valores a las variables*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $categoria = $_POST["categoria"] ?? "";
    $precio = $_POST["precio"] ?? "";

/*Verifica que los datos puestos en el formulario sean correctos sino muestra un mensaje de error*/
    if ($nombre === "" || !in_array($categoria, $categorias, true) || !is_numeric($precio) || $precio < 1000) {
        $mensaje = "Completá todos los campos correctamente.";

    /*Prepara la conexión a la base de datos para realizar la consulta determinando los parámetros y luego 
    asigna a los parámetros los datos que van a contener y el tipo de dato*/
    } else {
        $consulta = $conexion->prepare(
            "INSERT INTO menu (nombre, categoria, precio) VALUES (?, ?, ?)"
        );
        $consulta->bind_param("ssd", $nombre, $categoria, $precio);

/*Si la consulta se realizó correctamente muestra un mensaje de éxito sino muestra un mensaje de error*/
        if ($consulta->execute()) {
            $mensaje = "El plato se agregó correctamente.";
        } else {
            $mensaje = "No se pudo agregar el plato.";
        }
        $consulta->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Plato</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="agregar_platos.css">
    <!--Conexión con la página de íconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <!--Barra de navegación-->
    <header>
        <nav>
            <!--Logo del restaurante-->
            <div class="logo">
            <h1>La Toscana</h1>
            <h2>Mendoza-Argentina</h2>
            </div>
        </nav>
    </header>
<main>
    <!--Muestra un mensaje luego de guardar los cambios-->
    <?php if ($mensaje !== ""): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        
        <!--Formulario para poder agregar un nuevo plato al menú-->
        <form class="agregar" action="agregar_plato.php" method="POST">
        <h1>Agregar</h1>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Seleccione una categoría</option>
            <!--Carga las distintas categorías desde PHP-->
            <?php foreach ($categorias as $opcion): ?>
                <option value="<?= htmlspecialchars($opcion) ?>">
                    <?= htmlspecialchars($opcion) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" min="1000"required>

        <button type="submit">Guardar</button>
    </form>
    <button type="button" class="volver"><a href="ver_platos.php">Volver</a></button>
</main>
    <!--Pie de página-->
    <footer>
        <!--Logo del restaurante-->
        <div class="logo">
            <h1>La Toscana</h1>
            <h2>Mendoza-Argentina</h2>
        </div>
        <!--Características del restaurante-->
        <div class="detalles">
            <ul class="pie">
                <li>
                    La Toscana Palmares
                </li>
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    Ruta Panamericana 2650
                    (Palmares Open Mall) - Godoy Cruz - Mendoza
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    latoscanapalmares@gmail.com
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    +54 261 615 9431
                </li>
            </ul>
        </div>
        <!--Redes sociales del restaurante-->
        <div class="redes">
            <ul class="sociales">
                <h1>Seguinos</h1>
                <li>
                    <a href="https://www.instagram.com/la_toscana_palmares" target="_blank">
                    <i class="fa-brands fa-instagram"></i> Instagram
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/profile.php?id=61595594422052" target="_blank">
                    <i class="fa-brands fa-facebook"></i> Facebook
                    </a>
                </li>
            </ul>
    </footer>
</body>
</html>