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
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleado (nombre,rol, fechaAlta) VALUES (:nombre, clave:, :rol, :fechaAlta)");
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
    
}

?>