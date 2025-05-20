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

// Variable to hold the message to display
$message = '';
$message_type = ''; // 'success' or 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarCarrito'])) {
    $idJuego = $_POST['idJuego'];

    if (array_key_exists($idJuego, $_SESSION['carrito'])) {
        if ($productos->verificarStock($idJuego, $_SESSION['carrito'][$idJuego]['cantidad'] + 1)) {
            $_SESSION['carrito'][$idJuego]['cantidad']++;
            $message = "Se añadió una nueva copia al Carro. Cantidad: " . $_SESSION['carrito'][$idJuego]['cantidad'];
            $message_type = 'success';
        } else {
            $message = "No hay suficiente stock";
            $message_type = 'error';
        }
    } else {
        $juego_to_add = $productos->obtenerProducto($idJuego); // Renamed to avoid conflict with $juego lower down

        if ($juego_to_add) {
            if ($productos->verificarStock($idJuego, 1)) {
                $_SESSION['carrito'][$idJuego] = array(
                    'titulo' => $juego_to_add['titulo'],
                    'descripcion' => $juego_to_add['descripcion'],
                    'imagen' => $juego_to_add['imagen'],
                    'precio' => $juego_to_add['precio'],
                    'cantidad' => 1
                );
                $message = "Se añadió al Carrito Cantidad: 1";
                $message_type = 'success';
            } else {
                $message = "No hay suficiente stock";
                $message_type = 'error';
            }
        }
    }
    // No exit here, we want to render the page with the message
}

$idJuego = isset($_GET['id']) ? $_GET['id'] : null;

$juego = $productos->obtenerProducto($idJuego);
if (!$juego) {
    // If no game ID is provided or game not found, redirect to the store
    header("Location: tienda.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pishi Games - Detalles de <?php echo htmlspecialchars($juego['titulo']); ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
    <style>
        /* CSS Variables for easy theme management */
        :root {
            --bg-color: #1a1a2e; /* Dark background */
            --card-bg: #16213e; /* Slightly lighter card background */
            --border-color: #0f3460; /* Dark blue border */
            --primary-text: #e0e0e0; /* Light gray for main text */
            --secondary-text: #b2dfdb; /* Teal light for secondary text */
            --highlight-color: #a7ffeb; /* Vibrant cyan for titles/highlights */
            --price-color: #80cbc4; /* Muted teal for price */
            --stock-color: #ffd54f; /* Amber for stock */
            --button-bg: #80cbc4; /* Teal for button */
            --button-text: #121212; /* Dark text for button */
            --button-hover: #4db6ac; /* Darker teal for button hover */
            --success-bg: #388e3c; /* Green for success messages */
            --success-text: #e8f5e9; /* Light text for success */
            --error-bg: #d32f2f; /* Red for error messages */
            --error-text: #ffebee; /* Light text for error */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--primary-text);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Main container for the game details */
        .contenedorjuegoxd {
            flex-grow: 1; /* Allows it to take up available vertical space */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: flex-start; /* Align to top */
            padding: 2rem 1rem;
            max-width: 1200px; /* Max width for the content area */
            margin: 0 auto; /* Center the container */ /* Take full width within its parent */
        }

        /* Styling for the game detail card */
        .juego-detalle {
            background-color: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 2.5rem;
            width: 100%;
            max-width: 90vw; /* Limit card width to 90% of viewport */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column; /* Default to column stacking for mobile */
            gap: 2.5rem; /* Space between content sections */
            align-items: center; /* Center items horizontally in column layout */
            position: relative;
            overflow: hidden; /* Ensures borders/shadows are clean */
        }

        nav   {  width: 90% !important;}

        /* Container for image and title (left side on PC) */
        .juego-media {
            flex: 1.2; /* Takes slightly more horizontal space on PC */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content in column layout */
            text-align: center; /* Center text in column layout */
        }

        /* Container for description, price, stock, and button (right side on PC) */
        .juego-info {
            flex: 1; /* Takes slightly less horizontal space on PC */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes content and button to ends */
            text-align: left; /* Default text align */
        }

        /* Game Title */
        .juego-detalle h2 {
            color: var(--highlight-color);
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            word-break: break-word; /* Prevents long words from overflowing */
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Subtle text shadow */
        }

        /* Game Image */
        .juego-detalle img {
            width: 100%;
            max-width: 500px; /* Max width for image on PC */
            height: auto; /* Allow height to adjust naturally */
            object-fit: contain; /* Ensures the entire image is visible, no cropping */
            aspect-ratio: auto; /* Allows image to retain its original aspect ratio */
            border-radius: 10px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        /* Game Description */
        .juego-detalle p.descripcion {
            color: var(--secondary-text);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-top: 0;
            margin-bottom: 2rem;
            text-align: left;
        }

        /* Game Price */
        .juego-detalle .precio {
            font-size: 2rem;
            color: var(--price-color);
            font-weight: 700;
            text-align: right; /* Default align for price */
            margin-top: 1rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Game Stock */
        .juego-detalle .stock {
            font-size: 1.2rem;
            color: var(--stock-color);
            font-weight: 600;
            text-align: right; /* Default align for stock */
            margin-top: 0.5rem;
            margin-bottom: 2.5rem; /* Space above button */
        }

        /* Add to Cart Form */
        .juego-detalle form {
            margin-top: auto; /* Pushes the form to the bottom of the flex item */
            display: flex;
            justify-content: flex-end; /* Default align for button */
            width: 100%;
        }

        /* Add to Cart Button */
        .juego-detalle button {
            background: linear-gradient(45deg, var(--button-bg), var(--button-hover)); /* Gradient background */
            color: var(--button-text);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.15rem;
            font-weight: 600;
            border-radius: 50px; /* Pill shape */
            cursor: pointer;
            transition: all 0.3s ease; /* Smooth transitions for hover effects */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            display: flex; /* Use flex to align icon and text */
            align-items: center;
            gap: 10px; /* Space between icon and text */
        }

        .juego-detalle button:hover {
            background: linear-gradient(45deg, var(--button-hover), var(--button-bg)); /* Reverse gradient on hover */
            transform: translateY(-3px) scale(1.02); /* Lift and slightly enlarge */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6); /* More prominent shadow on hover */
        }

        .juego-detalle button i {
            margin-right: 0; /* Adjusted for gap property */
            font-size: 1.3rem;
        }

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

        .alert-message.success {
            background-color: var(--success-bg);
            color: var(--success-text);
        }

        .alert-message.error {
            background-color: var(--error-bg);
            color: var(--error-text);
        }

        /* Keyframe animation for fade-in and fade-out */
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); } /* Start invisible, slightly above */
            10% { opacity: 1; transform: translateY(0); } /* Fade in and move to position */
            90% { opacity: 1; transform: translateY(0); } /* Stay visible */
            100% { opacity: 0; transform: translateY(-20px); } /* Fade out and move up */
        }

        /* --- Media Queries (Responsive Design) --- */

        /* For PC screens (larger than 768px) */
        @media (min-width: 769px) {
            .juego-detalle {
                flex-direction: row; /* Arrange items in a row for PC */
                text-align: left; /* Align text within columns */
                align-items: flex-start; /* Align columns to the top */
                gap: 3rem; /* More space between columns */
            }

            .juego-media {
                align-items: flex-start; /* Align image and title to the left */
                padding-right: 1rem; /* Small internal padding */
            }

            .juego-detalle h2 {
                text-align: left;
                font-size: 3.2rem; /* Larger title on PC */
            }

            .juego-detalle img {
                max-width: 450px; /* Optimal image width on PC */
            }

            .juego-info {
                padding-left: 1rem; /* Small internal padding */
            }
            .juego-detalle .precio,
            .juego-detalle .stock {
                text-align: left; /* Align price and stock to the left on PC */
            }

            .juego-detalle form {
                justify-content: flex-start; /* Align button to the left on PC */
            }
        }

        /* For mobile screens (smaller than or equal to 768px) */
        @media (max-width: 768px) {
            .contenedorjuegoxd {
                padding: 1rem;
            }

            .juego-detalle {
                padding: 1.5rem;
                max-width: 95vw;
                flex-direction: column; /* Stack items vertically */
                align-items: center; /* Center content horizontally */
                text-align: center; /* Center text within the box */
                gap: 1.5rem; /* Reduced gap for mobile */
            }

            .juego-detalle h2 {
                font-size: 2.2rem;
                text-align: center;
                margin-bottom: 0.8rem;
            }

            .juego-detalle p.descripcion {
                font-size: 1rem;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .juego-detalle .precio,
            .juego-detalle .stock {
                font-size: 1.1rem;
                text-align: center; /* Center price and stock on small screens */
                margin-top: 0.8rem;
                margin-bottom: 1.5rem;
            }

            .juego-detalle form {
                justify-content: center; /* Center button on small screens */
            }

            .juego-detalle button {
                padding: 0.9rem 1.5rem;
                font-size: 1.05rem;
            }

            .juego-media, .juego-info {
                flex: none; /* Remove flex sizing on mobile */
                width: 100%; /* Take full width */
                padding: 0; /* Remove internal padding on mobile */
            }

            .juego-detalle img {
                max-width: 100%; /* Ensure image scales down on mobile */
                height: auto; /* Allow height to adjust */
                margin-bottom: 1rem;
            }
        }
    </style>
<body>
<?php include 'nav.php'; // Assuming 'nav.php' exists and provides navigation ?>
    <div id="message-container">
        </div>
    <div class="contenedorjuegoxd">
        <div class="juego-detalle">
            <div class="juego-media">
                <h2><?php echo htmlspecialchars($juego['titulo']); ?></h2>
                <img src="<?php echo htmlspecialchars($juego['imagen']); ?>" alt="Imagen del juego">
            </div>
            <div class="juego-info">
                <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                <p class="precio">Precio: $<?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
                <p class="stock">Stock disponible: <?php echo $juego['stock']; ?></p>

                <form method="POST">
                    <input type="hidden" name="idJuego" value="<?php echo $juego['idJuego']; ?>">
                    <button type="submit" name="agregarCarrito">
                        <i class="fas fa-cart-plus"></i> Añadir al Carrito
                    </button>
                </form>
            </div>
        </div>
    </div>

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

            // The CSS animation (fadeInOut) defined in the <style> tag
            // handles the opacity and transform changes automatically.
            // 'forwards' fill-mode ensures the element stays at its final
            // animated state (opacity 0) after the animation completes.
            // The element is not removed from DOM by JS here, it relies on
            // the animation completing and staying invisible.
            // If you want to remove it from the DOM after it disappears,
            // you'd add:
            // alertDiv.addEventListener('animationend', () => {
            //     alertDiv.remove();
            // }, { once: true }); // Use {once: true} to only run it once
        }

        // Check if there's a message from PHP to display when the page loads
        <?php if (!empty($message)): ?>
            showMessage("<?php echo htmlspecialchars($message); ?>", "<?php echo htmlspecialchars($message_type); ?>");
        <?php endif; ?>
    </script>
</body>
</html>