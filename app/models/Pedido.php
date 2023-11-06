<?php

class Pedido
{
    public $id;
    public $idEmpleado;
    public $idProducto;
    public $cantidadProductos;
    public $idMesa;
    public $estado;
    public $codigoPedido;
    public $fotoMesa;
    public $tiempoPreparacion;
    public $horaCreacion;

    public function AltaPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedido (idEmpleado, idProducto, cantidadProductos, idMesa, estado, codigoPedido, fotoMesa, tiempoPreparacion, horaCreacion) VALUES (:idEmpleado, :idProducto, :cantidadProductos, :idMesa, :estado, :codigoPedido, :fotoMesa, :tiempoPreparacion, :horaCreacion)");
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':idProducto', $this->idProducto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidadProductos', $this->cantidadProductos, PDO::PARAM_INT);
        $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':fotoMesa', $this->fotoMesa);
        $consulta->bindValue(':codigoPedido', $this->codigoPedido);
        $consulta->bindValue(':tiempoPreparacion', $this->tiempoPreparacion, PDO::PARAM_INT);
        $consulta->bindValue(':horaCreacion', date_format($this->horaCreacion, 'H:i:sa'));
        $consulta->execute();
    }

    public static function GetPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedido");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }
}

?>

