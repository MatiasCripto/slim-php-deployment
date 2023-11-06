<?php
require_once __DIR__ . '/../models/Mesa.php';

require_once __DIR__ . '/../models/Pedido.php';


class MesaController extends Mesa
{
    public static $estados = array("con cliente esperando pedido", "con cliente comiendo", "con cliente pagando", "cerrada");
    public function CargarMesa($request, $response, $args)
    {
    $parametros = $request->getParsedBody();
    $estado = $parametros['estado'];
    $codigoUnico = $parametros['codigoUnico']; // Nuevo atributo

    if (in_array($estado, $this::$estados) && strlen($codigoUnico) === 5) {
        $mesa = new Mesa();
        $mesa->estado = $estado;
        $mesa->codigoUnico = $codigoUnico;
        $mesa->AltaMesa();
        $payload = json_encode(array("Mensaje" => "Mesa creada con exito"));
    } else {
        $payload = json_encode(array("Mensaje" => "Estado de mesa no valido o codigo unico debe tener 5 caracteres."));
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
    }

    public function MostrarMesas($request, $response, $args)
    {
    $lista = Mesa::GetMesas();
    $mesas = array();

    foreach ($lista as $mesa) {
        $mesas[] = array(
            "id" => $mesa->id,
            "estado" => $mesa->estado,
            "codigoUnico" => $mesa->codigoUnico // Incluir el código único
        );
    }

    $payload = json_encode(array("Mesas" => $mesas));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
    }

    
}

?>