<?php
session_start();
require_once "../conexiones/Conexion.php";
$conexion = new Conexion();

/* Verifica que exista un usuario logeado */
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}

/* Verifica que el Usuario sea un administrador en caso de no serlo lo reenvía al login */
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Administrador") {
    header("Location:../index.php");
    exit();
}
/* Realiza el Registro de Usuarios administradores, jefes o trabajadores en la Base de Datos */
if ($_POST) {
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "";
    $rol = isset($_POST["rol"]) ? $_POST["rol"] : "";
    try {
        // Código que puede generar la excepción
        $registroExitoso = $conexion->register($correo, $contrasena, $rol);
        if ($registroExitoso) {
            $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Registro Realizado con Éxito</div>";
            header("Location: panelAdministrador.php"); // Redirecciona a la página actualizada
            exit();
        } else {
            $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al Registrar</div>";
        }
    } catch (PDOException $e) {
        // Manejo de la excepción
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>El Correo ya se Encuentra Registrado</div>";
    }
}

/* Elimina un usuario */
if (isset($_POST["eliminarUsuario"])) {
    $correoUsuario = $_POST["eliminarUsuario"];
    $eliminacionExitosa = $conexion->eliminarUsuario($correoUsuario);
    if ($eliminacionExitosa) {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Usuario eliminado exitosamente</div>";
        echo "success";
    } else {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al eliminar el usuario</div>";
        echo "error";
    }
    exit();
}

/* Actualiza el rol de un usuario */
if (isset($_POST["correoUsuario"]) && isset($_POST["rol"])) {
    $correoUsuario = $_POST["correoUsuario"];
    $rol = $_POST["rol"];
    $actualizacionExitosa = $conexion->modificarRol($correoUsuario, $rol);
    if ($actualizacionExitosa) {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Se Modificó el Rol de manera Exitosa</div>";
        echo "success";
    } else {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al Modificar el Rol</div>";
        echo "error";
    }
    exit();
}

if (isset($_SESSION['alerta'])) {
    $alerta = $_SESSION['alerta'];
    echo $alerta;
    unset($_SESSION['alerta']);
}

$usuarios = $conexion->obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Trabajadores</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/scriptsValidaciones.js"></script>
    <script src="../scripts/ajax.js"></script>
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

/* --- Estilos para el Contenedor Principal (Formulario y Tabla) --- */
.contenedor {
    background-color: var(--primary-dark);
    padding: 2.5rem;
    margin: 2.5rem auto;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6), 0 0 20px var(--accent-blue) inset;
    width: 90%;
    max-width: 900px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem; /* Espacio entre elementos principales */
    border: 1px solid var(--accent-blue);
}

.titulo, .titulo-registrados {
    color: var(--highlight-neon);
    font-size: 2.2rem;
    margin-bottom: 1.5rem;
    text-align: center;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.7);
}

.titulo-registrados {
    margin-top: 2.5rem;
    border-top: 2px solid var(--accent-blue);
    padding-top: 2rem;
    width: 100%;
}

/* --- Estilos del Formulario de Registro --- */
form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 450px;
    gap: 1rem; /* Espacio entre los elementos del formulario */
    padding: 1.5rem;
    background-color: var(--bg-dark);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

form label {
    color: var(--text-light);
    font-weight: 600;
    margin-bottom: 0.3rem;
    display: block;
}

form input[type="email"],
form input[type="password"],
form select {
    padding: 0.9rem 1.2rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: rgba(15, 52, 96, 0.2);
    color: var(--text-light);
    font-size: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.4);
}

form input[type="email"]:focus,
form input[type="password"]:focus,
form select:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.3), inset 0 0 8px rgba(233, 69, 96, 0.2);
}

form select option {
    background-color: var(--bg-dark); /* Asegura que las opciones tengan un fondo oscuro */
    color: var(--text-light);
}

form input[type="submit"] {
    background-color: var(--highlight-neon);
    color: var(--text-light);
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: bold;
    margin-top: 1.5rem;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
}

form input[type="submit"]:hover {
    background-color: #d63c55; /* Un poco más oscuro */
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6), 0 0 20px var(--highlight-neon);
}

/* --- Estilos del Buscador --- */
#buscador {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 500px;
    margin-bottom: 2rem;
    padding: 1rem;
    background-color: rgba(15, 52, 96, 0.3);
    border-radius: 10px;
    border: 1px solid var(--accent-blue);
}

#titulo-buscar {
    color: var(--text-light);
    font-weight: 600;
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
}

#buscar {
    width: 90%;
    padding: 0.8rem 1.2rem;
    border: 1px solid var(--accent-blue);
    border-radius: 8px;
    background-color: var(--bg-dark);
    color: var(--text-light);
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.4);
}

#buscar:focus {
    outline: none;
    border-color: var(--highlight-neon);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.3), inset 0 0 8px rgba(233, 69, 96, 0.2);
}

/* --- Estilos de la Tabla de Usuarios --- */
.tabla-principal {
    width: 100%;
    border-collapse: separate; /* Permite border-radius en las celdas */
    border-spacing: 0;
    margin-top: 1.5rem;
    background-color: var(--bg-dark);
    border-radius: 10px;
    overflow: hidden; /* Asegura que el border-radius se aplique */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5), 0 0 10px var(--accent-blue) inset;
}

.tabla-principal thead {
    background-color: var(--accent-blue);
}

.tabla-principal th {
    color: var(--text-light);
    padding: 1.2rem 1rem;
    text-align: left;
    font-weight: bold;
    border-bottom: 1px solid var(--primary-dark);
    font-size: 1.05rem;
}

.tabla-principal th:first-child {
    border-top-left-radius: 10px;
}

.tabla-principal th:last-child {
    border-top-right-radius: 10px;
}

.tabla-principal td {
    color: var(--text-light);
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    vertical-align: middle;
}

.tabla-principal tbody tr:last-child td {
    border-bottom: none;
}

.tabla-principal tbody tr:nth-child(even) {
    background-color: rgba(0, 0, 0, 0.15); /* Alternating row color */
}

.tabla-principal tbody tr:hover {
    background-color: var(--hover-bg);
    transition: background-color 0.3s ease;
}

.tabla-principal td select {
    padding: 0.5rem 0.8rem;
    border: 1px solid var(--accent-blue);
    border-radius: 5px;
    background-color: rgba(15, 52, 96, 0.4);
    color: var(--text-light);
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tabla-principal td select:hover {
    border-color: var(--highlight-neon);
}

.tabla-principal td select:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(233, 69, 96, 0.3);
}

.tabla-principal td button.button-eliminar {
    background-color: #c70039; /* Un rojo oscuro para eliminar */
    color: var(--text-light);
    border: none;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.tabla-principal td button.button-eliminar:hover {
    background-color: #a3002f; /* Más oscuro al hover */
    transform: translateY(-1px);
}

/* --- Estilos para Alertas (Si usas las clases AlertaBuena/AlertaMala) --- */
.AlertaBuena, .AlertaMala {
    padding: 1rem;
    margin: 1.5rem auto;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    animation: fadeInOut 5s forwards; /* Animación para que desaparezca */
}

.AlertaBuena {
    background-color: rgba(40, 167, 69, 0.8); /* Verde semi-transparente */
    color: white;
    border: 1px solid #28a745;
}

.AlertaMala {
    background-color: rgba(220, 53, 69, 0.8); /* Rojo semi-transparente */
    color: white;
    border: 1px solid #dc3545;
}

@keyframes fadeInOut {
    0% { opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { opacity: 0; display: none; }
}

/* --- Media Queries para Responsividad --- */
@media (max-width: 768px) {
    .contenedor {
        padding: 2rem;
        margin: 1.5rem auto;
        width: 95%;
    }

    .titulo, .titulo-registrados {
        font-size: 1.8rem;
    }

    form {
        padding: 1rem;
    }

    form input[type="email"],
    form input[type="password"],
    form select,
    form input[type="submit"],
    #buscar {
        padding: 0.8rem;
        font-size: 0.95rem;
    }

    /* Tabla responsiva */
    .tabla-principal, .tabla-principal thead, .tabla-principal tbody, .tabla-principal th, .tabla-principal td, .tabla-principal tr {
        display: block;
    }

    .tabla-principal thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    .tabla-principal tr {
        border: 1px solid var(--accent-blue);
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    .tabla-principal td {
        border: none;
        position: relative;
        padding-left: 50%;
        text-align: right;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        min-height: 50px;
    }

    .tabla-principal td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 45%;
        padding-left: 1rem;
        font-weight: bold;
        text-align: left;
        color: var(--highlight-neon);
    }
    
    .tabla-principal td:nth-of-type(1):before { content: "Correo:"; }
    .tabla-principal td:nth-of-type(2):before { content: "Rol:"; }
    .tabla-principal td:nth-of-type(3):before { content: "Acción:"; }

    .tabla-principal td select {
        width: auto; /* Permitir que el select se ajuste al contenido */
        max-width: 100%;
        text-align-last: right;
        flex-grow: 1; /* Ocupa el espacio restante */
    }

    .tabla-principal td button.button-eliminar {
        width: auto;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .contenedor {
        padding: 1.5rem;
        margin: 1rem auto;
    }

    .titulo, .titulo-registrados {
        font-size: 1.6rem;
    }

    form {
        padding: 0.8rem;
    }

    form input[type="email"],
    form input[type="password"],
    form select,
    form input[type="submit"],
    #buscar {
        padding: 0.7rem;
        font-size: 0.9rem;
    }

    .tabla-principal td {
        padding-left: 45%;
    }
}
</style>
<body>
    <?php include 'navAdministracion.php'; ?>
    <div class="contenedor">
        <h1 class="titulo">Registro de Trabajadores</h1>
        <form action="panelAdministrador.php" method="POST" onsubmit="return validarFormularioRegistroAdmin()">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" id="correo" required>
            <br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>
            <br>
            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="1">Administrador</option>
                <option value="3">Jefe</option>
                <option value="2">Trabajador</option>
            </select>
            <br>
            <input type="submit" value="Registrarse">
        </form>
        <br>
        <br>
        <h2 class="titulo-registrados">Usuarios Registrados</h2>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Correo</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese el Correo a buscar">
        </div>
        <table class="tabla-principal">
            <thead>
                <tr>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr id="fila-<?php echo $usuario['correoUsuario']; ?>" class="correoUsuario">
                        <td>
                            <?php echo $usuario['correoUsuario']; ?>
                        </td>
                        <td data-correo="<?php echo $usuario['correoUsuario']; ?>">
                            <select onchange="actualizarRol('<?php echo $usuario['correoUsuario']; ?>', this.value)">
                                <option value="1" <?php if ($usuario['ID_Rol'] == "1") echo 'selected'; ?>>Administrador</option>
                                <option value="3" <?php if ($usuario['ID_Rol'] == "3") echo 'selected'; ?>>Jefe</option>
                                <option value="2" <?php if ($usuario['ID_Rol'] == "2") echo 'selected'; ?>>Trabajador</option>
                                <option value="4" <?php if ($usuario['ID_Rol'] == "4") echo 'selected'; ?>>Usuario</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="button-eliminar" onclick="eliminarUsuario('<?php echo $usuario['correoUsuario']; ?>')">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>