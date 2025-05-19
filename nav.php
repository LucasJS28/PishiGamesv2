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
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Ícono menú (hamburguesa) */
    .menu-toggle {
        display: none;
        font-size: 1.8rem;
        cursor: pointer;
        color: #80cbc4;
        user-select: none;
    }

    /* Lista horizontal para escritorio */
    ul.lista {
        display: flex;
        gap: 1.2rem;
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
            flex-wrap: wrap;
        }

        .menu-toggle {
            display: block;
        }

        ul.lista {
            width: 100%;
            flex-direction: column;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: #1f1f1f;
            border-top: 1px solid #333;
        }

        ul.lista.active {
            max-height: 500px; /* altura suficiente para mostrar menú */
        }

        ul.lista li a {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #333;
            font-size: 1.1rem;
        }
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
