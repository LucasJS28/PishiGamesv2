<?php
session_start();

if (isset($_SESSION['pedido'])) {
    $pedido = $_SESSION['pedido'];

    // Generar el contenido HTML de la boleta
    $boletaHTML = "<html>
<head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 20px;
        width: 600px;
        margin: 0 auto;
    }

    .etiqueta-larga {
        background-color: #333333;
        color: #ffffff;
        padding: 20px;
        margin-bottom: 20px;
    }

    h2 {
        color: #ff0000;
        text-align: center;
        margin-top: 0;
    }

    p {
        margin-bottom: 10px;
    }

    .info {
        border: 1px solid #cccccc;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #ffffff;
    }

    .total {
        text-align: right;
        font-weight: bold;
        font-size: 18px;
        color: #ff0000;
    }
</style>
</head>
<body>
<div class='etiqueta-larga'>
    <h2>Boleta de compra</h2>
</div>
<div class='info'>
    <p>ID de Pedido: " . $pedido['idPedido'] . "</p>
    <p>Fecha de Pedido: " . $pedido['fechaPedido'] . "</p>
    <p>Estado: " . $pedido['estado'] . "</p>
    <p>Detalles: " . $pedido['detalles'] . "</p>
</div>
<div class='etiqueta-larga'>
    <div class='total'>
        <p>Total: " . $pedido['total'] . "</p>
    </div>
</div>
</body>
</html>";

//header('Content-Type: application/octet-stream');: Establece el tipo de contenido como binario para la descarga del archivo.
//header('Content-Disposition: attachment; filename="boleta.html"');: Configura la descarga del archivo con el nombre "boleta.html"
    // Descargar la boleta como un archivo
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="boleta.html"');

    echo $boletaHTML;
} else {
    echo "No se encontró el pedido.";
}
?>
