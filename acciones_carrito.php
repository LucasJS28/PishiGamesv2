<?php
session_start();
require_once 'conexiones/conexion.php';
require_once 'conexiones/Productos.php';
require_once 'conexiones/pedidos.php';
$conexion = new Conexion();
$productos = new Productos();
$pedidos = new Pedidos();



// Procesar las acciones de quitar, aumentar y eliminar del carrito
if (isset($_GET['id']) && isset($_GET['action'])) {
    $idJuego = $_GET['id'];
    $action = $_GET['action'];
    if ($action == 'remove') {
        // Restar 1 a la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $_SESSION['carrito'][$idJuego]['cantidad'] -= 1;
            // Eliminar el producto si la cantidad es menor o igual a 0
            if ($_SESSION['carrito'][$idJuego]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$idJuego]);
            }
        }
    } elseif ($action == 'add') {
        // Verificar si hay suficiente stock antes de aumentar la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $cantidadActual = $_SESSION['carrito'][$idJuego]['cantidad'];
            $cantidadNueva = $cantidadActual + 1;
            // Verificar si hay suficiente stock en la base de datos
            if ($productos->verificarStock($idJuego, $cantidadNueva)) {
                $_SESSION['carrito'][$idJuego]['cantidad'] = $cantidadNueva;
            }
        }
    } elseif ($action == 'delete') {
        // Eliminar el producto del carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            unset($_SESSION['carrito'][$idJuego]);
        }
    }
    header('Location: carrito.php'); // Redirigir de vuelta a la página del carrito
    exit();
}
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = array(); // Crear un carrito vacío
}




//Realiza el pedido y crea la boleta


// Verificar si se ha enviado el formulario de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comprar'])) {
        $suficienteStock = true; // Bandera para verificar si hay suficiente stock
        foreach ($carrito as $idJuego => $juego) {
            $cantidad = $juego['cantidad'];
            // Verificar si hay suficiente stock antes de restar el stock
            if (!$productos->verificarStock($idJuego, $cantidad)) {
                $suficienteStock = false;
                echo "<div id='alerta' class='AlertaMala'>No se pudo realizar el pedido del producto: " . $juego['titulo'] . " debido a problemas de stock.</div>";
            }
        }
        if ($suficienteStock) {
            foreach ($carrito as $idJuego => $juego) {
                $cantidad = $juego['cantidad'];
                $productos->restarStock($idJuego, $cantidad);
            }
            //Consigue Los datos para posteriormente insertarlos en la BDD
            $idUsuario = $_SESSION['idUsuario'];
            $fechaPedido = date("Y-m-d H:i:s");
            $estado = "Pendiente";
            $detalles = ""; // Aquí se almacenarán los detalles de los productos del carrito
            $total = $_POST['total'];
            // Construir la cadena de detalles de los productos
            foreach ($carrito as $idJuego => $juego) {
                $titulo = $juego['titulo'];
                $cantidad = $juego['cantidad'];
                $subtotal = $juego['precio'] * $cantidad;
                $detalles .= "$titulo x  $cantidad ,";
            }
            // Insertar el pedido en la base de datos
            $insertado = $pedidos->realizarPedido($idUsuario, $fechaPedido, $estado, $detalles, $total);
            $idPedido = $pedidos->obtenerUltimoIdPedido();
            //Funcion creada para enviar los valores en una variable pedido para posteriormente imprimilar en generar_boleta
            if ($insertado) {
                unset($_SESSION['carrito']);
                $_SESSION['pedido'] = array(
                    'idPedido' => $idPedido,
                    'fechaPedido' => $fechaPedido,
                    'estado' => $estado,
                    'detalles' => $detalles,
                    'total' => $total
                );
                echo "<div id='alerta' class='AlertaBuena'>El Pedido se Realizó Correctamente. <a class='boletaAlerta'  href='generar_boleta.php'>Descargar Boleta</a></div>";
            } else {
                echo "<div id='alerta' class='AlertaMala'>Error al realizar el pedido.</div>";
            }
        }
    }
}

?>