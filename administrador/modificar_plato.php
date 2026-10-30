<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Permite crear una lista con todas las categorías de los platos y una varible de mensaje vacía*/
$categorias = ["Carnes", "Pastas", "Pizzas", "Postres", "Bebidas", "Vinos"];
$mensaje = "";

/*Permite comprobar si se envio el formulario para guardar un plato y si cumple la condición permite 
obtener los datos enviados y realizar la modificación de un plato*/
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar"])) {
    $id = (int) ($_POST["id"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $categoria = $_POST["categoria"] ?? "";
    $precio = $_POST["precio"] ?? "";

    /*Permite controlar que los datos ingresados sean correctos sino muestra un mensaje*/
    if 
    (
        $id <= 0 || $nombre === "" || !in_array($categoria, $categorias, true) || !is_numeric($precio) 
        || $precio <= 0
    ) 
    {
        $mensaje = "Completá todos los campos correctamente.";
    } 

    /*Si los datos ingresados son correctos prepara la conexión con la base de datos para realizar la consulta
    asignando los distintos valores y el tipo de dato que es cada uno*/
    else 
    {
        $consulta = $conexion->prepare(
            "UPDATE menu SET nombre = ?, categoria = ?, precio = ? WHERE ID = ?"
        );
        $consulta->bind_param("ssdi", $nombre, $categoria, $precio, $id);

    /*Ejecuta la consulta y si se ejecutó correctamente redirige al administrador a la página donde están 
    todos los platos con la categoría correspondiente*/
        if ($consulta->execute()) {
            header("Location: ver_platos.php?categoria=" . urlencode($categoria));
            exit;
        }

        /*Si no se ejecuta correctamente muestra un mensaje y finaliza la consulta*/
        $mensaje = "No se pudo modificar el plato.";
        $consulta->close();
    }
} 

/*Permite obtener los datos de la base de datos si el usuario seleccionó un plato para modificarlo*/
else 
    {
    // Al presionar "Modificar", busca el plato seleccionado
    $id = (int) ($_POST["plato"] ?? 0);

/*Prepara la conexión con la base de datos para realizar la consulta y asigna el ID indicando que es de 
tipo entero y por último ejecuta la consulta a la base de datos*/
    $consulta = $conexion->prepare(
        "SELECT nombre, categoria, precio FROM menu WHERE ID = ?"
    );
    $consulta->bind_param("i", $id);
    $consulta->execute();

    /*Obtiene el resultado de la consulta, permite recuperar ese resultado transformandolo en un arreglo 
    asociativo y cierra la consulta*/
    $resultado = $consulta->get_result();
    $plato = $resultado->fetch_assoc();
    $consulta->close();

    /*Si no se encuentan los datos asignados a la variable $plato muestra un mensaje de error*/
    if (!$plato) {
     // Imprime el script de JavaScript y detiene la ejecución
    echo "<script>
        alert('Seleccioná un plato para modificar.');
        window.history.back(); // Regresa al formulario anterior
    </script>";
    exit; // Detiene el script de PHP de forma limpia
    }

    /*Si se encontraron los datos se asignan a las distintas variables como el nombre, la categoria y el precio*/
    $nombre = $plato["nombre"];
    $categoria = $plato["categoria"];
    $precio = $plato["precio"];
    }
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Plato</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="modificar_plato.css">
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
    <!--Permite mostrar un mensaje de alerta-->
        <?php if ($mensaje !== ""): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        
        <!--Crea el formulario para poder enviar los datos y que se procesen correctamente para realizar la 
        modificación-->
        <form class="modificar" action="modificar_plato.php" method="POST">
        <h1>Modificar</h1>
        <input type="hidden" name="id" value="<?= (int) $id ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required >

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php foreach ($categorias as $opcion): ?>
                <option
                    value="<?= htmlspecialchars($opcion) ?>"
                    <?= $opcion === $categoria ? "selected" : "" ?>>
                    <?= htmlspecialchars($opcion) ?>
                </option>   
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" min="1000" value="<?= htmlspecialchars((string) $precio) ?>"
            required >
        <button type="submit" name="guardar">Guardar cambios</button>
    </form>
    <p class="cancelar"><a href="ver_platos.php">Cancelar y volver</a></p>
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