<?php
session_start(); // Inicia la sesión al principio del script
require_once "../conexiones/Productos.php"; // Asegúrate de que esta ruta sea correcta
$productos = new Productos();

/* Revisa que el Puesto sea según los Permisos para entrar a la Página */
if (!isset($_SESSION["Puesto"]) || ($_SESSION["Puesto"] !== "Trabajador" && $_SESSION["Puesto"] !== "Administrador")) {
    header("Location:../index.php");
    exit();
}

if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    $ruta_imagen = 'imagenesjuegos/' . $imagen;
    $ruta_destino = realpath('../') . '/' . $ruta_imagen;

    // Asegurarse de que el directorio de destino exista
    $targetDir = realpath('../') . '/imagenesjuegos/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Crea el directorio si no existe
    }

    if (move_uploaded_file($imagen_temporal, $ruta_destino)) {
        $agregado = $productos->agregarProductos($titulo, $descripcion, $precio, $stock, $ruta_imagen);
        if ($agregado) {
            $_SESSION['alerta_mensaje'] = "El Producto se Agregó Correctamente";
            $_SESSION['alerta_tipo'] = "buena"; // 'buena' para éxito
        } else {
            $_SESSION['alerta_mensaje'] = "Ha ocurrido un error al agregar el producto a la base de datos.";
            $_SESSION['alerta_tipo'] = "mala"; // 'mala' para error
        }
    } else {
        $_SESSION['alerta_mensaje'] = "Error al subir la imagen. Asegúrate de que el archivo es válido y el tamaño no excede el límite del servidor.";
        $_SESSION['alerta_tipo'] = "mala";
    }

    // *** ESTA REDIRECCIÓN ES CRUCIAL PARA QUE LA ALERTA DE SESIÓN FUNCIONE ***
    header("Location: panelTrabajador.php");
    exit(); // Termina el script después de la redirección
}

// Cargar los juegos DEPUÉS de procesar la adición y redirección
$juegos = $productos->mostrarTodosProductosAsc();

?>

<!DOCTYPE html>
<html lang="es"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scriptsValidaciones.js"></script>
</head>

<style>
    /* --- Variables de Color (re-confirmadas) --- */
:root {
    --bg-dark: #1a1a2e; /* Fondo muy oscuro, casi negro-azulado */
    --primary-dark: #16213e; /* Azul oscuro para elementos principales (fondo del nav) */
    --accent-blue: #0f3460; /* Azul más profundo para acentos y bordes */
    --text-light: #e0e0e0; /* Texto claro para contraste */
    --text-muted: #a0a0a0; /* Texto gris para elementos secundarios */
    --highlight-neon: #e94560; /* Rojo/Rosa neón para resaltar */
    --hover-bg: rgba(233, 69, 96, 0.15); /* Fondo sutil de hover con color neón */
    --border-glow: #e94560; /* Color del brillo de los bordes */
    --navbar-height: 80px; /* Altura fija para el navbar en desktop */
}

/* Estilos generales del body */
body {
    font-family: 'Space Mono', 'Segoe UI', monospace, sans-serif;
    background-color: var(--bg-dark);
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

/* Aplicar box-sizing: border-box globalmente */
*, *::before, *::after {
    box-sizing: border-box;
}

/* --- Estilos para el Contenedor Principal (Formulario y Tabla) --- */
.contenedor {
    background-color: var(--primary-dark);
    padding: 2.5rem;
    margin: 2.5rem auto;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6), 0 0 20px var(--accent-blue) inset;
    width: 90%;
    max-width: 900px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid var(--accent-blue);
}

.titulo {
    color: var(--highlight-neon);
    font-size: 2.2rem;
    margin-bottom: 1.5rem;
    text-align: center;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.7);
}

/* --- Estilos del Formulario de Productos --- */
.product-form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 500px;
    gap: 1rem;
    padding: 1.5rem;
    background-color: var(--bg-dark);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.formularios {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.formularios-label {
    color: var(--text-light);
    font-weight: 600;
}

.formulario-input {
    padding: 0.9rem 1.2rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: rgba(15, 52, 96, 0.2);
    color: var(--text-light);
    font-size: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.4);
}

.formulario-input:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.3), inset 0 0 8px rgba(233, 69, 96, 0.2);
}

.formulario-input[type="file"] {
    padding-top: 12px;
}

#imagen-preview {
    margin-top: 1rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.submit-button {
    background-color: var(--highlight-neon);
    color: var(--text-light);
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: bold;
    margin-top: 1.5rem;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
}

.submit-button:hover {
    background-color: #d63c55;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6), 0 0 20px var(--highlight-neon);
}

/* --- Estilos del Contenedor de la Tabla de Juegos --- */
.contenedor-tabla {
    background-color: var(--primary-dark);
    padding: 2.5rem;
    margin: 2.5rem auto;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6), 0 0 20px var(--accent-blue) inset;
    width: 90%;
    max-width: 900px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid var(--accent-blue);
}

/* Reutilizando estilos de buscador */
#buscador {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 500px;
    margin-bottom: 2rem;
    padding: 1rem;
    background-color: rgba(15, 52, 96, 0.3);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
}

#titulo-buscar {
    color: var(--text-light);
    font-weight: 600;
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
}

#buscar {
    width: 90%;
    padding: 0.8rem 1.2rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: var(--bg-dark);
    color: var(--text-light);
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.4);
}

#buscar:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.3), inset 0 0 8px rgba(233, 69, 96, 0.2);
}

/* --- Estilos de la Tabla de Productos --- */
.tabla-principal {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 1.5rem;
    background-color: var(--bg-dark);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5), 0 0 10px var(--accent-blue) inset;
}

.tabla-principal thead {
    background-color: var(--accent-blue);
}

.tabla-principal th {
    color: var(--text-light);
    padding: 1.2rem 1rem;
    text-align: left;
    font-weight: bold;
    border-bottom: 1px solid var(--primary-dark);
    font-size: 1.05rem;
}

.tabla-principal th:first-child {
    border-top-left-radius: 10px;
}

.tabla-principal th:last-child {
    border-top-right-radius: 10px;
}

.tabla-principal td {
    color: var(--text-light);
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    vertical-align: middle;
}

.tabla-principal tbody tr:last-child td {
    border-bottom: none;
}

.tabla-principal tbody tr:nth-child(even) {
    background-color: rgba(0, 0, 0, 0.15);
}

.tabla-principal tbody tr:hover {
    background-color: var(--hover-bg);
    transition: background-color 0.3s ease;
}

.tabla-principal td img {
    max-width: 80px;
    height: auto;
    border-radius: 5px;
    border: 1px solid var(--accent-blue);
    box-shadow: 0 0 5px rgba(233, 69, 96, 0.3);
}

.no-pedidos {
    color: var(--text-muted);
    text-align: center;
    padding: 2rem;
    font-size: 1.2rem;
}

/* --- Estilos para Alertas Flotantes --- */
.alerta-flotante {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px); /* Inicialmente un poco más arriba y oculto */
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--text-light);
    z-index: 1000;
    opacity: 0; /* Empieza oculto */
    transition: opacity 0.5s ease-out, transform 0.5s ease-out; /* Transición para aparecer y desaparecer */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
    text-align: center;
    min-width: 300px;
    max-width: 90%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Estado cuando la alerta está visible (establecido por JS) */
.alerta-flotante[style*="opacity: 1"] {
    transform: translateX(-50%) translateY(0); /* Vuelve a la posición original */
    opacity: 1;
}

.alerta-buena {
    background-color: rgba(30, 150, 80, 0.9);
    border: 1px solid #4CAF50;
    box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
}

.alerta-mala {
    background-color: rgba(200, 50, 50, 0.9);
    border: 1px solid #F44336;
    box-shadow: 0 0 15px rgba(244, 67, 54, 0.5);
}

/* --- Media Queries para Responsividad (Tabla Mejorada y General) --- */

@media (max-width: 768px) {
    .contenedor, .contenedor-tabla {
        padding: 1.5rem; /* Ajustado para más compactación */
        margin: 1.5rem auto;
        width: 95%;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.7), 0 0 15px var(--accent-blue) inset; /* Sombra un poco más suave */
    }

    .titulo {
        font-size: 1.8rem;
        margin-bottom: 1rem; /* Menos margen inferior */
    }

    .product-form {
        padding: 1rem;
        gap: 0.8rem; /* Espaciado más compacto */
    }

    .formularios-label {
        font-size: 0.95rem; /* Etiqueta un poco más pequeña */
    }

    .formulario-input, .submit-button, #buscar {
        padding: 0.8rem;
        font-size: 0.95rem;
    }

    .submit-button {
        padding: 0.9rem 1.2rem; /* Botón un poco más pequeño */
        font-size: 1rem;
    }

    #buscador {
        margin-bottom: 1.5rem; /* Menos margen inferior */
    }

    #titulo-buscar {
        font-size: 1rem; /* Título de búsqueda más pequeño */
    }

    /* --- Tabla Responsiva - Mejoras Visuales --- */
    .tabla-principal {
        border: none;
        box-shadow: none;
        background-color: transparent; /* Fondo transparente para que las "tarjetas" individuales resalten */
    }

    .tabla-principal thead {
        display: none; /* Oculta la cabecera en móvil */
    }

    .tabla-principal tbody {
        display: block; /* Asegura que el tbody se comporte como bloque */
        width: 100%;
    }

    .tabla-principal tr {
        display: flex; /* Utiliza flexbox para la fila como una "tarjeta" */
        flex-direction: column; /* Apila los elementos verticalmente */
        margin-bottom: 1.2rem; /* Espacio entre cada "tarjeta" de fila */
        border: 1px solid var(--accent-blue);
        border-radius: 10px;
        overflow: hidden;
        background-color: var(--primary-dark); /* Fondo para cada "tarjeta" */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6), 0 0 10px rgba(15, 52, 96, 0.4) inset; /* Sombra más pronunciada */
        padding: 1rem 1.2rem; /* Padding interno de cada tarjeta */
    }

    .tabla-principal tr:nth-child(even) {
        background-color: var(--primary-dark); /* Mantener el mismo fondo o un ligero matiz */
    }

    .tabla-principal tr:hover {
        background-color: rgba(233, 69, 96, 0.1); /* Hover sutil en toda la tarjeta */
        border-color: var(--highlight-neon); /* Borde de hover */
        box-shadow: 0 4px 20px rgba(233, 69, 96, 0.4), 0 0 15px var(--highlight-neon) inset; /* Sombra de hover más viva */
    }

    .tabla-principal td {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Centra verticalmente etiqueta y valor */
        padding: 0.6rem 0; /* Padding vertical para cada par etiqueta-valor */
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1); /* Línea punteada para separar campos */
        text-align: right;
        font-size: 0.95rem; /* Tamaño de fuente para el valor */
        color: var(--text-light); /* Color del texto del valor */
    }
    
    .tabla-principal td:last-child {
        border-bottom: none; /* Sin borde en la última celda */
        padding-bottom: 0;
    }

    .tabla-principal td:first-child {
        padding-top: 0;
    }

    .tabla-principal td::before {
        content: attr(data-label);
        font-weight: bold;
        color: var(--highlight-neon); /* Etiqueta en color neón */
        text-align: left;
        flex-basis: 40%; /* Ajusta el ancho de la etiqueta */
        flex-shrink: 0;
        padding-right: 1rem;
        font-size: 0.9rem; /* Tamaño de fuente para la etiqueta */
    }

    /* Estilos específicos para la celda de la imagen en móvil */
    .tabla-principal td[data-label="Imagen:"] {
        flex-direction: column; /* Apila la etiqueta y la imagen */
        align-items: center; /* Centra horizontalmente */
        text-align: center;
        padding: 1rem 0; /* Más padding para la sección de imagen */
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1); /* Borde también para imagen */
    }
    .tabla-principal td[data-label="Imagen:"]::before {
        padding-right: 0;
        margin-bottom: 0.8rem; /* Más espacio entre etiqueta y imagen */
        text-align: center;
        flex-basis: auto;
    }
    .tabla-principal td img {
        max-width: 100px; /* Tamaño un poco más grande para la imagen */
        height: auto;
        border-radius: 8px; /* Bordes más redondeados */
        border: 1px solid var(--border-glow); /* Borde que resalta */
        box-shadow: 0 0 8px rgba(233, 69, 96, 0.4); /* Sombra alrededor de la imagen */
    }
}

@media (max-width: 480px) {
    .contenedor, .contenedor-tabla {
        padding: 1rem; /* Aún más compacto */
        margin: 0.8rem auto;
    }

    .titulo {
        font-size: 1.5rem;
    }

    .product-form {
        padding: 0.8rem;
    }

    .formulario-input, .submit-button, #buscar {
        padding: 0.6rem;
        font-size: 0.85rem;
    }

    .tabla-principal tr {
        padding: 0.8rem 1rem; /* Padding más pequeño para las tarjetas de fila */
        margin-bottom: 1rem;
    }

    .tabla-principal td {
        padding: 0.5rem 0; /* Padding más pequeño para las celdas */
        font-size: 0.9rem;
    }

    .tabla-principal td::before {
        flex-basis: 35%; /* Ajuste del ancho de la etiqueta */
        font-size: 0.85rem;
    }

    .tabla-principal td img {
        max-width: 70px; /* Imagen más pequeña */
    }
}


</style>
<body>
    <?php include 'navAdministracion.php'; ?>

    <?php
    // ESTE ES EL ÚNICO LUGAR DONDE SE IMPRIME LA ALERTA
    if (isset($_SESSION['alerta_mensaje']) && isset($_SESSION['alerta_tipo'])) {
        echo "<div id='global-alert' class='alerta-flotante alerta-" . $_SESSION['alerta_tipo'] . "'>" . $_SESSION['alerta_mensaje'] . "</div>";
        unset($_SESSION['alerta_mensaje']); // Limpia la alerta después de mostrarla
        unset($_SESSION['alerta_tipo']);
    }
    ?>

    <div class="contenedor">
        <h1 class="titulo">Agregar Productos</h1>
        <form action="panelTrabajador.php" method="post" enctype="multipart/form-data" class="product-form" onsubmit="return validarFormularioJuegos()">
            <div class="formularios">
                <label for="titulo" class="formularios-label">Titulo:</label>
                <input type="text" name="titulo" id="titulo" placeholder="Ingrese el Titulo del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="descripcion" class="formularios-label">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la Descripcion del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="precio" class="formularios-label">Precio:</label>
                <input type="number" name="precio" id="precio" placeholder="Ingrese el Precio del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="stock" class="formularios-label">Stock:</label>
                <input type="number" name="stock" id="stock" placeholder="Ingrese el Stock del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="imagen" class="formularios-label">Imagen:</label>
                <input type="file" id="imagen" name="imagen" required class="formulario-input">
                <img id="imagen-preview" src="" alt="Preview Image" style="max-width: 200px; display: none;">
            </div>
            <input type="submit" value="Publicar Videojuego" class="submit-button">
        </form>
    </div>
    
    <div class="contenedor-tabla">
        <h1 class="titulo">Listado de Juegos</h1>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Pedido</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese ID del Juego a Buscar">
        </div>
        <?php if (!empty($juegos)) { ?>
            <table class="tabla-principal">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($juegos as $juego) { ?>
                        <tr>
                            <td data-label="ID:"><?php echo $juego['idJuego']; ?></td>
                            <td data-label="Imagen:"><img src="../<?php echo $juego['imagen']; ?>" width="150px" alt="Imagen del Juego"></td>
                            <td data-label="Nombre:"><?php echo $juego['titulo']; ?></td>
                            <td data-label="Stock:"><?php echo $juego['stock']; ?></td>
                            <td data-label="Precio:"><?php echo number_format($juego['precio'], 0, '', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-pedidos">No se encontraron juegos.</p>
        <?php } ?>
    </div>
    <script>
        document.getElementById('imagen').addEventListener('change', function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagen-preview').src = e.target.result;
                    document.getElementById('imagen-preview').style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        // JavaScript para que las alertas desaparezcan automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const alertElement = document.getElementById('global-alert');
            if (alertElement) {
                // Si la alerta tiene opacidad 0 inicial, la hacemos 1 para la transición de entrada
                alertElement.style.opacity = '1';
                alertElement.style.transform = 'translateX(-50%) translateY(0)'; // Asegurar que está en la posición final

                setTimeout(() => {
                    alertElement.style.transition = 'opacity 0.5s ease-out, transform 0.3s ease-in';
                    alertElement.style.opacity = '0';
                    alertElement.style.transform = 'translateX(-50%) translateY(-20px)'; // Pequeño movimiento hacia arriba al desaparecer

                    setTimeout(() => {
                        alertElement.remove(); // Elimina el elemento después de que la transición termine
                    }, 500); // Coincide con la duración de la transición de opacidad
                }, 3000); // Muestra la alerta por 3 segundos
            }
        });
    </script>
</body>
</html>