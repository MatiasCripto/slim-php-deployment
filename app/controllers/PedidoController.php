<?php
require_once __DIR__ . '/../models/Pedido.php';

require_once __DIR__ . '/../models/Producto.php';

require_once __DIR__ . '/../models/Mesa.php';

class PedidoController extends Pedido
{
    public function CargarPedido($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $idProducto = Producto::GetProductoPorId($parametros['idProducto']);
        $cantidadProductos = $parametros['cantidadProductos'];
        $idMesa = Mesa::GetMesaPorId($parametros['idMesa']);
        $codigoPedido = $parametros['codigoPedido'];

        if($idProducto != null && $idMesa != null)
        {
            $pedido = new Pedido();
            $pedido->idEmpleado = 0;
            $pedido->idProducto = $parametros['idProducto'];
            $pedido->cantidadProductos = $cantidadProductos;
            $pedido->idMesa = $parametros['idMesa'];
            $pedido->estado = "Pendiente";
            $pedido->codigoPedido = $codigoPedido;
            $pedido->tiempoPreparacion = 0;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $pedido->horaCreacion = new DateTime(date("h:i:sa"));
            if(file_exists($_FILES["fotoMesa"]["tmp_name"]))
            {
                $pedido->fotoMesa = $this->MoverFoto($pedido->codigoPedido);
            }
            $pedido->AltaPedido();
            $payload = json_encode(array("Mensaje" => "Pedido creado con exito"));
        }
        else
        {
            $payload = json_encode(array("Mensaje" => "El producto o la mesa no existen!"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function MoverFoto($codigo)
    {
        $fotosMesa = ".".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
        if(!file_exists($fotosMesa))
        {
            mkdir($fotosMesa, 0777, true);
        }
        $nombreFoto = $fotosMesa."fotoMesa-".$codigo.".jpg";
        if(!file_exists($nombreFoto))
        {
            rename($_FILES["fotoMesa"]["tmp_name"], $nombreFoto);
        }
        return $nombreFoto;
    }

    public function MostrarPedidos($request, $response, $args)
    {
        $lista = Pedido::GetPedidos();
        $payload = json_encode(array("Pedidos" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


}

?>