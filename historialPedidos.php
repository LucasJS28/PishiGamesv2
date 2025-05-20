<?php
    session_start();
    include 'nav.php';
    require_once 'conexiones/pedidos.php';
    $pedido = new Pedidos();

    /* Consigue el IDUsuario cuando se realiza el inicio de sesion */
    $idUsuario = $_SESSION['idUsuario'];

    // Obtener los parámetros de orden y filtro de la URL
    $orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'fechaPedido DESC';
    $statusFilter = isset($_GET['status_filter']) && $_GET['status_filter'] !== '' ? $_GET['status_filter'] : null;

    // Llamar a la función mostrarPedidosxUsuario para obtener los pedidos del usuario con los filtros
    $pedidos = $pedido->mostrarPedidosxUsuario($idUsuario, $orderBy, $statusFilter);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<style>
    /* Estilos para el Título de la Lista de Pedidos */
.heading {
    text-align: center;
    color: var(--accent-color, #00bcd4);
    margin-top: 2rem;
    margin-bottom: 1.5rem;
    font-size: 2rem;
    text-shadow: 0 0 8px rgba(0, 188, 212, 0.5);
}

/* Estilos para el Contenedor de Filtros */
.filter-container {
    text-align: center;
    margin-bottom: 2rem;
    padding: 1rem;
    background-color: var(--table-bg-color, #2b2b2b);
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}

.filter-container label {
    color: var(--text-color, #cccccc);
    font-size: 1rem;
    margin-right: 0.5rem;
}

.filter-container select {
    padding: 0.5rem;
    border-radius: 5px;
    border: 1px solid var(--border-color, #555);
    background-color: var(--even-row-bg, #333);
    color: var(--text-color, #cccccc);
    margin-right: 1rem;
    appearance: none; /* Remove default select arrow */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23cccccc%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-6.5%200-12.3%203.2-16.1%208.1-3.9%204.9-4.8%2011.3-2.6%2017.3l139%20228.8c1.9%203.2%205.2%205.2%208.8%205.2s6.9-2%208.8-5.2L289.8%2091.4c2.2-6%201.3-12.4-2.6-17.3z%22%2F%3E%3C%2Fsvg%3E');
    background-repeat: no-repeat;
    background-position: right 0.7em top 50%, 0 0;
    background-size: 0.65em auto, 100%;
}

.filter-container button {
    padding: 0.5rem 1rem;
    background-color: var(--accent-color, #00bcd4);
    color: var(--button-text-color, #1a1a1a);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.filter-container button:hover {
    background-color: var(--accent-hover-color, #0097a7);
}


/* Estilos para la Tabla de Pedidos */
.table-container {
    width: 100%;
    overflow-x: auto; /* Permite scroll horizontal en pantallas pequeñas */
}

.table {
    width: 95%;
    max-width: 1000px;
    margin: 0 auto 2rem auto;
    border-collapse: collapse;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    background-color: var(--table-bg-color, #2b2b2b);
    border-radius: 8px;
    overflow: hidden;
    min-width: 600px; /* Para que no colapse demasiado en pantallas grandes */
}

/* Encabezado */
.table-row:first-child {
    background-color: var(--header-bg-color, #3a3a3a);
    color: var(--header-text-color, #ffffff);
}

.table-header {
    padding: 1rem;
    text-align: left;
    font-weight: bold;
    border-bottom: 1px solid var(--border-color, #555);
}

/* Cuerpo */
.table-row {
    border-bottom: 1px solid var(--border-color, #444);
    transition: background-color 0.3s ease;
}

.table-row:nth-child(even) {
    background-color: var(--even-row-bg, #333);
}

.table-row:nth-child(odd) {
    background-color: var(--odd-row-bg, #2f2f2f);
}

.table-row:hover {
    background-color: var(--hover-row-bg, #4a4a4a);
}

.table-cell {
    padding: 1rem;
    text-align: left;
    color: var(--text-color, #cccccc);
}

/* Texto centrado cuando no hay pedidos */
.centered-text {
    text-align: center;
    color: var(--text-color, #cccccc);
    margin-top: 2rem;
    font-size: 1.1rem;
}

/* Botón "Volver al Carrito" */
.button {
    display: block;
    width: fit-content;
    margin: 2rem auto;
    padding: 0.8rem 1.5rem;
    background-color: var(--accent-color, #00bcd4);
    color: var(--button-text-color, #1a1a1a);
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, opacity 0.3s ease;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
}

.button:hover {
    background-color: var(--accent-hover-color, #0097a7);
    opacity: 0.9;
}

/* Media Queries para Responsividad */

/* Tablets y pantallas medianas */
@media (max-width: 768px) {
    .heading {
        font-size: 1.5rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .filter-container {
        flex-direction: column;
        align-items: center;
    }

    .filter-container label,
    .filter-container select,
    .filter-container button {
        margin-bottom: 0.5rem;
        margin-right: 0;
    }

    .table {
        width: 100%;
        min-width: 0; /* Permite que la tabla se reduzca */
    }

    .table-cell, .table-header {
        padding: 0.6rem;
        font-size: 0.9rem;
    }

    .button {
        font-size: 0.9rem;
        padding: 0.6rem 1.2rem;
    }
}

/* Móviles pequeños */
@media (max-width: 480px) {
    .heading {
        font-size: 1.2rem;
        margin-top: 1rem;
        margin-bottom: 0.8rem;
    }

    .table-cell, .table-header {
        padding: 0.4rem;
        font-size: 0.8rem;
    }

    .button {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}

</style>
<body>
    <h2 class="heading">Lista de Pedidos</h2>

    <div class="filter-container">
        <form action="" method="GET">
            <label for="order_by">Ordenar por:</label>
            <select name="order_by" id="order_by">
                <option value="fechaPedido DESC" <?php if ($orderBy === 'fechaPedido DESC') echo 'selected'; ?>>Fecha (Más Nuevo)</option>
                <option value="fechaPedido ASC" <?php if ($orderBy === 'fechaPedido ASC') echo 'selected'; ?>>Fecha (Más Antiguo)</option>
            </select>

            <label for="status_filter">Estado:</label>
            <select name="status_filter" id="status_filter">
                <option value="">Todos</option>
                <option value="Completado" <?php if ($statusFilter === 'Completado') echo 'selected'; ?>>Completado</option>
                <option value="Pendiente" <?php if ($statusFilter === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            </select>
            <button type="submit">Aplicar Filtros</button>
        </form>
    </div>

    <?php
    if (!empty($pedidos)) {
    ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row">
                        <th class="table-header">ID del Pedido</th>
                        <th class="table-header">Fecha del Pedido</th>
                        <th class="table-header">Estado</th>
                        <th class="table-header">Detalles</th>
                        <th class="table-header">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido) { ?>
                        <tr class="table-row">
                            <td class="table-cell"><?php echo $pedido['idPedido']; ?></td>
                            <td class="table-cell"><?php echo $pedido['fechaPedido']; ?></td>
                            <td class="table-cell"><?php echo $pedido['estado']; ?></td>
                            <td class="table-cell"><?php echo $pedido['detalles']; ?></td>
                            <td class="table-cell"><?php echo number_format($pedido['total'], 0, '', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="centered-text">No hay pedidos disponibles con los filtros seleccionados.</p>
    <?php } ?>

    <a class="button" href="carrito.php">Volver al Carrito de Compras</a>
</body>

</html>