<?php
class Conexion extends PDO
{
    private $usuario = "root";
    private $contra = "";
    private $db = "empresa";
    private $host = "localhost";
    public function __construct()
    {
        try {
            // Establecer la conexión con la base de datos utilizando PDO
            parent::__construct("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->usuario, $this->contra);
        } catch (PDOException $e) {
            echo ("Error: " . $e->getMessage());
            exit;
        }
    }

    // Función para realizar el inicio de sesión de un usuario
    public function login($correoUsuario, $passUsuario)
    {
        $sql = "SELECT * FROM usuarios WHERE correoUsuario = :correoUsuario AND passUsuario = :passUsuario";
        $consulta = $this->prepare($sql);
        $consulta->bindParam(':correoUsuario', $correoUsuario);
        $consulta->bindParam(':passUsuario', $passUsuario);
        $consulta->execute();
        $encontrado = $consulta->rowCount();

        if ($encontrado) {
            // Obtener el ID_Rol del usuario
            $row = $consulta->fetch(PDO::FETCH_ASSOC);
            $idRol = $row['ID_Rol'];
            return $idRol; // Devuelve el ID_Rol si las credenciales son correctas
        } else {
            return false; // Si las credenciales son incorrectas devuelve false
        }
    }

    // Función para registrar un nuevo usuario
    public function register($correoUsuario, $passUsuario, $rol)
    {
        // Verifica si los datos requeridos están presentes
        if (empty($correoUsuario) || empty($passUsuario) || empty($rol)) {
            return false;
        }
    
        $sql = "INSERT INTO usuarios (correoUsuario, passUsuario, ID_Rol) VALUES (:correoUsuario, :passUsuario, :rol)";
        $consulta = $this->prepare($sql);
        $consulta->bindParam(':correoUsuario', $correoUsuario);
        $consulta->bindParam(':passUsuario', $passUsuario);
        $consulta->bindParam(':rol', $rol);
        $consulta->execute();
    
        return $consulta->rowCount() > 0;
    }

    // Función para obtener todos los usuarios
    public function obtenerUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $consulta = $this->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para modificar el rol de un usuario
    public function modificarRol($correoUsuario, $rol)
    {
        $sql = "UPDATE usuarios SET ID_Rol = :rol WHERE correoUsuario = :correoUsuario";
        $consulta = $this->prepare($sql);
        $consulta->bindParam(':rol', $rol);
        $consulta->bindParam(':correoUsuario', $correoUsuario);
        $consulta->execute();
    
        return $consulta->rowCount() > 0;
    }

    //Esta funcion Elimina en base al correo usuario para el panelAdministrador
    public function eliminarUsuario($correoUsuario)
    {
    $sql = "DELETE FROM usuarios WHERE correoUsuario = :correoUsuario";
    $consulta = $this->prepare($sql);
    $consulta->bindParam(':correoUsuario', $correoUsuario);
    $consulta->execute();

    return $consulta->rowCount() > 0;
}
}
