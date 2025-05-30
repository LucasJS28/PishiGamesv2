<?php
require_once 'Conexion.php';

class Pedidos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion(); // Crear una instancia de la clase de conexión existente
    }

    // Función para realizar un pedido
    public function realizarPedido($idUsuario, $fechaPedido, $estado, $detalles, $total)
    {
        $sql = "INSERT INTO pedidos (idUsuario, fechaPedido, estado, detalles, total) VALUES (:idUsuario, :fechaPedido, :estado, :detalles, :total)";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':idUsuario', $idUsuario);
        $consulta->bindParam(':fechaPedido', $fechaPedido);
        $consulta->bindParam(':estado', $estado);
        $consulta->bindParam(':detalles', $detalles);
        $consulta->bindParam(':total', $total);
        $consulta->execute();
        return $consulta->rowCount() > 0;
    }

    // Función para mostrar los pedidos de un usuario específico
    public function mostrarPedidosxUsuario($idUsuario, $orderBy = 'fechaPedido DESC', $statusFilter = null)
    {
        $sql = "SELECT * FROM pedidos WHERE idUsuario = :idUsuario";
        $params = [':idUsuario' => $idUsuario];

        if ($statusFilter !== null && $statusFilter !== '') {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $statusFilter;
        }

        // Validate orderBy to prevent SQL injection
        $validOrderBy = [
            'fechaPedido DESC',
            'fechaPedido ASC',
            'estado ASC', // You could add these for more flexibility if needed
            'estado DESC'
        ];

        if (in_array($orderBy, $validOrderBy)) {
            $sql .= " ORDER BY " . $orderBy;
        } else {
            // Default to prevent invalid input
            $sql .= " ORDER BY fechaPedido DESC";
        }


        $consulta = $this->conexion->prepare($sql);
        $consulta->execute($params); // Pass parameters directly to execute for PDO
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    // Función para mostrar todos los pedidos
    public function mostrarPedidos()
    {
        $sql = "SELECT * FROM pedidos";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para actualizar el estado de un pedido
    public function actualizarEstadoPedido($idPedido, $estado)
    {
        $sql = "UPDATE pedidos SET estado = :estado WHERE idPedido = :idPedido";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':estado', $estado);
        $consulta->bindParam(':idPedido', $idPedido);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    }

    // Función para eliminar un pedido
    public function eliminarPedido($idPedido)
    {
        $sql = "DELETE FROM pedidos WHERE idPedido = :idPedido";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':idPedido', $idPedido);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    }

    // Función para obtener el último ID de pedido registrado en la base de datos
    public function obtenerUltimoIdPedido()
    {
        $sql = "SELECT idPedido FROM pedidos ORDER BY idPedido DESC LIMIT 1";
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['idPedido'];
        }
        return null;
    }
}
