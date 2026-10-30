<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "Backend/conexion.php";

// Lista de las categorías y el nombre para cada ancla.
$categorias = [
    "Carnes" => "carnes",
    "Pastas" => "pastas",
    "Pizzas" => "pizzas",
    "Postres" => "postres",
    "Bebidas" => "bebidas",
    "Vinos" => "vinos"
];

// Lista para guardar los platos separados por categoría.
$platosPorCategoria = [];
/*Recorre el arreglo "categorias" y asigna los platos a la variable "categoria" y luego genera la lista vacía 
donde se van a cargar los platos*/
foreach ($categorias as $categoria => $ancla) {
    $platosPorCategoria[$categoria] = [];

    // Busca en la tabla menu los platos de la categoría elegida.
$sql = "SELECT nombre, categoria, precio
            FROM menu
            WHERE categoria = ?
            ORDER BY ID";
/*Se prepara la consulta SQL, se le asigna un valor al signo de preguntas que corresponde a la categoría del plato
y el tipo de dato, se ejecuta al consulta y se obtiene el resultado*/
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("s", $categoria);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Guarda cada plato encontrado en la lista de su categoría.
    while ($plato = $resultado->fetch_assoc()) {
        $platosPorCategoria[$categoria][] = $plato;
    }
    $consulta->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="menu.css">
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
            <!--Opciones de la barra de navegación-->
            <div class="opciones">
                <ul class="barra">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="reservas.php">Reservas</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="historia.php">Historia</a></li>
            </ul>
            </div>
        </nav>
    </header>
    <!--Contenido que se encuentra escrito sobre la imágen-->
    <main>
        <section class="hero">
            <h1>Restaurante<br>La carta de una historia compartida</h1>
            <p>Carnes, Pastas, Pizzas, Postres y Bebidas para acompañar tu mesa</p>
        </section>
        <!-- Se crea el enlace del ancla para recorrer el menú-->
    <nav class="menu">
        <ul class="carta">
            <?php foreach ($categorias as $categoria => $ancla): ?>
                <li class="platos">		
                    <a href="#<?= htmlspecialchars($ancla) ?>">
                        <?= htmlspecialchars($categoria) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
        <!--Recibe el ID del ancla luego de hacer click sobre la categoría-->
    <?php foreach ($categorias as $categoria => $ancla): ?>
    <section class="seccion-menu" id="<?= htmlspecialchars($ancla) ?>">

        <!--Permite escribir el título de cada categoría-->
        <h2>Nuestras <?= htmlspecialchars($categoria) ?></h2>

        <!--Verifica si hay más de un plato por cada categoría y si hay ejecuta la siguiente línea-->
        <?php if (count($platosPorCategoria[$categoria]) > 0): ?>
            <div class="lista-platos">

                <!--Recorre los platos de cada categoría y los asigna a la variable "plato"-->
                <?php foreach ($platosPorCategoria[$categoria] as $plato): ?>
                    <article class="plato">
                        <span class="nombre-plato">
                            <?= htmlspecialchars($plato["nombre"]) ?>
                        </span>

                        <!--Muestra el número con formato de precio, sin mostrar decimales y usando el punto 
                        para los miles-->
                        <span class="precio-plato">
                            $<?= number_format((float)$plato["precio"], 0, ",", ".") ?>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>

            <!--En caso que no haya ningún plato en la categoría muestra este mensaje-->
        <?php else: ?>
            <p>Próximamente agregaremos platos a esta categoría.</p>
        <?php endif; ?>
    </section>
        <?php endforeach; ?>
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
                <li>
                    <a href="administrador/inicio_sesion.php">
                        <i class="fa-solid fa-lock"></i>
                    </a>
                </li>
            </ul>
    </footer>
</body> 
</html>