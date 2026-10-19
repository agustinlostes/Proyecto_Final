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
        <form class="reserva" action="" method="POST">
            <!--Título del formulario-->
            <h2>Reservá Tu Mesa</h2>
            <!--Elementos del formulario-->
            <label for="nombre"></label>
            <input  type="text" id="nombre" name="nombre" placeholder="Nombre y apellido" required>
            <br>
            <label for="email"></label>
            <input type="email" id="email" name="email" placeholder="afafaf@gmail.com" required>
            <br>
            <div class="numero">
                <label for="codigo_area"></label>
                <input type="tel" id="codigo_area" name="codigo_area" placeholder="261" pattern="[0-9]{1,3}" maxlength="3" required>
                <span>-</span>
                <label for="whatsapp"></label>
                <input type="tel" id="whatsapp" name="whatsapp" placeholder="1234567" pattern="[0-9]{1,7}" maxlength="7" required>
            </div>
            <br>
            <label for="fecha"></label>
            <input type="date" id="fecha" name="fecha" placeholder="Fecha" required>
            <br>
            <select name="horas" required>
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
            <label for="personas"></label>
            <input type="number" min="1" id="personas" name="personas" placeholder="Personas" required>
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