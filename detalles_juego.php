<?php
session_start();
require_once 'conexiones/Productos.php';

$productos = new Productos();
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarCarrito'])) {
    $idJuego = $_POST['idJuego'];

    if (array_key_exists($idJuego, $_SESSION['carrito'])) {
        if ($productos->verificarStock($idJuego, $_SESSION['carrito'][$idJuego]['cantidad'] + 1)) {
            $_SESSION['carrito'][$idJuego]['cantidad']++;
            echo "<div id='alerta' class='AlertaBuena'>Se añadió una nueva copia al Carro. Cantidad: " . $_SESSION['carrito'][$idJuego]['cantidad'] . "</div>";
            header('Location: detalles_juego.php?id='.$idJuego);
        } else {
            echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
            header('Location: detalles_juego.php?id='.$idJuego);
        }
    } else {
        $juego = $productos->obtenerProducto($idJuego);

        if ($juego) {
            if ($productos->verificarStock($idJuego, 1)) {
                $_SESSION['carrito'][$idJuego] = array(
                    'titulo' => $juego['titulo'],
                    'descripcion' => $juego['descripcion'],
                    'imagen' => $juego['imagen'],
                    'precio' => $juego['precio'],
                    'cantidad' => 1
                );
                echo "<div id='alerta' class='AlertaBuena'>Se añadió al Carrito Cantidad:1</div>";
                header('Location: detalles_juego.php?id='.$idJuego);
            } else {
                echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
                header('Location: detalles_juego.php?id='.$idJuego);
            }
        }
    }

    exit;
}

$idJuego = isset($_GET['id']) ? $_GET['id'] : null;

$juego = $productos->obtenerProducto($idJuego);
if (!$juego) {
    header("Location: tienda.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pishi Games - Detalles del Juego</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</head>
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #121212;
        color: #e0e0e0;
        margin: 0;
        padding: 0;
    }

    .contenedorjuegoxd {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 2rem 1rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .juego-detalle {
        background-color: #1e1e1e;
        border: 2px solid #80cbc4;
        border-radius: 12px;
        padding: 2rem;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .juego-detalle h2 {
        color: #a7ffeb;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .juego-detalle img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .juego-detalle p.descripcion {
        color: #b2dfdb;
        font-size: 1rem;
        line-height: 1.6;
        margin-top: 1rem;
    }

    .juego-detalle .precio {
        font-size: 1.3rem;
        color: #80cbc4;
        font-weight: bold;
        text-align: right;
    }

    .juego-detalle form {
        margin-top: 1.5rem;
        display: flex;
        justify-content: flex-end;
    }

    .juego-detalle button {
        background-color: #80cbc4;
        color: #121212;
        border: none;
        padding: 0.7rem 1.2rem;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .juego-detalle button:hover {
        background-color: #4db6ac;
    }

    .AlertaBuena {
        background-color: #2e7d32;
        color: #e0f2f1;
        padding: 0.8rem 1rem;
        margin: 1rem auto;
        text-align: center;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        box-shadow: 0 0 10px #2e7d32;
    }

    .AlertaMala {
        background-color: #c62828;
        color: #ffebee;
        padding: 0.8rem 1rem;
        margin: 1rem auto;
        text-align: center;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        box-shadow: 0 0 10px #c62828;
    }

    .juego-detalle img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
    border-radius: 10px;
}
.juego-detalle .stock {
    font-size: 1rem;
    color: #ffd54f;
    font-weight: bold;
    text-align: right;
    margin-top: -0.5rem;
}

</style>
<body>
<?php include 'nav.php'; ?>
    <div class="contenedorjuegoxd">
    <div class="juego-detalle">
        <h2><?php echo htmlspecialchars($juego['titulo']); ?></h2>
        <img src="<?php echo htmlspecialchars($juego['imagen']); ?>" alt="Imagen del juego">
        <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
        <p class="precio">Precio: $<?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
    <p class="stock">Stock disponible: <?php echo $juego['stock']; ?></p>

        <form method="POST">
            <input type="hidden" name="idJuego" value="<?php echo $juego['idJuego']; ?>">
            <button type="submit" name="agregarCarrito">
                <i class="fas fa-cart-plus"></i> Agregar al Carrito
            </button>
        </form>
    </div>
</div>


</body>

</html>
