<?php
/*protege el panel del administrador para que solo pueda verla un administrador que inició sesión 
comprobando que exista la variable que se guarda cuando el inición de sesión es correcto*/
session_start();
if (!isset($_SESSION["administrador_id"])){ 
    header("Location: inicio_sesion.php"); 
    exit;
}
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Crear la lista con las categorías de platos*/
$categorias = ["Carnes", "Pastas", "Pizzas", "Postres", "Bebidas", "Vinos"];

/*Recibe la categoría seleccionada mediante el método GET*/
$categoriaSeleccionada = $_GET["categoria"] ?? "";

/*Verifica que la categoría seleccionada sea una de la permitidas*/
if (!in_array($categoriaSeleccionada, $categorias)) {
    $categoriaSeleccionada = "";
}
/*Verifica si hay alguna categoría seleccionada, si no hay ninguna no muestra ningún plato*/
if ($categoriaSeleccionada === "") {
    $consulta = $conexion->prepare(
        "SELECT ID, nombre, precio FROM menu WHERE 1 = 0"
    );
} 
/*Si seleccionó una categoría realiza la consulta a la base de datos para mostrar los platos*/
else {
    $consulta = $conexion->prepare(
        "SELECT ID, nombre, categoria, precio FROM menu WHERE categoria = ? ORDER BY ID"
    );
    $consulta->bind_param("s", $categoriaSeleccionada);
}
$consulta->execute();
$resultado = $consulta->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos del restaurante</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="ver_platos.css">
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
    <!--Estructura de la tabla la cual contiene todos los platos del restaurante-->
    <main>
        <div class="tabla">
            <!--Título de la sección de platos del restaurante-->
            <h2>🍽️Platos y Bebidas del Restaurante</h2>
            <!--Categorías de los distintos platos-->
            <div class="menu">
                <!--Muestra la categoría seleccionada en la URL-->
                <ul class="carta">
                    <li class="platos"><a href="ver_platos.php?categoria=Carnes">Carnes</a></li>
                    <li class="platos"><a href="ver_platos.php?categoria=Pastas">Pastas</a></li>
                    <li class="platos"><a href="ver_platos.php?categoria=Pizzas">Pizzas</a></li>
                    <li class="platos"><a href="ver_platos.php?categoria=Postres">Postres</a></li>
                    <li class="platos"><a href="ver_platos.php?categoria=Bebidas">Bebidas</a></li>
                    <li class="platos"><a href="ver_platos.php?categoria=Vinos">Vinos</a></li>
                </ul>
            </div>
            <!--Muestra dos opciones antes de enviar el formulario y si el usuario selecciona aceptar
            se envía a eliminar_plato.php y si toca que no se queda en la misma página-->
            <form action="eliminar_plato.php" method="POST">
            <!--Tabla donde se encuentran los platos-->
                <table id="platos">
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Seleccionar</th>
                    </tr>
                    <!--Muestra un mensaje cuando se ingresa a la tabla y no hay nada seleccionado-->
                    <?php if ($categoriaSeleccionada === ""): ?>
                        <tr>
                            <td colspan="4">Seleccione una categoría para ver.</td>
                        </tr>
                    <!--Si se seleciona una categoría muestra el nombre, la categoría y el precio del plato-->
                    <?php else: ?>
                        <?php while ($plato = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($plato["nombre"]) ?></td>
                            <td><?= htmlspecialchars($plato["categoria"]) ?></td>
                            <td>$<?= number_format((float)$plato["precio"], 0, ",", ".") ?></td>
                            <td><input type="radio" name="plato" value=" <?= (int) $plato['ID'] ?>" required></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </table>
                <!--Botones para que el administrador realice las distintas tareas-->
                <div class="acciones">
                    <button type="button" class="panel"> <a href="opciones_admin.php">Volver al Panel</a></button>
                    <button type="submit" class="modificar" formaction="modificar_plato.php">Modificar</button>
                    <button 
                    type = "submit" class="eliminar" 
                    onclick="return confirm('¿Estás seguro de que desea eliminar?');">Eliminar
                    </button>
                    <button type="button" class="agregar"><a href="agregar_plato.php">Agregar</a></button>
                </div>
                </form>
        </div>
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