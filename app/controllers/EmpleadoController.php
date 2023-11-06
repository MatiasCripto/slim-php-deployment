<?php

require_once __DIR__ . '/../models/Empleado.php';



class EmpleadoController extends Empleado
{
    public static $roles = array("Bartender", "Cervecero", "Cocinero", "Pastelero", "Mozo", "Socio");
    public function CargarEmpleado($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombre'];
        $rol = $parametros['rol'];
    
        if (in_array($rol, $this::$roles))
        {
            $empleado = new Empleado();
            $empleado->nombre = $nombre;
            $empleado->rol = $rol;
            $empleado->AltaEmpleado();
            $payload = json_encode(array("Mensaje" => "Usuario creado con exito"));
        }
        else
        {
            $payload = json_encode(array("Mensaje" => "Rol de empleado no valido. (Bartender / Cervecero / Cocinero / Pastelero/ Mozo / Socio)"));
        }
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    public function MostrarEmpleados($request, $response, $args)
    {
        $lista = Empleado::GetEmpleados();
        $payload = json_encode(array("Empleados" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}    

?>