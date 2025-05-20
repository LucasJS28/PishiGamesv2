<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
?>

<nav id="mainNav">
    <a href="tienda.php" class="navbar-logo-link">
        <img id="pishiLogo" src="../iconos/iconpishi" alt="Pishi Logo">
    </a>
    <button class="menu-toggle" aria-label="Menú móvil" aria-expanded="false">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="lista">
        <li><a href="bienvenida.php" class="nav-link"><i class="fas fa-home"></i> Inicio</a></li>
        <li><a href="tienda.php" class="nav-link"><i class="fas fa-store"></i> Tienda</a></li>
        <li><a href="carrito.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Carrito</a></li>
        <li><a href="contactos.php" class="nav-link"><i class="fas fa-envelope"></i> Contacto</a></li>
        <?php if (!$idUsuario) : ?>
            <li><a href="index.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
            <li><a href="registroUsuarios.php" class="nav-link"><i class="fas fa-user-plus"></i> Registrarse</a></li>
        <?php else : ?>
            <li><a href="cerrarsesion.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>

<style>
  /* Fuentes de Google Fonts (opcional, pero mejora la estética) */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');


/* Reset básico */
nav, ul.lista, ul.lista li {
    margin: 0;
    padding: 0;
    list-style: none;
}

nav {
    width: 100%;
    max-width: 1300px; /* Ancho máximo para el nav, lo hace más compacto en pantallas grandes */
    margin: 0 auto; /* Centra el nav */
    background-color: #1a1a1d; /* Fondo muy oscuro, casi negro */
    padding: 0.7rem 1.2rem; /* Menos padding vertical */
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.6); /* Sombra más sutil */
    transition: box-shadow 0.3s ease-in-out;
    font-family: 'Montserrat', sans-serif; /* Usando Montserrat para un estilo más moderno */
    border-bottom: 1px solid #0f3460; /* Borde sutil en la parte inferior */
}

/* Animación de la sombra al hacer scroll (JavaScript) */
nav.scrolled {
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.8);
}

/* Logo */
.navbar-logo-link {
    display: flex;
    align-items: center;
    height: 100%;
    margin-right: 15px; /* Menos espacio entre el logo y el menú */
}

#pishiLogo {
    height: 55px; /* Un poco más pequeña */
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    filter: drop-shadow(0 0 8px rgba(128, 203, 196, 0.7)); /* Tono verde azulado */
}

#pishiLogo:hover {
    transform: scale(1.1) rotate(3deg); /* Escala y rota un poco menos */
    filter: drop-shadow(0 0 15px rgba(128, 203, 196, 1));
}

/* Ícono menú (hamburguesa) */
.menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.7rem; /* Tamaño más pequeño */
    cursor: pointer;
    color: #80cbc4; /* Color verde azulado */
    user-select: none;
    padding: 4px;
    transition: transform 0.3s ease-in-out;
    outline: none;
}

.menu-toggle:focus {
    transform: scale(1.05); /* Escala menos al enfocar */
}

/* Rotación de la hamburguesa */
.menu-toggle.active i {
    transform: rotate(90deg);
}

/* Lista horizontal para escritorio */
ul.lista {
    display: flex;
    gap: 1rem; /* Menos espacio entre elementos */
    margin-left: auto;
    align-items: center;
}

ul.lista li a.nav-link {
    color: #b3e0e0; /* Color de texto más claro y cercano al verde azulado */
    text-decoration: none;
    font-weight: 500; /* Peso de fuente un poco más ligero */
    font-size: 0.95rem; /* Letra más pequeña */
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.8rem; /* Menos padding */
    border-radius: 6px; /* Bordes un poco menos redondeados */
    position: relative;
    overflow: hidden;
    transition: color 0.3s ease, background-color 0.3s ease, transform 0.2s ease;
}

ul.lista li a.nav-link i {
    font-size: 1rem; /* Tamaño de icono más pequeño */
    transition: transform 0.3s ease;
}

ul.lista li a.nav-link:hover i {
    transform: translateY(-2px) rotate(3deg); /* Movimiento más sutil */
}

ul.lista li a.nav-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px; /* Subrayado más delgado */
    background-color: #80cbc4; /* Color verde azulado para el subrayado */
    transform: scaleX(0);
    transform-origin: bottom right;
    transition: transform 0.3s ease-out;
}

ul.lista li a.nav-link:hover::before {
    transform: scaleX(1);
    transform-origin: bottom left;
}

ul.lista li a.nav-link:hover, ul.lista li a.nav-link:focus {
    background-color: #0f3460; /* Fondo al hover que combine con el borde inferior */
    color: #ffffff; /* Texto blanco puro al hover */
    outline: none;
    transform: translateY(-1px); /* Levantamiento aún más sutil */
}

/* Responsive - móvil */
@media (max-width: 768px) {
    nav {
        max-width: 100%; /* Ocupa todo el ancho en móvil */
        padding: 0.7rem 1rem; /* Ajuste de padding */
        justify-content: flex-start; /* Align items to the start */
        flex-wrap: wrap; /* Allow items to wrap to the next line */
    }

    .navbar-logo-link {
        margin-right: auto; /* Push logo to the left */
    }

    .menu-toggle {
        display: block;
        margin-left: auto; /* Push toggle to the right */
    }

    ul.lista {
        margin-left: 0;
        width: 100%;
        flex-direction: column;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-in-out;
        background-color: #1a1a1d; /* Mismo fondo que el nav */
        border-top: 1px solid #0f3460; /* Separador en móvil */
        align-items: flex-start;
    }

    ul.lista.active {
        max-height: 400px; /* Ajusta la altura según la cantidad de ítems */
        padding-bottom: 0.8rem;
    }

    ul.lista li {
        width: 100%;
        opacity: 0;
        transform: translateY(15px); /* Deslizamiento más corto */
        transition: opacity 0.3s ease-out, transform 0.3s ease-out; /* Transición más rápida */
    }

    ul.lista.active li {
        opacity: 1;
        transform: translateY(0);
    }

    /* Retraso en la animación para cada elemento del menú */
    ul.lista.active li:nth-child(1) { transition-delay: 0.03s; }
    ul.lista.active li:nth-child(2) { transition-delay: 0.06s; }
    ul.lista.active li:nth-child(3) { transition-delay: 0.09s; }
    ul.lista.active li:nth-child(4) { transition-delay: 0.12s; }
    ul.lista.active li:nth-child(5) { transition-delay: 0.15s; }
    ul.lista.active li:nth-child(6) { transition-delay: 0.18s; }
    ul.lista.active li:nth-child(7) { transition-delay: 0.21s; }


    ul.lista li a.nav-link {
        padding: 0.8rem 1.5rem; /* Ajuste de padding en móvil */
        border-bottom: 1px solid #0f3460;
        font-size: 1rem; /* Tamaño de texto en móvil */
        width: 100%;
        box-sizing: border-box;
    }

    ul.lista li:last-child a.nav-link {
        border-bottom: none;
    }
    ul.lista li:first-child a.nav-link {
        padding-top: 1.5rem; /* O el valor que desees para el padding superior de este ancla */
    }
}
</style>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.querySelector('.menu-toggle');
        const menuList = document.querySelector('.lista');
        const navBar = document.getElementById('mainNav');

        // Toggle menú responsive al hacer click en el icono
        toggleButton.addEventListener('click', () => {
            menuList.classList.toggle('active');
            toggleButton.classList.toggle('active'); // Para animar la hamburguesa
            const isExpanded = menuList.classList.contains('active');
            toggleButton.setAttribute('aria-expanded', isExpanded); // Actualizar atributo ARIA
        });

        // Permitir toggle con teclado (Enter o espacio)
        toggleButton.addEventListener('keydown', e => {
            if(e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                menuList.classList.toggle('active');
                toggleButton.classList.toggle('active');
                const isExpanded = menuList.classList.contains('active');
                toggleButton.setAttribute('aria-expanded', isExpanded);
            }
        });

        // Animación de la sombra de la barra de navegación al hacer scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { // Si el scroll es mayor a 50px
                navBar.classList.add('scrolled');
            } else {
                navBar.classList.remove('scrolled');
            }
        });

        // Cerrar el menú si se hace clic fuera de él (solo en móvil)
        document.addEventListener('click', (event) => {
            if (window.innerWidth <= 768 && menuList.classList.contains('active')) {
                const isClickInsideNav = navBar.contains(event.target);
                if (!isClickInsideNav) {
                    menuList.classList.remove('active');
                    toggleButton.classList.remove('active');
                    toggleButton.setAttribute('aria-expanded', 'false');
                }
            }
        });
    });
</script>