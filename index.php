<?php
session_start(); // Make sure session_start() is the very first thing here

require_once "conexiones/Conexion.php";

$alertaMensaje = ""; // Initialize with an empty string
$alertaClase = "";   // Initialize with an empty string

if (isset($_POST['correoUsuario']) && isset($_POST['passUsuario'])) {
    $correoUsuario = $_POST['correoUsuario'];
    $passUsuario = $_POST['passUsuario'];
    $conexion = new Conexion();
    $idRol = $conexion->login($correoUsuario, $passUsuario); 

    if ($idRol !== false) {
        $usuarios = $conexion->obtenerUsuarios();
        foreach ($usuarios as $usuario) {
            if ($usuario['correoUsuario'] == $correoUsuario) { 
                $idUsuario = $usuario['idUsuario']; 
                break;
            }
        }
        $_SESSION["idUsuario"] = $idUsuario; 

        switch ($idRol) {
            case 1:
                $_SESSION["Puesto"] = "Administrador";
                header("Location: administracion/panelAdministrador.php");
                break;
            case 2:
                $_SESSION["Puesto"] = "Trabajador";
                header("Location: administracion/panelTrabajador.php");
                break;
            case 3:
                $_SESSION["Puesto"] = "Jefe";
                header("Location: administracion/panelJefe.php");
                break;
            case 4:
                $_SESSION["Puesto"] = "Usuario";
                if (isset($_SESSION['carrito'])) { // Check if 'carrito' is set before accessing
                    header("Location: carrito.php"); 
                } else {
                    header("Location: tienda.php");
                }
                break;
            default:
                break;
        }
        exit;
    } else {
        $alertaMensaje = "Credenciales incorrectas. Inténtalo nuevamente.";
        $alertaClase = "AlertaMala"; 
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pishi Games</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="scripts/scriptsValidaciones.js"></script>

    <style>
        /* Define CSS Variables for the theme */
        :root {
            --background-color: #1a1a1a; /* General body background */
            --text-color: #cccccc; /* General light text */
            --accent-color: #00bcd4; /* Teal/Cyan accent */
            --accent-hover-color: #0097a7; /* Darker teal on hover */
            --container-bg-color: #1e1e1e; /* Background for main sections/cards */
            --input-bg-color: #333; /* Background for input fields */
            --input-bg-color-focus: #3a3a3a; /* Background for input fields on focus */
            --input-text-color: #eee; /* Text color in input fields */
            --placeholder-color: #aaa; /* Placeholder text color */
            --border-color: #555; /* Subtle border color */
            --button-text-color: #1a1a1a; /* Text color on buttons */
            --error-color: #c0392b; /* Background color for error messages (red) */
            --success-color: #28a745; /* Background color for success messages (green) */
            --error-text-color: #ffffff; /* Text color for error messages */
            --success-text-color: #ffffff; /* Text color for success messages */
            --shadow-dark: rgba(0, 0, 0, 0.6); /* Darker shadow */
            --shadow-accent: rgba(0, 188, 212, 0.4); /* Accent colored shadow */
        }


        /* Container for the login form and welcome message */
        .main-content-container {
            display: flex; /* Use flexbox for layout */
            flex-direction: row; /* Default side-by-side on larger screens */
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Center items vertically (optional) */
            padding: 40px 20px; /* More padding */
            max-width: 1200px; /* Maximum width for the content area */
            margin: 0 auto; /* Center the container */
            flex-grow: 1; /* Allow container to grow and fill space */
        }

        /* ==================================================================== */
        /* Estilos para las secciones de formulario y bienvenida (compartidos) */
        /* Aplicamos estilos comunes a ambas clases */
        /* ==================================================================== */
        .registration-section, .login-section { /* Apply styles to both classes */
            flex: 1; /* Allow section to grow */
            max-width: 450px; /* Increased max-width for forms */
            margin: 0 20px; /* Space between sections/article */
            padding: 40px; /* Increased padding */
            background-color: var(--container-bg-color);
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 8px 20px var(--shadow-dark); /* Enhanced shadow */
            color: var(--text-color);
            text-align: center;
            box-sizing: border-box;
        }

        /* Estilos para los títulos de las secciones */
        .registration-section h2, .login-section h2 {
            color: var(--accent-color);
            margin-top: 0;
            margin-bottom: 2rem; /* More space below title */
            font-size: 2.2rem; /* Larger font size */
            text-shadow: 0 0 10px var(--shadow-accent); /* Enhanced shadow */
        }

        /* Estilos para los párrafos dentro de las secciones */
        .registration-section p, .login-section p {
            margin-top: 1.5rem; /* More space */
            margin-bottom: 1.5rem; /* More space */
            font-size: 1.1rem; /* Slightly larger font */
        }

        /* Estilos para los enlaces dentro de las secciones */
        .registration-section p a, .login-section p a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: bold;
        }

        .registration-section p a:hover, .login-section p a:hover {
            color: var(--accent-hover-color);
            text-decoration: underline;
        }

        /* Estilos para los formularios */
        .registration-section form, .login-section form {
            margin-top: 2rem; /* More space above form */
        }

        /* Estilos para los campos de entrada */
        .registration-section form input[type="email"],
        .registration-section form input[type="password"],
        .login-section form input[type="email"],
        .login-section form input[type="password"] {
            display: block;
            width: 100%; /* Full width within parent padding */
            padding: 14px; /* Increased padding */
            margin-bottom: 20px; /* More space below inputs */
            border: 1px solid var(--border-color);
            border-radius: 6px; /* More rounded corners */
            background-color: var(--input-bg-color);
            color: var(--input-text-color);
            font-size: 1.1rem; /* Slightly larger font */
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        /* Estilos para el placeholder */
        .registration-section form input::placeholder,
        .login-section form input::placeholder {
            color: var(--placeholder-color);
            opacity: 0.8;
        }

        /* Estilos para los inputs cuando están enfocados */
        .registration-section form input[type="email"]:focus,
        .registration-section form input[type="password"]:focus,
        .login-section form input[type="email"]:focus,
        .login-section form input[type="password"]:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 10px var(--shadow-accent); /* Enhanced glow */
            background-color: var(--input-bg-color-focus);
        }

        /* Estilos específicos para el checkbox de términos en registro */
        .registration-section .terms-checkbox {
            display: flex;
            align-items: center;
            margin-top: 15px;
            margin-bottom: 20px;
            font-size: 1rem;
            color: var(--text-color);
        }

        .registration-section .terms-checkbox input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            padding: 0;
            margin: 0 10px 0 0;
            background-color: var(--input-bg-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            flex-shrink: 0;
        }

        .registration-section .terms-checkbox input[type="checkbox"]:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            box-shadow: 0 0 5px var(--shadow-accent);
        }

        .registration-section .terms-checkbox input[type="checkbox"]:checked::after {
            content: '\2713';
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: var(--button-text-color);
        }

        .registration-section .terms-checkbox label {
            cursor: pointer;
            flex-grow: 1;
            text-align: left;
        }

        .registration-section .terms-checkbox label a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease, text-decoration 0.3s ease;
            font-weight: normal;
        }

        .registration-section .terms-checkbox label a:hover {
            color: var(--accent-hover-color);
            text-decoration: underline;
        }

        /* Estilos para el botón de submit (Regístrate / Iniciar Sesion) */
        .registration-section form input[type="submit"],
        .login-section form input[type="submit"] {
            display: inline-block;
            width: auto;
            padding: 12px 30px; /* Increased padding */
            background-color: var(--accent-color);
            color: var(--button-text-color);
            border: none;
            border-radius: 6px; /* More rounded corners */
            cursor: pointer;
            font-size: 1.2rem; /* Larger font */
            font-weight: bold;
            transition: background-color 0.3s ease, opacity 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            margin-top: 20px; /* More space above */
            margin-bottom: 20px; /* More space below */
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.3); /* Shadow with accent color */
        }

        .registration-section form input[type="submit"]:hover,
        .login-section form input[type="submit"]:hover {
            background-color: var(--accent-hover-color);
            opacity: 1;
            box-shadow: 0 6px 15px rgba(0, 188, 212, 0.4);
        }

        .registration-section form input[type="submit"]:active,
        .login-section form input[type="submit"]:active {
            transform: scale(0.98);
            box-shadow: 0 2px 5px rgba(0, 188, 212, 0.3);
        }

        /* ==================================================================== */
        /* Estilos para el artículo de bienvenida */
        /* ==================================================================== */
        .welcome-article {
            flex: 1; /* Allow article to grow */
            margin: 0 20px; /* Space between sections/article */
            padding: 40px; /* Increased padding */
            text-align: center;
            color: var(--text-color);
            /* Optional: Add a background or border to the article if needed */
            /* background-color: var(--container-bg-color); */
            /* border-radius: 12px; */
            /* box-shadow: 0 8px 20px var(--shadow-dark); */
        }

        /* Estilos para el título "Bienvenido" */
        .welcome-article h2 {
            color: var(--accent-color);
            font-size: 3.5rem; /* Much larger font size */
            margin-bottom: 1rem;
            text-shadow: 0 0 15px var(--shadow-accent), 0 0 20px rgba(0, 188, 212, 0.3); /* More prominent shadow/glow */
            line-height: 1.2;
        }

         /* Estilos para el párrafo de bienvenida */
         .welcome-article p {
            font-size: 1.2rem; /* Slightly larger font for the message */
            line-height: 1.6;
            margin-top: 1.5rem;
            color: var(--text-color); /* Ensure text color is correct */
         }

        /* ==================================================================== */
        /* Estilos para los mensajes de alerta (Éxito y Error) */
        /* ==================================================================== */
        #alerta {
            display: block;
            width: 90%;
            max-width: 600px;
            margin: 2rem auto; /* Centered with space */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            font-size: 1.1rem;
            font-weight: bold;
            /* Transition for smoother appearance if added dynamically */
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        /* Estilos específicos para alerta de error */
        #alerta.AlertaMala {
            background-color: var(--error-color); /* Rojo oscuro */
            color: var(--error-text-color); /* Texto blanco */
        }

        /* Estilos específicos para alerta de éxito */
        #alerta.AlertaBuena {
            background-color: var(--success-color); /* Verde */
            color: var(--success-text-color); /* Texto blanco */
        }


        /* ==================================================================== */
        /* Estilos Responsivos (ajustes para pantallas pequeñas) */
        /* ==================================================================== */

        /* Media Query for stacking breakpoint */
        @media (max-width: 800px) {
            .main-content-container {
                flex-direction: column; /* Stack items vertically */
                padding: 20px;
            }

            .registration-section, .login-section { /* Apply to both classes */
                width: 95%;
                max-width: 400px;
                margin: 1rem auto; /* Center and add vertical space */
                padding: 30px;
            }

            .registration-section h2, .login-section h2 {
                font-size: 2rem;
            }

            .registration-section form input[type="email"],
            .registration-section form input[type="password"],
            .login-section form input[type="email"],
            .login-section form input[type="password"] {
                width: 100%;
                padding: 12px;
                margin-bottom: 15px;
            }

            .registration-section form input[type="submit"],
            .login-section form input[type="submit"] {
                width: 100%;
                padding: 14px 20px;
                margin-top: 15px;
                margin-bottom: 15px;
                font-size: 1.1rem;
            }

            .welcome-article {
                width: 95%;
                max-width: 400px;
                margin: 2rem auto;
                padding: 30px;
                /* Remove or adjust article background/shadow if you added it */
            }

            .welcome-article h2 {
                font-size: 2.5rem;
            }

            #alerta { /* Adjust the alert on mobile */
                width: 90%;
                margin: 1.5rem auto;
            }
        }

        /* Further adjustments for very small screens */
        @media (max-width: 450px) {
            .registration-section, .login-section, .welcome-article { /* Apply to both classes */
                padding: 20px;
                margin: 1rem auto;
            }

            .registration-section h2, .login-section h2 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            .welcome-article h2 {
                font-size: 2rem;
            }

            #alerta {
                padding: 15px;
                margin: 1rem 10px;
            }

            /* Adjustment for checkbox on very small screens if necessary */
            .registration-section .terms-checkbox label {
                font-size: 0.95rem; /* Reduce font size slightly */
            }

            .registration-section .terms-checkbox input[type="checkbox"] {
                width: 18px; /* Adjust size if needed */
                height: 18px;
            }

            .registration-section .terms-checkbox input[type="checkbox"]:checked::after {
                font-size: 12px; /* Adjust checkmark size */
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
     <?php
    // Display the alert div if there is a message set
    if ($alertaMensaje !== "") {
        echo "<div id='alerta' class='" . htmlspecialchars($alertaClase) . "'>" . htmlspecialchars($alertaMensaje) . "</div>";
    }
    ?>

    <div class="main-content-container">
        <section class="login-section">
            <h2>Iniciar Sesión</h2>
            <p>¿Nuevo Usuario? <a href="registroUsuarios.php">¡Regístrate!</a></p>

            <form action="index.php" method="POST" onsubmit="return validarFormularioLogin()">
                <input type="email" id="correoUsuario" name="correoUsuario" placeholder="Ingrese su correo electrónico:" required>
                <input type="password" id="passUsuario" name="passUsuario" placeholder="Ingrese la contraseña:" required>

                <input type="submit" id="iniciar" value="Iniciar Sesion">
                </form>
        </section>

        <article class="welcome-article">
            <h2>Bienvenido</h2>
            <p>¡Inicia sesión para continuar explorando nuestra tienda y gestionar tu cuenta!</p>
            </article>
    </div>

    </body>
</html>