<?php

class Empleado
{
    public $id;
    public $nombre;  
    public $clave;  
    public $rol;
    public $fechaAlta;
    public $fechaBaja;

    public function AltaEmpleado()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleado (nombre, clave, rol, fechaAlta) VALUES (:nombre, :clave, :rol, :fechaAlta)");
        $fechaAlta = new DateTime(date("d-m-Y"));
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);      
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);  
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':fechaAlta', date_format($fechaAlta, "Y-m-d"));

        $consulta->execute();
    }    

    public static function GetEmpleados()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleado");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }

    public static function GetEmpleadoPorNombre($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleado WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchObject("Empleado");
    }

    public static function DeleteEmpleado($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleado SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d'));
        $consulta->execute();
    }

    public static function GetEmpleadoPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleado WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchObject("Empleado");
    }

    public static function UpdateEmpleado($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleado SET fechaBaja = :fechaBaja WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', 0000-00-00);
        $consulta->execute();
    }
    
}

?>