<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/pedidos.php";
$pedidos = new Pedidos();
$idUsuario = $_SESSION['idUsuario'];
$permiso = $_SESSION["Puesto"];
$todosLosPedidos = $pedidos->mostrarPedidos();

if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}
if ($permiso !== "Trabajador" && $permiso !== "Administrador" && $permiso !== "Jefe") {
    header("Location:../index.php");
    exit();
}

// Procesar el formulario de cambio de estado o cancelación de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idPedido'])) {
        $idPedido = $_POST['idPedido'];
        $estado = $_POST['estado'];
        // Actualizar el estado del pedido
        $pedidos->actualizarEstadoPedido($idPedido, $estado);
        // Obtener todos los pedidos actualizados
        $todosLosPedidos = $pedidos->mostrarPedidos();
    } elseif (isset($_POST['idPedidoCancelar'])) {
        $idPedidoCancelar = $_POST['idPedidoCancelar'];
        // Agrega una validación adicional antes de cancelar el pedido
        if (isset($_POST['confirmacion_' . $idPedidoCancelar]) && $_POST['confirmacion_' . $idPedidoCancelar] === 'si') {
            // Eliminar el pedido
            $pedidos->eliminarPedido($idPedidoCancelar);

            // Obtener todos los pedidos actualizados
            $todosLosPedidos = $pedidos->mostrarPedidos();
        }
    }
    // NOTA IMPORTANTE: Si las funciones `actualizarEstadoPedido` y `eliminarPedido`
    // usan AJAX para enviar los datos, entonces no necesitas `header('Location: ...')`
    // aquí en el PHP si el objetivo es solo actualizar la tabla sin recargar toda la página.
    // Si estas funciones NO usan AJAX y siempre recargan la página, entonces la redirección
    // es necesaria. Asumo que usas AJAX dado que tenías las llamadas a funciones JS.
    // Por ahora, dejaré el `exit()` original, asumiendo que AJAX se encarga de la UI.
    exit(); // Termina la ejecución del PHP después de procesar la solicitud POST (útil para AJAX).
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Pedidos</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/scriptsValidaciones.js"></script>
    <script src="../scripts/ajax.js"></script>
</head>
<style>
    /* --- Variables de Color --- */
:root {
    --bg-dark: #1a1a2e; /* Fondo muy oscuro, casi negro-azulado */
    --primary-dark: #16213e; /* Azul oscuro para elementos principales (fondo del nav) */
    --accent-blue: #0f3460; /* Azul más profundo para acentos y bordes */
    --text-light: #e0e0e0; /* Texto claro para contraste */
    --text-muted: #a0a0a0; /* Texto gris para elementos secundarios */
    --highlight-neon: #e94560; /* Rojo/Rosa neón para resaltar */
    --hover-bg: rgba(233, 69, 96, 0.1); /* Fondo sutil de hover con color neón */
    --border-glow: #e94560; /* Color del brillo de los bordes */
    --navbar-height: 80px; /* Altura fija para el navbar en desktop */
    --success-color: #4CAF50; /* Verde para éxito */
    --error-color: #F44336; /* Rojo para error */
}

/* --- Estilos Generales --- */
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
    overflow-x: hidden; /* Evita el scroll horizontal no deseado */
}

/* Aplicar box-sizing: border-box globalmente */
*, *::before, *::after {
    box-sizing: border-box;
}

/* --- Contenedores Principales (Formulario y Tabla) --- */
.contenedor, .contenedor-tabla {
    background-color: var(--primary-dark);
    padding: 2.5rem;
    margin: 2.5rem auto;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6), 0 0 20px var(--accent-blue) inset;
    width: 90%;
    max-width: 1200px; /* Aumentado para tablas más grandes */
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid var(--accent-blue);
}

.titulo {
    color: var(--highlight-neon);
    font-size: 2.5rem; /* Título más grande */
    margin-bottom: 2rem; /* Más espacio debajo */
    text-align: center;
    text-shadow: 0 0 15px rgba(233, 69, 96, 0.8); /* Sombra más pronunciada */
    letter-spacing: 0.05em; /* Ligeramente más espaciado */
}

/* --- Estilos del Formulario de Productos (Si aplica en esta página) --- */
.product-form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 600px; /* Un poco más ancho */
    gap: 1.2rem; /* Más espacio entre campos */
    padding: 1.8rem;
    background-color: var(--bg-dark);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.4); /* Sombra más definida */
}

.formularios {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.formularios-label {
    color: var(--text-light);
    font-weight: 600;
    font-size: 1.05rem;
}

.formulario-input {
    padding: 1rem 1.2rem; /* Más padding */
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: rgba(15, 52, 96, 0.2);
    color: var(--text-light);
    font-size: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
}

.formulario-input:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.4), inset 0 0 10px rgba(233, 69, 96, 0.3);
}

.formulario-input[type="file"] {
    padding-top: 15px; /* Ajuste para input file */
}

#imagen-preview {
    margin-top: 1.5rem;
    border: 2px solid var(--accent-blue); /* Borde más visible */
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(233, 69, 96, 0.5); /* Sombra más brillante */
}

.submit-button {
    background-color: var(--highlight-neon);
    color: var(--text-light);
    border: none;
    padding: 1.2rem 1.8rem; /* Más padding */
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem; /* Texto más grande */
    font-weight: bold;
    margin-top: 2rem; /* Más margen superior */
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.5);
}

.submit-button:hover {
    background-color: #d63c55;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7), 0 0 25px var(--highlight-neon);
}

/* --- Estilos del Contenedor de la Tabla de Juegos --- */
.contenedor-tabla {
    /* Ya definidos arriba, solo para énfasis */
}

/* Reutilizando estilos de buscador */
#buscador {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 600px; /* Ajustado para ser coherente con los formularios */
    margin-bottom: 2.5rem; /* Más margen inferior */
    padding: 1.5rem;
    background-color: rgba(15, 52, 96, 0.3);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.4);
}

#titulo-buscar {
    color: var(--text-light);
    font-weight: 600;
    margin-bottom: 1rem; /* Más margen inferior */
    font-size: 1.15rem; /* Ligeramente más grande */
}

#buscar {
    width: 95%; /* Ocupa casi todo el ancho del buscador */
    padding: 0.9rem 1.2rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: var(--bg-dark);
    color: var(--text-light);
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
}

#buscar:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.4), inset 0 0 10px rgba(233, 69, 96, 0.3);
}

/* --- Estilos de la Tabla de Productos --- */
.tabla-principal {
    width: 100%;
    border-collapse: separate; /* Permite border-radius y box-shadow en la tabla */
    border-spacing: 0;
    margin-top: 2rem; /* Más margen superior */
    background-color: var(--bg-dark);
    border-radius: 12px; /* Más redondeado */
    overflow: hidden; /* Oculta contenido que se desborde, útil con border-radius */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6), 0 0 15px var(--accent-blue) inset; /* Sombra más intensa */
    border: 1px solid var(--accent-blue); /* Borde para la tabla */
}

.tabla-principal thead {
    background-color: var(--accent-blue); /* Cabecera con color de acento */
}

.tabla-principal th {
    color: var(--text-light);
    padding: 1.4rem 1.2rem; /* Más padding */
    text-align: left;
    font-weight: bold;
    border-bottom: 1px solid var(--primary-dark);
    font-size: 1.1rem; /* Texto más grande */
    text-transform: uppercase; /* Mayúsculas para las cabeceras */
    letter-spacing: 0.03em;
}

.tabla-principal th:first-child {
    border-top-left-radius: 12px; /* Coherente con la tabla */
}

.tabla-principal th:last-child {
    border-top-right-radius: 12px; /* Coherente con la tabla */
}

.tabla-principal td {
    color: var(--text-light);
    padding: 1.2rem; /* Más padding */
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    vertical-align: middle; /* Alinea contenido verticalmente */
    font-size: 0.95rem; /* Texto ligeramente más grande */
}

.tabla-principal tbody tr:last-child td {
    border-bottom: none;
}

.tabla-principal tbody tr:nth-child(even) {
    background-color: rgba(0, 0, 0, 0.1); /* Fondo para filas pares, más sutil */
}

.tabla-principal tbody tr:hover {
    background-color: var(--hover-bg); /* Efecto hover más elegante */
    transition: background-color 0.3s ease, transform 0.1s ease;
    transform: scale(1.005); /* Ligero zoom al hover */
    box-shadow: 0 0 15px rgba(233, 69, 96, 0.2); /* Sombra suave de neón */
}

/* Imagen en tabla de jefe */
.img-tabla-jefe {
    max-width: 120px; /* Un poco más grande para mejor visualización */
    height: auto;
    border-radius: 8px; /* Más redondeado */
    border: 2px solid var(--highlight-neon); /* Borde neón */
    box-shadow: 0 0 10px rgba(233, 69, 96, 0.5); /* Brillo neón alrededor */
    margin: 0 auto;
    display: block;
    transition: transform 0.2s ease;
}
.img-tabla-jefe:hover {
    transform: scale(1.05); /* Zoom al pasar el mouse */
}

/* Formularios de acción dentro de las celdas */
.form-accion-jefe {
    display: flex;
    flex-direction: column;
    gap: 0.6rem; /* Más espacio */
    align-items: center;
    width: 100%;
}

/* Input de precio/stock en panelJefe */
.input-accion-jefe {
    width: 100%;
    padding: 0.8rem 1rem; /* Más padding */
    border: 1px solid var(--accent-blue);
    border-radius: 8px; /* Más redondeado */
    background-color: rgba(15, 52, 96, 0.3); /* Fondo ligeramente más oscuro */
    color: var(--text-light);
    font-size: 1rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
}

.input-accion-jefe:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.4), inset 0 0 8px rgba(233, 69, 96, 0.3);
}

/* Botones de acción en panelJefe */
.btn-accion-jefe {
    width: 100%;
    padding: 0.8rem 1.2rem; /* Más padding */
    border: none;
    border-radius: 8px; /* Más redondeado */
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    color: var(--text-light);
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.5);
}

.btn-accion-jefe:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7), 0 0 15px var(--highlight-neon);
}

/* Estilos específicos para cada tipo de botón de acción */
.btn-precio, .btn-stock {
    background-color: var(--accent-blue);
}

.btn-precio:hover, .btn-stock:hover {
    background-color: #1a4d8c;
}

.btn-eliminar {
    background-color: var(--error-color); /* Usar la variable de color de error */
    margin-top: 0.8rem; /* Más espacio si hay otros elementos en la misma celda */
}

.btn-eliminar:hover {
    background-color: #d32f2f; /* Tono más oscuro al hover */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7), 0 0 15px var(--error-color);
}

/* Celda de acciones en desktop - centrar botones */
.tabla-principal td.td-acciones {
    text-align: center;
}

/* --- Estilos para Alertas Flotantes --- */
.alerta-flotante {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px);
    padding: 1.2rem 2.5rem; /* Más padding */
    border-radius: 10px; /* Más redondeado */
    font-size: 1.15rem; /* Texto más grande */
    font-weight: bold;
    color: var(--text-light);
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.8);
    text-align: center;
    min-width: 350px; /* Más ancho */
    max-width: 95%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alerta-flotante[style*="opacity: 1"] {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

.alerta-buena {
    background-color: rgba(30, 150, 80, 0.95); /* Más opaco */
    border: 1px solid var(--success-color);
    box-shadow: 0 0 20px rgba(76, 175, 80, 0.6); /* Brillo más fuerte */
}

.alerta-mala {
    background-color: rgba(200, 50, 50, 0.95); /* Más opaco */
    border: 1px solid var(--error-color);
    box-shadow: 0 0 20px rgba(244, 67, 54, 0.6); /* Brillo más fuerte */
}

/* --- Mejoras específicas para la tabla de Listado de Pedidos --- */

.tabla-principal th {
    padding: 1.2rem 0.8rem; /* Reducir un poco el padding horizontal */
}

.tabla-principal td {
    padding: 1rem 0.8rem; /* Reducir un poco el padding horizontal */
    vertical-align: middle; /* Asegurar la alineación vertical centrada */
}

/* Estilo específico para la columna de detalles (si es necesario ajustar) */
.tabla-principal td:nth-child(5) { /* Apunta a la quinta columna (Detalles) */
    font-size: 0.9rem; /* Reducir ligeramente el tamaño de la fuente si los detalles son extensos */
}

/* Estilo del botón "Cancelar Pedido" */
.btn-cancelar {
    padding: 0.7rem 1rem; /* Ajustar el padding del botón */
    font-size: 0.9rem; /* Reducir ligeramente el tamaño de la fuente del botón */
    border-radius: 6px; /* Un poco más redondeado */
}

.btn-cancelar:hover {
    /* Mantener el efecto hover neón */
}

/* Ajuste para la celda de "Acciones" para centrar verticalmente el botón */
.tabla-principal td.td-acciones {
    display: flex;
    align-items: center; /* Centrar verticalmente el contenido */
    justify-content: center; /* Centrar horizontalmente el contenido */
    padding: 0.8rem; /* Ajustar el padding de la celda de acciones */
}

/* Formulario que contiene el botón cancelar (si es necesario ajustar el espaciado) */
.form-cancelar {
    margin: 0; /* Eliminar márgenes innecesarios */
}

/* Estilo para el estado "Completado" (si la clase .select-estado no es la que se ve en la imagen) */
.estado-completado {
    color: var(--success-color); /* Usar la variable de color de éxito */
    font-weight: bold;
    /* Otros estilos para que destaque */
}

/* Si el estado se muestra dentro de un select y necesita más espaciado */
.select-estado {
    padding: 0.6rem 0.8rem; /* Reducir el padding del select si es muy grande */
    font-size: 0.9rem;
}

/* Asegurar que el texto del total no esté demasiado pegado al borde */
.tabla-principal td:nth-child(6) { /* Apunta a la sexta columna (Total) */
    text-align: right; /* Alinear el total a la derecha para mejor presentación */
    padding-right: 1.2rem;
}
/* --- Media Queries para Responsividad --- */
@media (max-width: 1024px) {
    .contenedor, .contenedor-tabla {
        padding: 2rem;
        margin: 2rem auto;
        max-width: 95%;
    }
    .tabla-principal th, .tabla-principal td {
        padding: 1rem 0.8rem;
        font-size: 0.9rem;
    }
    .img-tabla-jefe {
        max-width: 100px;
    }
    .input-accion-jefe, .btn-accion-jefe {
        font-size: 0.9rem;
        padding: 0.7rem 0.9rem;
    }
}

@media (max-width: 768px) {
    .contenedor, .contenedor-tabla {
        padding: 1.5rem;
        margin: 1.5rem auto;
        width: 95%;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.7), 0 0 15px var(--accent-blue) inset;
    }

    .titulo {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    .product-form, #buscador {
        padding: 1rem;
        gap: 0.8rem;
    }

    .formularios-label, #titulo-buscar {
        font-size: 0.95rem;
    }

    .formulario-input, .submit-button, #buscar {
        padding: 0.8rem;
        font-size: 0.95rem;
    }

    .submit-button {
        padding: 0.9rem 1.2rem;
        font-size: 1rem;
    }

    /* --- Tabla Responsiva (Tarjetas) --- */
    .tabla-principal {
        border: none;
        box-shadow: none;
        background-color: transparent;
        width: 100%;
        display: block; /* La tabla se comporta como un bloque */
    }

    .tabla-principal thead {
        display: none; /* Oculta la cabecera en móvil */
    }

    .tabla-principal tbody {
        display: flex; /* Flexbox para el tbody para apilar las tarjetas */
        flex-direction: column;
        width: 100%;
    }

    .tabla-principal tr {
        display: flex; /* Cada fila es una tarjeta flex */
        flex-direction: column;
        margin-bottom: 1.5rem; /* Espacio entre tarjetas */
        border: 1px solid var(--accent-blue);
        border-radius: 10px;
        overflow: hidden;
        background-color: var(--primary-dark);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6), 0 0 10px rgba(15, 52, 96, 0.4) inset;
        padding: 1.2rem 1.5rem; /* Padding interno de cada tarjeta */
        width: 100%;
        transition: all 0.3s ease; /* Transición suave para la tarjeta */
    }
    .tabla-principal tr:hover {
        background-color: rgba(233, 69, 96, 0.15); /* Hover más pronunciado */
        border-color: var(--highlight-neon);
        box-shadow: 0 5px 20px rgba(233, 69, 96, 0.4), 0 0 18px var(--highlight-neon) inset;
        transform: translateY(-5px); /* Pequeño desplazamiento al hover */
    }

    .tabla-principal td {
        display: flex;
        flex-direction: column; /* Apila etiqueta y valor/contenido */
        align-items: flex-start; /* Alinea a la izquierda */
        padding: 0.7rem 0; /* Espacio vertical para cada campo */
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        text-align: left; /* Alinea el texto a la izquierda */
        font-size: 0.95rem;
        color: var(--text-light);
        width: 100%; /* Cada TD gasta el 100% del espacio en la tarjeta */
    }
    
    .tabla-principal td:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .tabla-principal td:first-child {
        padding-top: 0;
    }

    .tabla-principal td::before {
        content: attr(data-label);
        font-weight: bold;
        color: var(--highlight-neon);
        text-align: left;
        width: 100%; /* La etiqueta ocupa el 100% */
        margin-bottom: 0.4rem; /* Espacio entre etiqueta y valor */
        font-size: 0.9rem;
    }

    /* Estilos específicos para la celda de la imagen en móvil */
    .tabla-principal td[data-label="Imagen:"] {
        flex-direction: column;
        align-items: center; /* Centra la imagen y su etiqueta */
        text-align: center;
        padding: 1rem 0;
    }
    .tabla-principal td[data-label="Imagen:"]::before {
        width: auto; /* Permitir que la etiqueta de imagen se centre */
        margin-bottom: 0.8rem;
        text-align: center;
    }
    .img-tabla-jefe {
        max-width: 100px;
        border-width: 1px; /* Borde más delgado en móvil */
        box-shadow: 0 0 8px rgba(233, 69, 96, 0.4);
    }

    /* Ajustes para los formularios y botones dentro de las celdas en móvil */
    .form-accion-jefe {
        flex-direction: column;
        gap: 0.6rem;
        width: 100%;
        align-items: flex-start; /* Alinea los inputs/botones a la izquierda con el contenido */
    }
    .input-accion-jefe,
    .btn-accion-jefe {
        width: 100%;
        font-size: 0.9rem;
        padding: 0.7rem 1rem;
    }

    .tabla-principal td.td-acciones {
        padding-top: 1rem;
        align-items: flex-start; /* Alinea el botón de eliminar a la izquierda */
        justify-content: flex-start;
    }
    .form-eliminar {
        margin-top: 0;
        align-items: flex-start; /* Alinea el formulario de eliminar a la izquierda */
    }
}

@media (max-width: 480px) {
    .contenedor, .contenedor-tabla {
        padding: 1rem;
        margin: 0.8rem auto;
    }
    .titulo {
        font-size: 1.5rem;
    }
    .product-form, #buscador {
        padding: 0.8rem;
    }
    .formulario-input, .submit-button, #buscar {
        padding: 0.6rem;
        font-size: 0.85rem;
    }
    .tabla-principal tr {
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
    }
    .tabla-principal td {
        padding: 0.6rem 0;
        font-size: 0.9rem;
    }
    .tabla-principal td::before {
        font-size: 0.85rem;
    }
    .img-tabla-jefe {
        max-width: 80px;
    }
    .input-accion-jefe, .btn-accion-jefe {
        font-size: 0.8rem;
        padding: 0.6rem 0.8rem;
    }
    .alerta-flotante {
        min-width: 280px;
        font-size: 1rem;
        padding: 1rem 1.5rem;
    }
}
/* --- Estilos Específicos para revisarPedidos.php --- */

/* Select para cambiar el estado */
.select-estado {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: rgba(15, 52, 96, 0.3);
    color: var(--text-light);
    font-size: 1rem;
    cursor: pointer;
    appearance: none; /* Elimina estilos por defecto del sistema operativo */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23e0e0e0" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Icono de flecha personalizada */
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 20px;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
}

.select-estado:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.4), inset 0 0 8px rgba(233, 69, 96, 0.3);
}

/* Colores de las opciones de estado */
.select-estado option[value="Pendiente"] { color: #f0ad4e; } /* Naranja */
.select-estado option[value="En proceso"] { color: var(--accent-blue); } /* Azul */
.select-estado option[value="Completado"] { color: var(--success-color); } /* Verde */

/* Estilos de los botones de acción para pedidos (similar al panelJefe) */
.form-accion-pedido {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    align-items: center;
    width: 100%;
}

.btn-accion-pedido {
    width: 100%;
    padding: 0.8rem 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    color: var(--text-light);
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.5);
}

.btn-accion-pedido:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7), 0 0 15px var(--highlight-neon);
}

/* Botón de Cancelar Pedido */
.btn-cancelar {
    background-color: var(--error-color); /* Rojo para cancelar */
}

.btn-cancelar:hover {
    background-color: #d32f2f;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7), 0 0 15px var(--error-color);
}

/* Mensaje de "No se encontraron pedidos" */
.no-pedidos {
    color: var(--text-muted);
    font-size: 1.2rem;
    text-align: center;
    padding: 2rem;
    background-color: rgba(15, 52, 96, 0.2);
    border-radius: 10px;
    border: 1px dashed var(--accent-blue);
    margin-top: 2rem;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.3);
}

/* --- Ajustes Responsivos para la Tabla de Pedidos (revisarPedidos.php) --- */

@media (max-width: 768px) {
    /* Las reglas generales para .tabla-principal, tr, td, td::before ya deberían aplicar
       desde la sección general de responsividad de tablas en stylesAdm.css */
    
    /* Asegurar que los formularios y selectores se vean bien en móvil */
    .form-accion-pedido {
        flex-direction: column; /* Apila select y botón si hubiera */
        align-items: flex-start; /* Alinea a la izquierda dentro de la celda */
        width: 100%;
    }
    .select-estado,
    .btn-accion-pedido {
        width: 100%; /* Ocupan todo el ancho disponible */
        font-size: 0.9rem;
        padding: 0.7rem 1rem;
    }

    /* Ajuste para la celda de acciones en móvil */
    .tabla-principal td.td-acciones {
        padding-top: 1rem;
        align-items: flex-start;
        justify-content: flex-start;
    }
}

@media (max-width: 480px) {
    /* Ajustes generales de tamaño para pantallas muy pequeñas */
    .select-estado,
    .btn-accion-pedido {
        font-size: 0.85rem;
        padding: 0.6rem 0.8rem;
    }
}
</style>
<body>
    <div class="contenedor-tabla">
        <h1 class="titulo">Listado de Pedidos</h1>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Pedido</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese el ID del Pedido a buscar">
        </div>
        <?php if (count($todosLosPedidos) > 0) { ?>
            <table class="tabla-principal">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>ID Usuario</th>
                        <th>Fecha Pedido</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todosLosPedidos as $pedido) { ?>
                        <tr id="fila-<?php echo $pedido['idPedido']; ?>">
                            <td data-label="ID Pedido:"><?php echo $pedido['idPedido']; ?></td>
                            <td data-label="ID Usuario:"><?php echo $pedido['idUsuario']; ?></td>
                            <td data-label="Fecha Pedido:"><?php echo $pedido['fechaPedido']; ?></td>
                            <td data-label="Estado:">
                                <form class="form-accion-pedido" method="POST" action="revisarPedidos.php">
                                    <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                    <select name="estado" class="select-estado" onchange="actualizarEstadoPedido(<?php echo $pedido['idPedido']; ?>, this.value)">
                                        <option value="Pendiente" <?php if ($pedido['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="En proceso" <?php if ($pedido['estado'] === 'En proceso') echo 'selected'; ?>>En proceso</option>
                                        <option value="Completado" <?php if ($pedido['estado'] === 'Completado') echo 'selected'; ?>>Completado</option>
                                    </select>
                                </form>
                            </td>
                            <td data-label="Detalles:"><?php echo $pedido['detalles']; ?></td>
                            <td data-label="Total:">$<?php echo number_format($pedido['total'], 0, '', '.'); ?></td>
                            <td data-label="Acciones:" class="td-acciones">
                                <form class="form-accion-pedido form-cancelar" method="POST" action="revisarPedidos.php">
                                    <input type="hidden" name="idPedidoCancelar" value="<?php echo $pedido['idPedido']; ?>">
                                    <button type="button" class="btn-accion-pedido btn-cancelar" onclick="eliminarPedido(<?php echo $pedido['idPedido']; ?>)">Cancelar</button>
                                    <input type="hidden" name="confirmacion_<?php echo $pedido['idPedido']; ?>" id="confirmacion_<?php echo $pedido['idPedido']; ?>" value="">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-pedidos">No se encontraron pedidos.</p>
        <?php } ?>
    </div>
</body>
</html>