<?php
    // Verificar si el usuario ha iniciado sesión y tiene un rol asignado
    if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['Puesto'])) {
        // Si no ha iniciado sesión, redirigir al formulario de inicio de sesión
        header("Location:../index.php");
        exit();
    }

    // Obtener el ID_Rol del usuario
    $rol = $_SESSION['Puesto'];

    // Mostrar el menú en función del ID_Rol
    function mostrar_menu($rol) {
        // El logo y el botón de hamburguesa van directamente dentro de .navbar, no dentro del ul
        echo '<a href="#" class="navbar-logo-link"><img id="pishiLogo" src="../iconos/iconpishi" alt="Pishi Logo"></a>';
        echo '<button class="hamburger" aria-label="Abrir menú de navegación">
                <i class="fas fa-bars"></i>
              </button>';

        // El UL ahora estará dentro de un contenedor, para facilitar el posicionamiento del menú desplegable
        echo '<div class="nav-links-container">'; // Nuevo contenedor para la lista de enlaces
        if ($rol == "Administrador") {
            echo '
                <ul id="main-nav-menu">
                    <li><a href="panelAdministrador.php"><i class="fas fa-user-plus"></i> Agregar trabajador</a></li>
                    <li><a href="panelTrabajador.php"><i class="fas fa-plus"></i> Agregar producto</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Administrador</span></li>
                </ul>
            ';
        } elseif ($rol == "Trabajador") {
            echo '
                <ul id="main-nav-menu">
                    <li><a href="panelTrabajador.php"><i class="fas fa-plus"></i> Agregar producto</a></li>
                    <li><a href="revisarPedidos.php"><i class="fas fa-clipboard-list"></i> Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Trabajador</span></li>
                </ul>
            ';
        } elseif ($rol == "Jefe") {
            echo '
                <ul id="main-nav-menu">
                    <li><a href="panelJefe.php"><i class="fas fa-money-bill-wave"></i> Modificar Productos</a></li>
                    <li><a href="revisarPedidos.php"><i class="fas fa-clipboard-list"></i> Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Jefe</span></li>
                </ul>
            ';
        }
        echo '</div>'; // Cierra el contenedor de enlaces
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Navegación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="../estilos/styles2.css"> <link rel="stylesheet" href="../estilos/stylesAdm.css"> <script src="../scripts/scripts.js" defer></script>
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

/* Estilos generales del body (mantener estos) */
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
    overflow-x: hidden; /* Previene scroll horizontal si algo se desborda por error */
}

/* Aplicar box-sizing: border-box globalmente para facilitar el layout */
*, *::before, *::after {
    box-sizing: border-box;
}

/* --- Navbar Principal --- */
.navbar {
    background-color: var(--primary-dark);
    height: var(--navbar-height);
    display: flex;
    align-items: center;
    padding: 0 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4), 0 0 15px var(--accent-blue) inset;
    border-bottom: 2px solid var(--accent-blue);
    position: relative;
    z-index: 1000;
}

/* --- Logo --- */
.navbar-logo-link {
    display: flex;
    align-items: center;
    height: 100%;
    margin-right: auto; /* Empuja el logo a la izquierda y el resto del contenido a la derecha */
}

#pishiLogo {
    height: 60px;
    transition: transform 0.3s ease, filter 0.3s ease;
    filter: drop-shadow(0 0 8px rgba(233, 69, 96, 0.6));
}

#pishiLogo:hover {
    transform: scale(1.08);
    filter: drop-shadow(0 0 15px rgba(233, 69, 96, 0.9));
}

/* --- Botón de Hamburguesa (OCULTO en Desktop) --- */
.hamburger {
    display: none; /* Oculto por defecto en desktop */
    background: none;
    border: none;
    color: var(--highlight-neon);
    font-size: 2rem;
    cursor: pointer;
    padding: 0.5rem;
    z-index: 1002;
    transition: transform 0.3s ease, color 0.3s ease;
}

.hamburger:hover {
    color: var(--text-light);
    transform: scale(1.1);
}

/* --- Contenedor de Enlaces del Menú (VISIBLE y ocupando espacio en Desktop por defecto) --- */
.nav-links-container {
    /* En desktop, este es el contenedor para el menú horizontal */
    display: flex;
    align-items: center; /* Centra verticalmente los elementos del UL */
    height: 100%; /* Ocupa la altura del navbar */
    position: static; /* No fijo en desktop */
    width: auto; /* Permite que el ancho se ajuste a su contenido (en desktop) */
    flex-grow: 1; /* Permite que este contenedor ocupe todo el espacio disponible */

    background-color: transparent; /* Sin fondo extra en desktop */
    padding: 0; /* Sin padding extra en desktop */
    z-index: auto; /* Sin z-index especial en desktop */
    transform: translateX(0); /* Asegura que no esté oculto por transformación */
    transition: none; /* Sin transiciones en desktop */
}

/* Asegurarse que el UL dentro de .nav-links-container también ocupe su espacio y distribuya */
.nav-links-container ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex; /* Los elementos del menú están en fila en desktop */
    align-items: center;
    height: 100%;
    justify-content: flex-end; /* Alinea los elementos del menú a la derecha dentro de su contenedor */
    width: 100%; /* Asegura que el UL ocupe el 100% del espacio de su contenedor */
}

.nav-links-container li {
    margin: 0 1rem; /* Espacio entre los elementos del menú */
}

.nav-links-container a {
    color: var(--text-light);
    text-decoration: none;
    padding: 0.7rem 1.2rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
    font-weight: 500;
}

.nav-links-container a:hover {
    color: var(--highlight-neon);
    background-color: var(--hover-bg);
    transform: translateY(-2px);
    box-shadow: 0 0 15px var(--highlight-neon);
}

.nav-links-container a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.nav-links-container a:hover::before {
    left: 100%;
}

.nav-links-container a i {
    margin-right: 0.7rem;
    font-size: 1.2em;
    color: var(--text-muted);
    transition: color 0.3s ease;
}

.nav-links-container a:hover i {
    color: var(--highlight-neon);
}

.nav-links-container .rango {
    color: var(--text-muted);
    font-size: 1rem;
    white-space: nowrap;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: rgba(15, 52, 96, 0.3);
    box-shadow: 0 0 5px rgba(233, 69, 96, 0.3);
    margin-left: 2rem; /* Mantener esto para desktop */
}

.nav-links-container .rango span {
    font-weight: bold;
    color: var(--highlight-neon);
}

/* --- Responsividad del Navbar (Menú Desplegable para Mobile) --- */
@media (max-width: 900px) {
    .hamburger {
        display: block; /* Mostrar el botón de hamburguesa en mobile */
    }

    /* Ajustar el logo y el botón de hamburguesa para que estén a los extremos */
    .navbar-logo-link {
        margin-right: 0; /* Deshacer el margin-right: auto en móvil */
    }

    .navbar {
        justify-content: space-between; /* Volver a usar space-between en móvil */
    }

    .nav-links-container {
        position: fixed; /* Fijo en pantalla en mobile */
        top: var(--navbar-height); /* Debajo del navbar */
        left: 0;
        width: 100%; /* Usar 100% en lugar de 100vw */
        height: 0; /* Oculto por defecto en mobile */
        overflow: hidden;
        background-color: var(--primary-dark); /* Fondo para el menú desplegado */
        border-top: 1px solid var(--accent-blue);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        transition: height 0.4s ease-in-out, padding 0.4s ease-in-out; /* Transición suave */
        z-index: 1001; /* Asegura que esté por encima del contenido de la página */
        flex-direction: column; /* Apilar elementos */
        padding: 0; /* Reiniciar padding para la transición */
        flex-grow: 0; /* Deshacer flex-grow en móvil */
    }

    /* Mostrar el menú cuando tiene la clase 'active' */
    .nav-links-container.active {
        height: auto;
        max-height: calc(100vh - var(--navbar-height));
        overflow-y: auto;
        padding: 1.5rem 2rem;
        align-items: center; /* Centra horizontalmente los elementos (li y .rango) dentro del menú */
    }

    .nav-links-container ul {
        flex-direction: column; /* Apila los elementos en mobile */
        width: 100%;
        height: auto; /* Desactivar altura fija */
        justify-content: flex-start; /* Asegurar alineación a la izquierda en mobile (dentro del UL) */
    }

    .nav-links-container li {
        width: 100%;
        margin: 0.7rem 0;
        text-align: center; /* Centra el texto dentro de cada LI */
    }

    .nav-links-container a {
        padding: 1rem 1.5rem;
        width: 100%;
        justify-content: center; /* Centra el contenido (icono + texto) de cada enlace */
        font-size: 1.05rem;
    }

    .nav-links-container a i {
        margin-right: 0.5rem; /* Ajustar margen para un mejor centrado si se desea */
        font-size: 1.1em;
    }

    .nav-links-container .rango {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--accent-blue);
        width: 100%;
        text-align: center; /* Centra el texto de este div (Bienvenido: Administrador) */
        margin-left: 0; /* Deshacer el margin-left de desktop */
    }
}

/* --- Estilos para el Contenido Principal de la Página --- */
/* Suponiendo que el contenido se encuentra dentro de .contenido o .contenedor-tabla */
.contenido, .contenedor-tabla {
    display: flex; /* Usar flexbox para centrar los elementos hijos */
    flex-direction: column; /* Apilar los elementos verticalmente */
    align-items: center; /* ¡NUEVO! Centra los elementos hijos horizontalmente */
    padding: 2rem; /* Un padding general para la sección */
    max-width: 800px; /* Limita el ancho máximo para una mejor legibilidad en pantallas grandes */
    margin: 2rem auto; /* ¡NUEVO! Centra el contenedor completo en la página */
    background-color: var(--primary-dark); /* Fondo para el contenedor si es necesario */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
}

.contenido h2, .contenedor-tabla h2 { /* Título "Listado de Juegos" */
    text-align: center; /* Centra el texto de los títulos */
    color: var(--highlight-neon);
    margin-bottom: 1.5rem;
}

/* Estilos específicos para los campos de entrada */
.contenido div, .contenedor-tabla div {
    width: 100%; /* Asegura que los divs ocupen todo el ancho de su contenedor */
    display: flex;
    flex-direction: column;
    align-items: center; /* Centra el contenido de cada línea (label, input, etc.) */
    margin-bottom: 1rem;
}

.contenido label, .contenedor-tabla label {
    margin-bottom: 0.5rem;
    color: var(--text-light);
}

.contenido input[type="text"],
.contenido input[type="file"],
.contenido button {
    width: 80%; /* Ajusta el ancho de los inputs y botones para que se vean bien centrados */
    max-width: 300px; /* Limita el ancho máximo para que no se estiren demasiado */
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid var(--accent-blue);
    border-radius: 5px;
    background-color: var(--bg-dark);
    color: var(--text-light);
    font-size: 1rem;
}

.contenido button {
    background-color: var(--highlight-neon);
    color: var(--text-light);
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.contenido button:hover {
    background-color: darken(var(--highlight-neon), 10%); /* Oscurece el color al pasar el ratón */
    transform: translateY(-1px);
}


/* --- Media Queries Adicionales para el Contenido Principal --- */
@media (max-width: 768px) {
    .contenido, .contenedor-tabla {
        padding: 1.5rem;
        margin: 1.5rem auto;
    }
}

@media (max-width: 480px) {
    .contenido, .contenedor-tabla {
        padding: 1rem;
        margin: 1rem auto;
    }

    .contenido input[type="text"],
    .contenido input[type="file"],
    .contenido button {
        width: 95%; /* Un poco más anchos en pantallas muy pequeñas */
    }
}
</style>
<body>
    <div class="navbar">
        <?php mostrar_menu($_SESSION['Puesto']); ?>
    </div>
    </body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinksContainer = document.querySelector('.nav-links-container'); // Apuntamos al nuevo contenedor
    const mainNavMenu = document.getElementById('main-nav-menu'); // Referencia al UL, por si acaso

    if (hamburger && navLinksContainer && mainNavMenu) {
        hamburger.addEventListener('click', function() {
            navLinksContainer.classList.toggle('active'); // Alterna la clase 'active' en el contenedor
            
            // Opcional: Cambiar el ícono de la hamburguesa
            const icon = this.querySelector('i');
            if (navLinksContainer.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times'); // Cambia a una 'X'
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars'); // Vuelve al ícono de hamburguesa
            }
        });

        // Opcional: Cerrar el menú si se hace clic fuera de él (en pantallas pequeñas)
        document.addEventListener('click', function(event) {
            // Asegúrate de que el clic no sea en la hamburguesa ni dentro del contenedor de enlaces
            if (navLinksContainer.classList.contains('active') && !navLinksContainer.contains(event.target) && !hamburger.contains(event.target)) {
                navLinksContainer.classList.remove('active');
                hamburger.querySelector('i').classList.remove('fa-times');
                hamburger.querySelector('i').classList.add('fa-bars');
            }
        });

        // Opcional: Cerrar el menú si se hace clic en un enlace
        mainNavMenu.querySelectorAll('a').forEach(link => { // Iterar sobre los enlaces dentro del UL
            link.addEventListener('click', () => {
                if (navLinksContainer.classList.contains('active')) {
                    navLinksContainer.classList.remove('active');
                    hamburger.querySelector('i').classList.remove('fa-times');
                    hamburger.querySelector('i').classList.add('fa-bars');
                }
            });
        });
    } else {
        console.error("No se encontraron el botón de hamburguesa o el contenedor de enlaces del menú.");
    }
});
</script>
</html>
