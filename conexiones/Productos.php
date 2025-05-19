<?php
require_once 'conexion.php';
class Productos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion(); // Crear una instancia de la clase de conexión existente
    }

    // Función para agregar productos a la base de datos
    public function agregarProductos($titulo, $descripcion, $precio, $stock, $imagen)
    {
        try {
            $sql = "INSERT INTO videojuego (titulo, descripcion, precio, stock, imagen) VALUES (:titulo, :descripcion, :precio, :stock, :imagen)";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':titulo', $titulo);
            $consulta->bindParam(':descripcion', $descripcion);
            $consulta->bindParam(':precio', $precio);
            $consulta->bindParam(':stock', $stock);
            $consulta->bindParam(':imagen', $imagen);
            $consulta->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    // Funcion para Mostrar todos los Productos registrados
    public function mostrarTodosProductos()
    {
        $sql = "SELECT * FROM videojuego";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Funcion para Mostrar todos los Productos registrados Segun el ID de forma Descendente para el PanelTrabajador
    public function mostrarTodosProductosAsc()
    {
        $sql = "SELECT * FROM videojuego ORDER BY idJuego DESC";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para mostrar todos los productos disponibles en stock
    public function mostrarProductos()
    {
        $sql = "SELECT * FROM videojuego WHERE stock > 0";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para mostrar los productos sin stock
    public function mostrarProductosSinStock()
    {
        $sql = "SELECT * FROM videojuego WHERE stock = 0";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para eliminar un producto (no utilizada en ninguna parte del documento)
    public function eliminarProducto($id)
    {
        $sql = "DELETE FROM videojuego WHERE idJuego = :id";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    // Función para obtener los detalles de un producto específico
    public function obtenerProducto($id)
    {
        $sql = "SELECT * FROM videojuego WHERE idJuego = :id";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Función para actualizar el precio de un producto
    public function actualizarProducto($id, $precio)
    {
        try {
            $sql = "UPDATE videojuego SET precio = :precio WHERE idJuego = :id";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->bindParam(':precio', $precio);
            $consulta->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    
    // Función para restar la cantidad de stock de un producto
    public function restarStock($idJuego, $cantidad)
    {
        $sql = "UPDATE videojuego SET stock = stock - :cantidad WHERE idJuego = :idJuego";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':idJuego', $idJuego);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    }

    // Función para verificar si hay suficiente stock de un producto
    public function verificarStock($idJuego, $cantidad)
    {
        $sql = "SELECT stock FROM videojuego WHERE idJuego = :idJuego";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':idJuego', $idJuego);
        $consulta->execute();
        $stock = $consulta->fetchColumn();

        return $stock >= $cantidad;
    }

    // Función para actualizar la cantidad de stock de un producto
    public function actualizarStock($id, $stock)
    {
        try {
            $sql = "UPDATE videojuego SET stock = :stock WHERE idJuego = :id";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->bindParam(':stock', $stock);
            $consulta->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Función para mostrar los productos más baratos (limitado a 3 productos) esta Funcion la usaremos para mostrar los productos en el lobby
    public function mostrarProductosmasBaratos()
    {
        $sql = "SELECT * FROM videojuego WHERE stock > 0 ORDER BY precio ASC LIMIT 4";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
