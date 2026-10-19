<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="sesion.css">
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
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../menu.php">Menú</a></li>
                <li><a href="../reservas.php">Reservas</a></li>
                <li><a href="../contacto.php">Contacto</a></li>
                <li><a href="../historia.php">Historia</a></li>
            </ul>
            </div>
        </nav>
    </header>
    <!--Formulario de inicio de sesión-->
    <main>
        <form class="sesion" action="" method="POST">
            <!--Título del formulario-->
            <h2>Panel del administrador</h2>
            <!--Elementos del formulario-->
            <div class="campo">
            <i class="fa-solid fa-user"></i>
            <label for="nombre"></label>
            <input  type="text" id="nombre" placeholder="Nombre de Usuario" required>
            </div>
            <br>
            <div class="campo">
            <i class="fa-solid fa-lock"></i>
            <label for="contraseña"></label>
            <input type="password" id="contraseña" placeholder="Contraseña" required>
            </div>
            <br>
            <!--Botón de envío-->
            <button type="submit"><a href="opciones_admin.php"></a>Iniciar Sesión</button>
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
            </ul>
    </footer>
</body> 
</html>