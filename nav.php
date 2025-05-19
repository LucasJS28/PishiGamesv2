<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
?>

<nav>
    <div class="menu-toggle" aria-label="Menú móvil" role="button" tabindex="0">
        <i class="fas fa-bars"></i>
    </div>

    <ul class="lista">
        
        <li><a href="bienvenida.php"><i class="fas fa-home"></i> Inicio</a></li>
        <li><a href="tienda.php"><i class="fas fa-store"></i> Tienda</a></li>
        <li><a href="carrito.php"><i class="fas fa-shopping-cart"></i> Carrito</a></li>
        <li><a href="contactos.php"><i class="fas fa-envelope"></i> Contacto</a></li>
        <?php if (!$idUsuario) : ?>
            <li><a href="index.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
            <li><a href="registroUsuarios.php"><i class="fas fa-user-plus"></i> Registrarse</a></li>
        <?php else : ?>
            <li><a href="cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        <?php endif; ?>
    </ul>

<style>
    /* Reset básico para nav */
    nav, ul.lista, ul.lista li {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    nav {
        width: 100%;
        background-color: #1f1f1f;
        padding: 0.8rem 1.2rem;
        display: flex;
        /* Aligns items on the main axis. Pushes .menu-toggle to left, .lista to right */
        justify-content: space-between;
        align-items: center; /* Aligns items on the cross axis (vertically center) */
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Ícono menú (hamburguesa) */
    .menu-toggle {
        display: none; /* Hidden by default on desktop */
        font-size: 1.8rem;
        cursor: pointer;
        color: #80cbc4;
        user-select: none;
    }

    /* Lista horizontal para escritorio */
    ul.lista {
        display: flex;
        gap: 1.2rem;
        /* Pushes the ul.lista to the right within the nav flex container */
        margin-left: auto; /* This is the key to pushing it to the right */
    }

    ul.lista li a {
        color: #80cbc4;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    ul.lista li a:hover, ul.lista li a:focus {
        background-color: #333;
        outline: none;
    }

    /* Responsive - móvil */
    @media (max-width: 768px) {
        nav {
            /* On smaller screens, allow flex items to wrap */
            flex-wrap: wrap;
            /* Ensure alignment for wrapped items if needed */
            justify-content: space-between;
        }

        .menu-toggle {
            display: block; /* Show the toggle button on mobile */
        }

        ul.lista {
            /* Override margin-left: auto for mobile to allow full width */
            margin-left: 0;
            width: 100%;
            flex-direction: column; /* Stack items vertically */
            max-height: 0; /* Hidden by default */
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: #1f1f1f;
            border-top: 1px solid #333;
            /* Ensure the menu items are aligned to the start/left in the column */
            align-items: flex-start; /* Important for mobile menu item alignment */
        }

        ul.lista.active {
            max-height: 500px; /* Sufficient height to show the menu */
        }

        ul.lista li {
            width: 100%; /* Ensure each list item takes full width in the column */
        }

        ul.lista li a {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #333;
            font-size: 1.1rem;
            width: 100%; /* Make links fill the list item width */
        }
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

</style>

<script>
    // Toggle menú responsive al hacer click en el icono
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.lista');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('active');
        });
        // Permitir toggle con teclado (Enter o espacio)
        toggle.addEventListener('keydown', e => {
            if(e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                menu.classList.toggle('active');
            }
        });
    });
</script>
</nav>