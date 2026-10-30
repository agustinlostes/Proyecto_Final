<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Permite verificar que exista el ID de la reserva seleccionada, sino se encuentra muestra un mensaje*/
if (!isset($_POST["ID"])) {
    die("Seleccioná una reserva válida.");
}

/*Asigna el ID de la reserva a la variable $ID y determina que es de tipo entero*/
$ID = (int) $_POST["ID"];

/*Después de recibir el ID prepara la conexión a la base de datos para poder realizar la consulta SQL*/
$consulta = $conexion->prepare(
    "SELECT cliente, email, whatsapp, fecha, hora, personas
    FROM reservas
    WHERE ID = ?"
);

/*Asigna el valor del ID y el tipo de dato, ejecuta la consulta SQL, obtiene el resultado de la consulta y 
transforma el resultado en un arreglo asociativo para asignarselo a la variable $Reserva*/
$consulta->bind_param("i", $ID);
$consulta->execute();
$resultado = $consulta->get_result();
$reserva = $resultado->fetch_assoc();

/*Si no se encuentra los valores de la varible $Reserva muestra un mensaje*/
if (!$reserva) {
    die("No se encontró la reserva.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas del restaurante</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="modificar_reserva.css">
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
        <!--Permite enviar el formulario de modificar las reservas al arhcivo que guarda los cambios-->
        <form class="reserva" action="guardar_cambios_reservas.php" method="POST">
            <h1>Modificar Reserva</h1>
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">

            <label for="cliente">Cliente:</label>
            <input type="text" id="cliente" name="cliente"
                value="<?php echo htmlspecialchars($reserva["cliente"]); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo htmlspecialchars($reserva["email"]); ?>" required>

            <label for="whatsapp">WhatsApp:</label>
            <input type="text" id="whatsapp" name="whatsapp"
                value="<?php echo htmlspecialchars($reserva["whatsapp"]); ?>" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha"
                value="<?php echo htmlspecialchars($reserva["fecha"]); ?>" required>

            <!--Crea una lista con los horarios que se van a mostrar en el menú desplegable y si coincide
            con la hora del usuario queda ese hora seleccionada-->
            <label for="hora">Hora:</label>
            <select name="hora" id="hora" required>
            <?php
                $horarios = ["12:00", "12:30", "13:00", "13:30", "20:00", "20:30", "21:00", "21:30"];
            foreach ($horarios as $horario):
                ?>
            <!--Permite transformar la hora de la base de datos para que se muestre con solo 5 caracteres-->
            <option value="<?php echo $horario; ?>"
                <?php if (substr($reserva["hora"], 0, 5) === $horario) echo "selected"; ?>>
                <?php echo $horario; ?>
            </option>
            <?php endforeach; ?>
            </select>

                <label for="personas">Personas:</label>
                <input type="number" id="personas" name="personas" min="1"
                    value="<?php echo (int) $reserva["personas"]; ?>" required>

            <button type="submit">Guardar cambios</button>
        </form>
        <p class="cancelar"><a href="ver_reservas.php">Cancelar y volver</a></p>
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