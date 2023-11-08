<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/db/AccesoDatos.php';
require_once __DIR__ . '/../app/controllers/EmpleadoController.php';
require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/MesaController.php';
require_once __DIR__ . '/../app/controllers/PedidoController.php';


$app = AppFactory::create();

$app->setBasePath('/slim-php-deployment/app');

$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$app->get('/', function (Request $request, Response $response) {
    $payload = json_encode(array('method' => 'GET', 'msg' => "Bienvenido a SlimFramework 2023"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->post('/alta', \EmpleadoController::class . ':CargarEmpleado');
    $group->get('/listar', \EmpleadoController::class . ':MostrarEmpleados');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->post('/alta', \MesaController::class . ':CargarMesa');
    $group->get('/listar', \MesaController::class . ':MostrarMesas');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->post('/alta', \ProductoController::class . ':CargarProducto');
    $group->get('/listar', \ProductoController::class . ':MostrarProductos');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->post('/alta', \PedidoController::class . ':CargarPedido');
    $group->get('/listar', \PedidoController::class . ':MostrarPedidos');
});

$app->run();
