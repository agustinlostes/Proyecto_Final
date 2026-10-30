<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "Backend/conexion.php";

$mensaje = "";
//Comprueba si se recibió el formulario mediante método POST y asigna los valores a las distintas variables
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $codigoArea = trim($_POST["codigo_area"]);
    $numeroWhatsapp = trim($_POST["whatsapp"]);
    // Genera una única fila para el teléfono juntando el número y el código de área
    $whatsapp = $codigoArea . $numeroWhatsapp;
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $personas = (int) $_POST["personas"];
//Prepara la conexión SQL para insertar los distintos datos en la tabla
    $consulta = $conexion->prepare(
        "INSERT INTO reservas (cliente, email, whatsapp, fecha, hora, personas)
        VALUES (?, ?, ?, ?, ?, ?)"
    );
//Asigna los valores a cada signo de pregunta y el tipo de dato a cada variable
    $consulta->bind_param(
        "sssssi",
        $cliente,
        $email,
        $whatsapp,
        $fecha,
        $hora,
        $personas
    );
/*Si se ejecuta la consulta correctamente muestra un mensaje de éxito sino se ejecuta correctamente muestra un
que no se pudo realizar la reserva*/ 
    if ($consulta->execute()) {
        $mensaje = "¡Reserva realizada correctamente!";
    } else {
        $mensaje = "No se pudo guardar la reserva.";
    }

    $consulta->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="reservas.css">
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
    <!--Formulario de reservas del restaurante-->
    <main>
        <form class="reserva" action="reservas.php" method="POST">
            <!--Título del formulario-->
            <h2>Reservá Tu Mesa</h2>
            <!--Si se ejecuta la consulta correctamente muestra un mensaje de éxito sino se ejecuta correctamente muestra un
            que no se pudo realizar la reserva-->
            <?php if ($mensaje !== ""): ?>
                <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
            <!--Elementos del formulario-->
            <!--Nombre y apellido de la persona-->
            <label for="nombre"></label>
            <input  type="text" id="nombre" name="nombre" placeholder="Nombre y apellido" required>
            <br>
            <!--Email de la persona-->
            <label for="email"></label>
            <input type="email" id="email" name="email" placeholder="afafaf@gmail.com" required>
            <br>
            <!--Número de teléfono de la persona-->
            <div class="numero">
                <label for="codigo_area"></label>
                <input type="tel" id="codigo_area" name="codigo_area" placeholder="261" pattern="[0-9]{1,4}" maxlength="4" required>
                <label for="whatsapp"></label>
                <input type="tel" id="whatsapp" name="whatsapp" placeholder="1234567" pattern="[0-9]{1,7}" maxlength="7" required>
            </div>
            <br>
            <!--Fecha de reserva-->
            <label for="fecha"></label>
            <input type="date" id="fecha" name="fecha" placeholder="Fecha" required>
            <br>
            <!--Hora de la reserva-->
            <select name="hora" required>
                <option value="" disabled selected>Selecciona una hora...</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="20:00">20:00</option>
                <option value="20:30">20:30</option>
                <option value="21:00">21:00</option>
                <option value="21:30">21:30</option>
            </select>
            <br>
            <!--Cantidad de personas-->
            <label for="personas"></label>
            <input type="number" min="1" max="60" id="personas" name="personas" placeholder="Personas" required>
            <br>
            <!--Botón de envío-->
            <button type="submit">Reservar</button>
        </form>
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