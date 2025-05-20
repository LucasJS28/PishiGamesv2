<?php
session_start();
require_once 'conexiones/Productos.php';

// Crear una instancia de la clase Productos
$productos = new Productos();
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

// Initialize message variables to be used for the alert system
$message = '';
$message_type = ''; // 'success' or 'error'

// Obtener la lista de juegos agregados
$listaJuegos = $productos->mostrarProductos();
$listaJuegosSinStock = $productos->mostrarProductosSinStock();

// Verificar si se ha agregado algún producto al carrito
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = array(); // Crear un carrito vacío
}

// Verificar si se ha enviado el formulario de agregar al carrito (AJAX POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarCarrito'])) {
    $idJuego = $_POST['idJuego'];

    // Verificar si el juego ya está en el carrito
    if (array_key_exists($idJuego, $carrito)) {
        // Verificar si hay suficiente stock antes de incrementar la cantidad
        if ($productos->verificarStock($idJuego, $carrito[$idJuego]['cantidad'] + 1)) {
            $carrito[$idJuego]['cantidad']++; // Incrementar la cantidad si hay suficiente stock
            $message = "Se añadió una nueva copia al Carro. Cantidad: " . $carrito[$idJuego]['cantidad'];
            $message_type = 'success';
        } else {
            $message = "No hay suficiente stock";
            $message_type = 'error';
        }
    } else {
        // Obtener los detalles del producto según el ID
        $juego_to_add = $productos->obtenerProducto($idJuego); // Renamed to avoid conflict with $juego lower down

        // Verificar si se encontró el producto
        if ($juego_to_add) {
            // Verificar si hay suficiente stock antes de agregar el producto al carrito
            if ($productos->verificarStock($idJuego, 1)) {
                $carrito[$idJuego] = array(
                    'titulo' => $juego_to_add['titulo'],
                    'descripcion' => $juego_to_add['descripcion'],
                    'imagen' => $juego_to_add['imagen'],
                    'precio' => $juego_to_add['precio'],
                    'cantidad' => 1
                );
                $message = "Se añadió al Carrito Cantidad:1";
                $message_type = 'success';
            } else {
                $message = "No hay suficiente stock";
                $message_type = 'error';
            }
        } else {
            $message = "Producto no encontrado."; // Handle case where product ID is invalid
            $message_type = 'error';
        }
    }
    // Guardar el carrito en la sesión
    $_SESSION['carrito'] = $carrito;

    // Output JSON response for AJAX
    header('Content-Type: application/json'); // Tell the browser to expect JSON
    echo json_encode(['message' => $message, 'type' => $message_type]);
    exit; // Stop execution after sending the JSON response
}

// Obtener el valor seleccionado del formulario
$ordenarPor = isset($_GET['ordenarPor']) ? $_GET['ordenarPor'] : null;

// Ordenar la lista de juegos según el valor seleccionado
switch ($ordenarPor) {
    case 'nombreAscendente':
        usort($listaJuegos, function ($a, $b) {
            return strcmp($a['titulo'], $b['titulo']);
        });
        break;
    case 'nombreDescendente':
        usort($listaJuegos, function ($a, $b) {
            return strcmp($b['titulo'], $a['titulo']);
        });
        break;
    case 'precioAscendente':
        usort($listaJuegos, function ($a, $b) {
            return $a['precio'] - $b['precio'];
        });
        break;
    case 'precioDescendente':
        usort($listaJuegos, function ($a, $b) {
            return $b['precio'] - $a['precio'];
        });
        break;
    default:
        // No se ha seleccionado ningún valor, mantener el orden original
        break;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pishi Games</title>
    <link rel="stylesheet" href="estilos/style.css">
    <script src="scripts/scripts.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

    <style>
        /* --- Alert Messages (Toast Notifications) --- */
        #message-container {
            position: fixed; /* Fixed position in viewport */
            top: 25px; /* Distance from top */
            left: 50%; /* Start at 50% from left */
            transform: translateX(-50%); /* Center horizontally */
            width: 90%;
            max-width: 450px; /* Max width for messages */
            z-index: 1000; /* Ensure it's on top */
            pointer-events: none; /* Allows clicks to pass through */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center messages within the container */
            gap: 10px; /* Space between multiple messages */
        }

        .alert-message {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            opacity: 0; /* Start hidden for animation */
            animation: fadeInOut 4s forwards; /* Animation name, duration, fill-mode */
            pointer-events: auto; /* Re-enable pointer events for the message itself */
            position: relative; /* Needed for transform */
            transform: translateY(-20px); /* Start slightly above */
            width: 100%; /* Take full width of container */
            box-sizing: border-box; /* Include padding in width */
        }

        /* Original colors you seemed to use */
        .alert-message.success {
            background-color: #4CAF50; /* Green for success */
            color: white;
        }

        .alert-message.error {
            background-color: #f44336; /* Red for error */
            color: white;
        }

        /* Keyframe animation for fade-in and fade-out */
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); } /* Start invisible, slightly above */
            10% { opacity: 1; transform: translateY(0); } /* Fade in and move to position */
            90% { opacity: 1; transform: translateY(0); } /* Stay visible */
            100% { opacity: 0; transform: translateY(-20px); } /* Fade out and move up */
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div id="message-container">
        </div>

    <div id="contenedorBuscar">
        <label for="buscar">Buscar Juego</label>
        <input type="search" name="buscar" id="buscar" placeholder="Ingrese el Nombre del Juego a buscar">
    </div>
    <form id="filtroForm" action="tienda.php" method="GET">
        <label for="ordenarPor" id="tituloordenar">Filtrar</label>
        <select name="ordenarPor" id="ordenarPor">
            <option value="nombreAscendente" <?php echo ($ordenarPor == 'nombreAscendente') ? 'selected' : ''; ?>>Nombre (Ascendente)</option>
            <option value="nombreDescendente" <?php echo ($ordenarPor == 'nombreDescendente') ? 'selected' : ''; ?>>Nombre (Descendente)</option>
            <option value="precioAscendente" <?php echo ($ordenarPor == 'precioAscendente') ? 'selected' : ''; ?>>Precio (Ascendente)</option>
            <option value="precioDescendente" <?php echo ($ordenarPor == 'precioDescendente') ? 'selected' : ''; ?>>Precio (Descendente)</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>
    <ul class="listaJuegos">
        <?php foreach ($listaJuegos as $juego) { ?>
            <li class="Juegos juego <?php echo ($juego['stock'] == 0) ? 'sin-stock' : ''; ?>">
                <a href="detalles_juego.php?id=<?php echo $juego['idJuego']; ?>">
                    <div class="juego-container">
                        <h4 class="titulo"><?php echo htmlspecialchars($juego['titulo']); ?></h4>
                        <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                        <a href="detalles_juego.php?id=<?php echo $juego['idJuego']; ?>"><img class="imagen" src="<?php echo htmlspecialchars($juego['imagen']); ?>" alt="Imagen del juego"></a>
                        <p class="precio"><span style="color:#3A84F4">Precio:</span> <?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
                        <p class="stock">Stock: <?php echo $juego['stock']; ?></p>
                        <button class="agregar-carrito" data-id="<?php echo $juego['idJuego']; ?>" <?php echo ($juego['stock'] == 0) ? 'disabled' : ''; ?>>
                            <?php echo ($juego['stock'] == 0) ? 'Producto sin Stock' : 'Agregar al Carrito'; ?>
                        </button>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
    <h2 id="titulosinStock">Juegos sin Stock</h2>
    <ul class="listaJuegos">
        <?php foreach ($listaJuegosSinStock as $juego) { ?>
            <li class="Juegos juego sin-stock">
                <div class="juego-container">
                    <h4 class="titulo"><?php echo htmlspecialchars($juego['titulo']); ?></h4>
                    <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                    <img class="imagen" src="<?php echo htmlspecialchars($juego['imagen']); ?>" alt="Imagen del juego">
                    <p class="precio">Precio: <?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
                    <p class="stock">Stock: 0</p>
                    <button class="agregar-carrito" data-id="<?php echo $juego['idJuego']; ?>" disabled>Producto sin Stock</button>
                </div>
            </li>
        <?php } ?>
    </ul>
    <script>
        /**
         * Displays a temporary alert message on the page.
         * The message will fade in, stay for a moment, and then fade out.
         * @param {string} message - The text content of the alert.
         * @param {string} type - The type of alert ('success' or 'error') to apply specific styling.
         */
        function showMessage(message, type) {
            const container = document.getElementById('message-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert-message ${type}`;
            alertDiv.textContent = message;

            container.appendChild(alertDiv);

            // The CSS animation (fadeInOut) handles the visual effect.
            // We remove the element from the DOM after the animation completes.
            alertDiv.addEventListener('animationend', () => {
                alertDiv.remove();
            }, { once: true }); // 'once: true' ensures the event listener is removed after it fires
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Event delegation for "Agregar al Carrito" buttons
            document.querySelectorAll('.listaJuegos').forEach(function(list) {
                list.addEventListener('click', function(event) {
                    const targetButton = event.target.closest('.agregar-carrito');

                    // Ensure the clicked element is the button and it's not disabled
                    if (targetButton && !targetButton.disabled) {
                        event.preventDefault(); // Prevent default button behavior (e.g., submitting a form normally if it was inside a form tag)
                        event.stopPropagation(); // Prevent the click from bubbling up to the <a> tag

                        const idJuego = targetButton.dataset.id; // Get the game ID from data-id attribute

                        // Use Fetch API for AJAX request
                        fetch('tienda.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'agregarCarrito=true&idJuego=' + idJuego
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json(); // Expect JSON response
                        })
                        .then(data => {
                            if (data.message) {
                                showMessage(data.message, data.type);
                            }
                            // If you need to update stock visually on the page, you would do it here.
                            // For example, if 'data' returned the new stock, you could update the relevant P tag.
                            // e.g., if data.newStock is returned:
                            // const stockElement = targetButton.parentNode.querySelector('.stock');
                            // if (stockElement) {
                            //     stockElement.textContent = 'Stock: ' + data.newStock;
                            //     if (data.newStock == 0) {
                            //         targetButton.disabled = true;
                            //         targetButton.textContent = 'Producto sin Stock';
                            //         targetButton.closest('.juego').classList.add('sin-stock');
                            //     }
                            // }
                        })
                        .catch(error => {
                            console.error('Error al agregar al carrito:', error);
                            showMessage('Error al agregar al carrito.', 'error');
                        });
                    }
                });
            });

            // Re-apply selected option on filter form for persistence
            const ordenarPorSelect = document.getElementById('ordenarPor');
            if (ordenarPorSelect) {
                const urlParams = new URLSearchParams(window.location.search);
                const currentOrdenarPor = urlParams.get('ordenarPor');
                if (currentOrdenarPor) {
                    ordenarPorSelect.value = currentOrdenarPor;
                }
            }

            // Client-side search functionality (if 'scripts/scripts.js' doesn't already handle it)
            const searchInput = document.getElementById('buscar');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('.listaJuegos .juego').forEach(function(gameCard) {
                        const titleElement = gameCard.querySelector('.titulo');
                        if (titleElement) {
                            const title = titleElement.textContent.toLowerCase();
                            if (title.includes(searchTerm)) {
                                gameCard.style.display = ''; // Show the card
                            } else {
                                gameCard.style.display = 'none'; // Hide the card
                            }
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>