<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminos y Condiciones</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<style>
    /* Estilos para la sección de Términos y Condiciones */
.terminos-contenedor {
    width: 90%;
    max-width: 900px;
    margin: 2rem auto;
    background-color: #1e1e1e; /* Color de fondo similar a los items de juego */
    border: 1.5px solid #80cbc4; /* Borde del mismo color que los items de juego */
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
}

.terminos-contenedor h2#titulo { /* Re-estilo del título si es necesario */
    color: #80cbc4;
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.terminos-contenedor p {
    color: #b2dfdb; /* Color de texto suave */
    margin-bottom: 1rem;
    font-size: 1rem;
    line-height: 1.6;
}

.terminos-contenedor ol {
    list-style-type: decimal;
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}

.terminos-contenedor li {
    color: #a7ffeb; /* Color de encabezado similar a los títulos de juego */
    font-weight: 600;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.terminos-contenedor a#volver-registro {
    display: inline-flex;
    align-items: center;
    background-color: #80cbc4; /* Color del botón de agregar al carrito o principal */
    color: #121212;
    padding: 0.7rem 1.5rem;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    margin-top: 1.5rem;
}

.terminos-contenedor a#volver-registro:hover {
    background-color: #4db6ac; /* Color de hover para botones */
    box-shadow: 0 4px 10px rgba(128, 203, 196, 0.7);
}

.terminos-contenedor a#volver-registro .fas {
    margin-right: 0.5rem; /* Espacio entre el icono y el texto */
}

/* Ajustes para el título de la página Terminos y Condiciones fuera del contenedor */
h2#titulo {
    color: #80cbc4;
    font-size: 3rem;
    text-align: center;
    margin: 2rem 1rem 1.5rem;
}

/* Media queries para responsividad */
@media (max-width: 768px) {
    .terminos-contenedor {
        padding: 1.5rem;
        margin: 1.5rem auto;
    }

    h2#titulo {
        font-size: 2.5rem;
        margin: 1.5rem 1rem 1rem;
    }

    .terminos-contenedor li {
        font-size: 1rem;
    }

    .terminos-contenedor p {
        font-size: 0.95rem;
    }
}

@media (max-width: 480px) {
    .terminos-contenedor {
        padding: 1rem;
        margin: 1rem auto;
    }

    h2#titulo {
        font-size: 2rem;
        margin: 1rem 0.5rem;
    }

    .terminos-contenedor ol {
        margin-left: 1rem;
    }

    .terminos-contenedor a#volver-registro {
        width: 100%;
        text-align: center;
        justify-content: center;
        padding: 0.8rem 1rem;
    }
}
</style>
<body>
    <?php include 'nav.php'; ?>
    <h2 id="titulo">Terminos y Condiciones</h2>
    <div class="terminos-contenedor">
        <p style="text-align: center;">A continuación se presentan los términos y condiciones para utilizar nuestra página de juegos venta online:</p>
        <ol>
            <li>Aceptación de los Términos y Condiciones</li>
            <p>Al acceder y utilizar nuestra página de juegos venta online, aceptas cumplir y estar sujeto a los siguientes términos y condiciones. Si no estás de acuerdo con alguno de los términos, te recomendamos que no utilices nuestra plataforma.</p>
            <li>Uso Adecuado</li>
            <p>Nuestra página de juegos venta online está destinada únicamente para uso personal y no comercial. No se permite el uso de nuestra plataforma para actividades ilegales, fraudulentas o que violen los derechos de terceros.</p>
            <li>Registro de Usuario</li>
            <p>Para realizar compras en nuestra página, deberás registrarte como usuario y proporcionar información precisa y actualizada. Eres responsable de mantener la confidencialidad de tu cuenta y contraseña, y aceptas que cualquier actividad realizada bajo tu cuenta será tu responsabilidad.</p>
            <li>Propiedad Intelectual</li>
            <p>Todos los contenidos de nuestra página, incluyendo pero no limitado a logotipos, imágenes, textos, gráficos y software, están protegidos por derechos de propiedad intelectual. No está permitida la reproducción, distribución o modificación de dichos contenidos sin nuestro consentimiento previo por escrito.</p>
            <li>Compras y Pagos</li>
            <p>Al realizar una compra a través de nuestra página, aceptas proporcionar información de pago precisa y autorizas el cargo correspondiente. Nos reservamos el derecho de rechazar cualquier pedido en caso de sospecha de fraude o por cualquier otro motivo razonable.</p>
            <li>Envío y Entrega</li>
            <p>Haremos todo lo posible para garantizar un envío y entrega oportunos de los productos adquiridos. Sin embargo, no nos hacemos responsables de retrasos o problemas en la entrega causados por terceros, como servicios de mensajería o aduanas.</p>
            <li>Política de Devoluciones</li>
            <p>Contamos con una política de devoluciones que establece los procedimientos para devolver productos y solicitar reembolsos. Te recomendamos que revises detenidamente esta política antes de realizar una compra.</p>
            <li>Limitación de Responsabilidad</li>
            <p>No nos hacemos responsables de ningún daño directo, indirecto, incidental, consecuente o especial derivado del uso de nuestra página de juegos venta online, incluyendo pérdida de beneficios, interrupción del negocio o pérdida de datos.</p>
            <li>Modificaciones de los Términos y Condiciones</li>
            <p>Nos reservamos el derecho de modificar o actualizar estos términos y condiciones en cualquier momento. Te recomendamos que revises periódicamente esta sección para estar al tanto de los cambios realizados.</p>
            <li>Ley Aplicable y Jurisdicción</li>
            <p>Estos términos y condiciones se regirán e interpretarán de acuerdo con las leyes del país o región correspondiente. Cualquier disputa que surja en relación con nuestra página de juegos venta online estará sujeta a la jurisdicción exclusiva de los tribunales competentes en esa área.</p>
        </ol>
        <br>
        <br>
        <a href="registroUsuarios.php" id="volver-registro"> <i class="fas fa-undo"></i> Volver al Registro</a>
    </div>
</body>
</html>
