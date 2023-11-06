<?php
require_once __DIR__ . '/../models/Producto.php';


class ProductoController extends Producto
{
    public static $sectres = array("Vinoteca", "Cerveceria", "Cocina", "CandyBar");
    public function CargarProducto($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $descripcion = $parametros['descripcion'];
        $precio = $parametros['precio'];
        $sector = $parametros['sector'];

        if(in_array($sector, $this::$sectres))
        {
            $producto = new Producto();
            $producto->descripcion = $descripcion;
            $producto->precio = $precio;
            $producto->sector = $sector;
            $producto->AltaProducto();
            $payload = json_encode(array("Mensaje" => "Producto creado con exito"));
        }
        else
        {
            $payload = json_encode(array("Mensaje" => "Sector de producto no valido. (Vinoteca / Cerveceria / Cocina / CandyBar)"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function MostrarProductos($request, $response, $args)
    {
        $lista = Producto::GetProductos();
        $payload = json_encode(array("Productos" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }   
}

?>