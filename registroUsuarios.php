<?php
require_once "conexiones/Conexion.php";

// Inicia la sesión si no está iniciada (aunque nav.php podría ya hacerlo)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conexion = new Conexion();
$alertaMensaje = ""; // Variable para almacenar el mensaje de alerta
$alertaClase = ""; // Variable para almacenar la clase de la alerta ('AlertaBuena' o 'AlertaMala')

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Usar REQUEST_METHOD para ser más robusto
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $repecontra = $_POST["repecontra"];
    $rol = 4; /* Especifica que el registro es un usuario */

    try {
        if ($contrasena === $repecontra) { // Usar === para comparación estricta
            // Aquí podrías añadir validaciones adicionales si las tienes en scriptsValidaciones.js
            // y verificar si pasaron antes de intentar el registro en la base de datos.

            $registroExitoso = $conexion->register($correo, $contrasena, $rol);

            if ($registroExitoso) {
                $alertaMensaje = "¡Registro exitoso! Ahora puedes iniciar sesión.";
                $alertaClase = "AlertaBuena";
                // Opcional: redirigir al login después de un registro exitoso
                // header("Location: index.php?registered=1");
                // exit;
            } else {
                $alertaMensaje = "El correo electrónico ya está registrado.";
                $alertaClase = "AlertaMala";
            }
        } else {
            $alertaMensaje = "Las contraseñas no coinciden. Inténtalo de nuevo.";
            $alertaClase = "AlertaMala";
        }
    } catch (PDOException $e) {
         // Esto capturaría errores específicos de PDO, como una violación de clave única si el correo es UNIQUE
         // La lógica interna de register() en tu clase Conexion debería manejar esto,
         // pero esta es una capa de seguridad adicional si la excepción llega aquí.
         // Ajusta el mensaje si tu método register() ya devuelve false en caso de correo duplicado
         // como parece que hace en tu else $registroExitoso.
        $alertaMensaje = "Error en el registro. Si el problema persiste, contacta al soporte."; // Mensaje genérico por seguridad
        $alertaClase = "AlertaMala";
        // Si sabes que la excepción es por correo duplicado y register() no lo maneja, puedes ser más específico:
        // if ($e->getCode() == 23000) { // Código típico para violación de unique constraint en MySQL
        //     $alertaMensaje = "El correo electrónico ya está registrado.";
        //     $alertaClase = "AlertaMala";
        // } else {
        //    $alertaMensaje = "Ocurrió un error inesperado. Inténtalo más tarde.";
        //    $alertaClase = "AlertaMala";
        // }
    }
}
?>
<!DOCTYPE html>
<html lang="es"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios - Pishi Games</title> <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="scripts/scriptsValidaciones.js"></script> </head>
<style>
    /* Define CSS Variables for the theme (Asegúrate de que estén definidas en :root) */
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

/* Basic body styling (assuming nav takes space at top) */
/* Reutiliza los estilos del body de la página de login */

/* Container for the login form and welcome message */
/* Reutiliza los estilos del main-content-container de la página de login */
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
/* Estilos para el formulario de registro                             */
/* ==================================================================== */

/* Estilos para el contenedor principal del formulario de registro */
.registration-section { /* Usamos una clase específica */
    flex: 1; /* Allow section to grow */
    max-width: 450px; /* Increased max-width for form */
    margin: 0 20px; /* Space between sections/article */
    padding: 40px; /* Increased padding */
    background-color: var(--container-bg-color);
    border-radius: 12px; /* More rounded corners */
    box-shadow: 0 8px 20px var(--shadow-dark); /* Enhanced shadow */
    color: var(--text-color);
    text-align: center;
    box-sizing: border-box;
}

/* Estilos para el título "Registro de Usuarios" */
.registration-section h2 {
    color: var(--accent-color);
    margin-top: 0;
    margin-bottom: 2rem; /* More space below title */
    font-size: 2.2rem; /* Larger font size */
    text-shadow: 0 0 10px var(--shadow-accent); /* Enhanced shadow */
}

/* Estilos para los párrafos dentro de la sección */
.registration-section p {
    margin-top: 1.5rem; /* More space */
    margin-bottom: 1.5rem; /* More space */
    font-size: 1.1rem; /* Slightly larger font */
}

/* Estilos para los enlaces dentro de la sección */
.registration-section p a {
    color: var(--accent-color);
    text-decoration: none;
    transition: color 0.3s ease;
    font-weight: bold;
}

.registration-section p a:hover {
    color: var(--accent-hover-color);
    text-decoration: underline;
}


/* Estilos para el formulario */
.registration-section form {
    margin-top: 2rem; /* More space above form */
}

/* Estilos para los campos de entrada (correo, contraseña, repetir contraseña) */
.registration-section form input[type="email"],
.registration-section form input[type="password"] {
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

/* Estilos para el placeholder dentro de los inputs */
.registration-section form input::placeholder {
    color: var(--placeholder-color);
    opacity: 0.8;
}

/* Estilos para los inputs cuando están enfocados (seleccionados) */
.registration-section form input[type="email"]:focus,
.registration-section form input[type="password"]:focus {
    border-color: var(--accent-color);
    outline: none;
    box-shadow: 0 0 10px var(--shadow-accent); /* Enhanced glow */
    background-color: var(--input-bg-color-focus);
}

/* Estilos para el contenedor del checkbox de términos */
.terms-checkbox {
    display: flex; /* Usa flexbox para alinear checkbox y label */
    align-items: center; /* Alinea verticalmente al centro */
    margin-top: 15px; /* Espacio arriba */
    margin-bottom: 20px; /* Espacio abajo */
    font-size: 1rem; /* Tamaño de fuente */
    color: var(--text-color);
}

/* Estilos para el checkbox (personalizado) */
.terms-checkbox input[type="checkbox"] {
    /* Oculta el checkbox nativo */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px; /* Tamaño del checkbox personalizado */
    height: 20px;
    padding: 0;
    margin: 0 10px 0 0; /* Espacio a la derecha */
    background-color: var(--input-bg-color);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    cursor: pointer;
    position: relative; /* Necesario para el pseudo-elemento del checkmark */
    transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    flex-shrink: 0; /* Evita que el checkbox se encoja */
}

/* Estilo cuando el checkbox está marcado */
.terms-checkbox input[type="checkbox"]:checked {
    background-color: var(--accent-color); /* Color de acento cuando está marcado */
    border-color: var(--accent-color);
    box-shadow: 0 0 5px var(--shadow-accent);
}

/* Estilo del checkmark (el visto) dentro del checkbox */
.terms-checkbox input[type="checkbox"]:checked::after {
    content: '\2713'; /* Código Unicode para un checkmark */
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 14px; /* Tamaño del checkmark */
    color: var(--button-text-color); /* Color oscuro para el checkmark */
}

/* Estilo para la label del checkbox */
.terms-checkbox label {
     cursor: pointer; /* Indica que se puede hacer clic */
     flex-grow: 1; /* Permite que la label ocupe el espacio restante */
     text-align: left; /* Alinea el texto a la izquierda */
}

/* Estilo para el enlace dentro de la label (Términos y Condiciones) */
.terms-checkbox label a {
    color: var(--accent-color); /* Color de acento para el enlace */
    text-decoration: none;
    transition: color 0.3s ease, text-decoration 0.3s ease;
    font-weight: normal; /* No negrita */
}

.terms-checkbox label a:hover {
     color: var(--accent-hover-color);
     text-decoration: underline;
}


/* Estilos para el botón de Regístrate */
.registration-section form input[type="submit"] {
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

.registration-section form input[type="submit"]:hover {
    background-color: var(--accent-hover-color);
    opacity: 1;
    box-shadow: 0 6px 15px rgba(0, 188, 212, 0.4);
}

.registration-section form input[type="submit"]:active {
    transform: scale(0.98);
    box-shadow: 0 2px 5px rgba(0, 188, 212, 0.3);
}


/* ==================================================================== */
/* Estilos para el artículo de bienvenida                             */
/* ==================================================================== */

/* Reutiliza los estilos del welcome-article de la página de login */
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


/* ==================================================================== */
/* Estilos para los mensajes de alerta (Éxito y Error)                */
/* ==================================================================== */

/* Estilos para el div de alerta general */
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
/* Estilos Responsivos (ajustes para pantallas pequeñas)             */
/* ==================================================================== */

/* Media Query para breakpoint de stacking (Reutiliza el breakpoint de login) */
@media (max-width: 800px) {
    .main-content-container {
        flex-direction: column; /* Stack items vertically */
        padding: 20px;
    }

    .registration-section { /* Apunta a la nueva clase */
        width: 95%;
        max-width: 400px;
        margin: 1rem auto; /* Center and add vertical space */
        padding: 30px;
    }

     .registration-section h2 {
        font-size: 2rem;
     }

    .registration-section form input[type="email"],
    .registration-section form input[type="password"] {
         width: 100%;
         padding: 12px;
         margin-bottom: 15px;
    }

     .registration-section form input[type="submit"] {
         width: 100%;
         padding: 14px 20px;
         margin-top: 15px;
         margin-bottom: 15px;
         font-size: 1.1rem;
     }

    .welcome-article { /* Reutiliza */
        width: 95%;
        max-width: 400px;
        margin: 2rem auto;
        padding: 30px;
         /* Remove or adjust article background/shadow if you added it */
    }

    .welcome-article h2 {
        font-size: 2.5rem;
    }

    #alerta { /* Ajusta la alerta en móvil */
        width: 90%;
        margin: 1.5rem auto;
    }
}

/* Further adjustments for very small screens (Reutiliza) */
@media (max-width: 450px) {
    .registration-section, .welcome-article { /* Apunta a la nueva clase */
        padding: 20px;
        margin: 1rem auto;
    }

    .registration-section h2 {
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

    /* Ajuste específico para el checkbox en pantallas muy pequeñas si es necesario */
    .terms-checkbox label {
        font-size: 0.95rem; /* Reduce un poco el tamaño de la fuente */
    }

     .terms-checkbox input[type="checkbox"] {
         width: 18px; /* Ajusta tamaño si es necesario */
         height: 18px;
     }

     .terms-checkbox input[type="checkbox"]:checked::after {
         font-size: 12px; /* Ajusta tamaño del checkmark */
     }
}
</style>
<body>
    <?php include 'nav.php'; ?>

    <?php
    // Muestra el div de alerta si hay un mensaje
    if ($alertaMensaje !== "") {
        echo "<div id='alerta' class='" . htmlspecialchars($alertaClase) . "'>" . htmlspecialchars($alertaMensaje) . "</div>";
    }
    ?>

    <div class="main-content-container"> <section class="registration-section"> <h2>Registro de Usuarios</h2>
            <p>¿Ya tienes cuenta? <a href="index.php">¡Ir al inicio de sesión!</a></p>

            <form action="registroUsuarios.php" method="POST" class="formu" onsubmit="return validarFormularioRegistro()">
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo electrónico:" required>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese su contraseña:" required>
                <input type="password" id="repecontra" name="repecontra" placeholder="Repita su Contraseña:" required>

                <div class="terms-checkbox"> <input type="checkbox" id="terminos" required>
                    <label for="terminos">Acepto los <a href="terminosycondiciones.php">Términos y Condiciones</a></label>
                </div>

                <input type="submit" id="iniciar" value="Regístrate">
            </form>
        </section>

        <article class="welcome-article"> <h2>Bienvenido</h2>
             <p>Únete a nuestra comunidad de gamers. Regístrate para acceder a ofertas exclusivas y gestionar tus compras.</p>
        </article>

    </div> </body>

</html>