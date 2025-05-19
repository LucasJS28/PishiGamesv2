<?php
require_once 'conexiones/Productos.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
$productos = new Productos();
$listaJuegos = $productos->mostrarProductosmasBaratos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pishi Games</title>
    <link rel="stylesheet" href="estilos/style.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    
</head>

<body>

    <?php include 'nav.php'; ?>

    <section id="Bienvenida">
        <h1 id="titulo">Pishi Games</h1>
        <h3 id="subtitulo">!!!Estamos para Quedarnos!!! Autor: Lucas Jimenez Sepulveda</h3>
    </section>

    <div id="VideoPresentacion">
        <video muted controls autoplay loop src="videos/videoPresentacion.mp4"></video>
    </div>

    <h1 id="titulo" style="font-size:25px; margin-bottom: 1rem;">!!! Ofertas del Dia de Hoy !!!</h1>

    <ul class="listaJuegos" role="list">
        <?php foreach ($listaJuegos as $juego) { ?>
            <li class="juego <?php echo ($juego['stock'] == 0) ? 'sin-stock' : ''; ?>" role="listitem">
                <a href="detalles_juego.php?id=<?php echo $juego['idJuego']; ?>" style="text-decoration:none; color: inherit;">
                    <div class="juego-container">
                        <h4 class="titulo"><?php echo htmlspecialchars($juego['titulo']); ?></h4>
                        <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                        <img class="imagen" src="<?php echo htmlspecialchars($juego['imagen']); ?>" alt="Imagen del juego: <?php echo htmlspecialchars($juego['titulo']); ?>">
                        <p class="precio">Precio: $<?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>

</body>

</html>
