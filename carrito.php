<?php
require_once 'acciones_carrito.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="estilos/styles2.css">
    <script src="scripts/scripts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<style>
   /* --- Shopping Cart Specific Styles --- */

.heading {
    text-align: center;
    font-size: 2.8rem; /* Larger font for emphasis */
    color: #80cbc4; /* Teal color to match theme */
    margin: 2.5rem auto; /* More vertical space */
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 0 0 15px rgba(128, 203, 196, 0.5); /* Subtle glow effect */
}

.table {
    width: 90%;
    max-width: 1000px;
    margin: 2rem auto;
    border-collapse: collapse;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    overflow: hidden;
}

.table-row {
    border-bottom: 1px solid #333;
}

.table-row:last-child {
    border-bottom: none;
}

.table-header {
    background-color: #1e1e1e;
    color: #80cbc4;
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    text-transform: uppercase;
    font-size: 0.9rem;
}

.table-cell {
    padding: 1rem;
    background-color: #1e1e1e;
    color: #e0e0e0;
    vertical-align: middle;
    border-right: 1px solid #333;
    /* Ensure text wraps within the cell */
    word-wrap: break-word; /* Allows long words to break */
    white-space: normal; /* Ensures text wraps naturally */
}

.table-cell:last-child {
    border-right: none;
}

.table tbody .table-row:nth-child(even) .table-cell {
    background-color: #2a2a2a;
}

.product-image {
    width: 80px;
    height: auto;
    border-radius: 5px;
    object-fit: cover;
}

#butons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center; /* Center buttons if they wrap */
}

.button {
    display: inline-block;
    padding: 0.6rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.button.add {
    background-color: #4caf50;
    color: #121212;
    border: none;
}

.button.add:hover {
    background-color: #66bb6a;
}

.button.remove {
    background-color: #ff9800;
    color: #121212;
    border: none;
}

.button.remove:hover {
    background-color: #ffa726;
}

.button.delete {
    background-color: #f44336;
    color: #ffffff;
    border: none;
}

.button.delete:hover {
    background-color: #ef5350;
}

/* Style for the quantity span */
.table-cell span {
    font-size: 1.1rem;
}

/* Total row styling */
.table tfoot .table-row {
    background-color: #1e1e1e;
    font-weight: bold;
    color: #80cbc4;
    border-top: 2px solid #80cbc4;
}

.table tfoot .table-cell {
    padding: 1rem;
    background-color: transparent;
    color: inherit;
}

.table tfoot .table-cell:first-child {
    text-align: right;
    /* Ensure "Total" text is aligned right */
    padding-right: 2rem; /* Add some padding for better alignment */
}

/* Historial de Pedidos button/link */
.HistorialPedidos {
    display: block; /* Change to block to center easily */
    margin: 1.5rem auto;
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, #80cbc4, #4db6ac);
    color: #121212;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 8px rgba(128, 203, 196, 0.6);
    text-align: center; /* Center the text inside the button */
    max-width: 250px; /* Limit width */
}

.HistorialPedidos:hover {
    background: linear-gradient(135deg, #4db6ac, #80cbc4);
    box-shadow: 0 6px 12px rgba(128, 203, 196, 0.8);
}


/* "Realizar compra" button (outside the modal) */
#realizar-compra {
    display: block;
    width: 90%;
    max-width: 300px;
    margin: 1.5rem auto;
    padding: 0.8rem 2rem;
    background: linear-gradient(135deg, #3A84F4, #1E62D0);
    color: white;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    font-size: 1.1rem;
    box-shadow: 0 4px 8px rgba(58, 132, 244, 0.6);
}

#realizar-compra:hover {
    background: linear-gradient(135deg, #1E62D0, #3A84F4);
    box-shadow: 0 6px 12px rgba(58, 132, 244, 0.8);
}


/* Modal Overlay */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    display: none;
    backdrop-filter: blur(5px);
}

.modal-overlay.active {
    display: block;
}

/* Modal Content (Purchase Form Popup) */
.formulario-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #1e1e1e;
    color: #e0e0e0;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.8);
    z-index: 1001;
    display: none;
    width: 90%;
    max-width: 500px;
    overflow-y: auto;
    max-height: 90vh;
}

.formulario-popup.active {
    display: block;
}

.formulario-popup h3 {
    color: #80cbc4;
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
}

.formulario-popup label {
    display: block;
    font-size: 1rem;
    color: #b2dfdb;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.formulario-popup input[type="text"],
.formulario-popup input[name="total"] {
    width: 100%;
    padding: 0.8rem;
    font-size: 1rem;
    border-radius: 8px;
    border: 1.5px solid #80cbc4;
    background-color: #2a2a2a;
    color: #e0e0e0;
    margin-bottom: 1.5rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.formulario-popup input[type="text"]:focus,
.formulario-popup input[name="total"]:focus {
    outline: none;
    border-color: #3A84F4;
    box-shadow: 0 0 8px rgba(58, 132, 244, 0.6);
}

/* Disable the total input visually */
.formulario-popup input[name="total"] {
    cursor: default;
    opacity: 0.8;
}


.formulario-popup button {
    display: block;
    width: 100%;
    padding: 0.8rem;
    font-size: 1.1rem;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    margin-top: 1rem;
}

#realizarr-compra {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    color: white;
    box-shadow: 0 4px 8px rgba(76, 175, 80, 0.6);
}

#realizarr-compra:hover {
    background: linear-gradient(135deg, #388e3c, #4caf50);
    box-shadow: 0 6px 12px rgba(76, 175, 80, 0.8);
}

#cancelar-compra {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
    box-shadow: 0 4px 8px rgba(244, 67, 54, 0.6);
}

#cancelar-compra:hover {
    background: linear-gradient(135deg, #d32f2f, #f44336);
    box-shadow: 0 6px 12px rgba(244, 67, 54, 0.8);
}


/* Centered text messages (like "No hay productos" or "Debes iniciar sesión") */
.centered-text {
    text-align: center;
    font-size: 1.2rem;
    color: #b2dfdb;
    margin: 2rem auto;
}

.centered-text a {
    color: #80cbc4;
    text-decoration: none;
    transition: color 0.3s ease;
}

.centered-text a:hover {
    color: #a7ffeb;
    text-decoration: underline;
}

/* "Volver a la tienda" button at the bottom */
body > .button {
    display: block;
    width: 90%;
    max-width: 300px;
    margin: 2rem auto;
    padding: 0.8rem 2rem;
    background: linear-gradient(135deg, #80cbc4, #4db6ac);
    color: #121212;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    font-size: 1.1rem;
    box-shadow: 0 4px 8px rgba(128, 203, 196, 0.6);
    text-align: center;
}

body > .button:hover {
    background: linear-gradient(135deg, #4db6ac, #80cbc4);
    box-shadow: 0 6px 12px rgba(128, 203, 196, 0.8);
}

/* Responsive adjustments for table */
@media (max-width: 768px) {
    .table {
        display: block;
        overflow-x: auto;
    }

    .table-header {
        white-space: nowrap;
    }

    .table-cell {
        white-space: normal; /* Allow text to wrap on small screens */
        word-wrap: break-word;
    }

    .product-image {
        width: 50px;
    }

    #butons {
        flex-direction: column;
        gap: 0.3rem;
    }

    .button {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }

    .table-cell {
        padding: 0.8rem;
    }

    .responsive-table {
        border: 0;
    }

    .responsive-table thead {
        display: none;
    }

    .responsive-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #444;
        border-radius: 10px;
        overflow: hidden;
        background-color: #1e1e1e;
    }

    .responsive-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #333;
        font-size: 0.9rem;
        color: #e0e0e0;
    }

    .responsive-table td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #80cbc4;
        text-transform: uppercase;
        margin-right: 1rem;
    }

    .responsive-table td:last-child {
        border-bottom: none;
    }
}

.table-container {
    width: 100%;
    overflow-x: auto;
    padding: 0 1rem;
    box-sizing: border-box;
}

@media (max-width: 768px) {
    .responsive-table tr {
        display: block;
        width: 100%;
    }

    .responsive-table td {
        display: flex;
        width: 100%;
        box-sizing: border-box;
        padding: 0.75rem 1rem;
    }
}

</style>

<body>
     <?php include 'nav.php'; ?>

    <h2 class="heading">Carrito de compras</h2>
    <!-- Habilita el boton de historial de pedidos si es que el usuario tiene una sesion iniciaca -->
    <?php if (isset($_SESSION['idUsuario'])) { ?>
        <form method="POST" action="historialPedidos.php">
            <a class="HistorialPedidos" href="historialPedidos.php">Ir al Historial de Pedidos</a>
        </form>
    <?php } ?>
    <style>
        <?php if (!isset($_SESSION['idUsuario'])) { ?>.HistorialPedidos {
            display: none;
        }

        <?php } ?>
    </style>
    <!-- Muestra los Productos que fueron Añadidos al Carro -->
    <?php if (!empty($carrito)) { ?>
        <div class="table-container">
        <table class="table responsive-table">
            <thead>
                <tr class="table-row">
                    <th class="table-header">Producto</th>
                    <th class="table-header">Imagen</th>
                    <th class="table-header">Descripción</th>
                    <th class="table-header">Precio</th>
                    <th class="table-header">Cantidad</th>
                    <th class="table-header">Subtotal</th>
                    <th class="table-header">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0; // Agregar esta línea para inicializar $total
                foreach ($carrito as $idJuego => $juego) {
                    $subtotal = $juego['precio'] * $juego['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr class="table-row">
                        <td class="table-cell"><?php echo $juego['titulo']; ?></td>
                        <td class="table-cell"><img class="product-image" src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['titulo']; ?>"></td>
                        <td class="table-cell"><?php echo $juego['descripcion']; ?></td>
                        <td class="table-cell"><?php echo number_format($juego['precio'], 0, '', '.'); ?></td>
                        <td class="table-cell">
                            <!-- se envía una solicitud a "acciones_carrito.php" con los parámetros "id" y "action" establecidos en los valores correspondientes -->
                            <span style="color: yellow; font-weight: 600;"> <?php echo $juego['cantidad']; ?></span>
                        </td>
                        <td class="table-cell"><?php echo number_format($subtotal, 0, '', '.'); ?></td>
                        <td class="table-cell">
                            <div id="butons">
                                <a class="button add" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=add">+</a>
                                <a class="button remove" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=remove">-</a>
                                <a class="button delete" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=delete">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr class="table-row">
                    <td class="table-cell" colspan="6">Total</td>
                    <td class="table-cell"><?php echo number_format($total, 0, '', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
        </div>

        <!-- Crea el formulario de venta para posteriormente hacerlo aparecer o desaparecer -->
        <?php if (isset($_SESSION['idUsuario'])) { ?>
            <form class="formulario-compra" method="POST" action="carrito.php">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button id="realizar-compra" class="button" type="submit" name="comprar">Realizar compra</button>
            </form>
            <div id="modal-overlay" class="modal-overlay"></div>
            <div id="modal-content" class="formulario-popup">
                <form class="formulario-compra" method="POST" action="carrito.php">
                    <br>
                    <h3>Formulario de Compra</h3>
                    <label for="total">Total a Pagar</label>
                    <input name="total" value="<?php echo $total; ?>">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="txtnombre" required>
                    <label for="direccion">Numero de Tarjeta</label>
                    <input type="text" id="tarjeta" name="tarjeta" class="txtTarjeta" required>
                    <label for="ciudad">CVV</label>
                    <input type="text" id="CVV" name="CVV" class="CVV" required>
                    <label for="pais">Codigo Postal</label>
                    <input type="text" id="cPostal" name="cPostal" class="cPostal" required>
                    <button id="realizarr-compra" type="submit" name="comprar">Realizar compra</button>
                    <button id="cancelar-compra" type="button">Cancelar compra</button>
                    <br>
                    <br>
                </form>
            </div>
        <?php } else { ?>
            <p class="centered-text"><a href="index.php">Debes iniciar sesión para realizar la compra.</a></p>
        <?php } ?>

    <?php } else { ?>
        <p class="centered-text">No hay productos en el carrito.</p>
    <?php } ?>

    <a class="button" href="tienda.php">Volver a la tienda</a>

    <script>
        // JavaScript para mostrar y ocultar el formulario de compra
        document.addEventListener("DOMContentLoaded", function() {
            var modalOverlay = document.getElementById("modal-overlay");
            var modalContent = document.getElementById("modal-content");
            var realizarCompraButton = document.getElementById("realizar-compra");
            var cancelarCompraButton = document.getElementById("cancelar-compra");

            // Evento de clic para mostrar el formulario de compra
            realizarCompraButton.addEventListener("click", function(e) {
                e.preventDefault();
                modalOverlay.classList.add("active"); // Agrega la clase "active" al modal-overlay para mostrarlo
                modalContent.classList.add("active"); // Agrega la clase "active" al modal-content para mostrarlo
            });

            // Evento de clic para cancelar la compra y ocultar el formulario
            cancelarCompraButton.addEventListener("click", function() {
                modalOverlay.classList.remove("active"); // Remueve la clase "active" del modal-overlay para ocultarlo
                modalContent.classList.remove("active"); // Remueve la clase "active" del modal-content para ocultarlo
            });

            // Evento de clic en el fondo del modal para ocultar el formulario
            modalOverlay.addEventListener("click", function() {
                modalOverlay.classList.remove("active"); // Remueve la clase "active" del modal-overlay para ocultarlo
                modalContent.classList.remove("active"); // Remueve la clase "active" del modal-content para ocultarlo
            });
        });
    </script>

</body>

</html>