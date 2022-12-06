<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './models/AutentificadorJWT.php';
require_once './middlewares/MWparaCORS.php';
require_once './middlewares/MWparaAutentificar.php';

require_once './db/AccesoDatos.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/CriptoController.php';
require_once './controllers/VentaController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Set base path
// $app->setBasePath('/app');
$app->setBasePath('/prog3/Rec_SP/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->post('/verificarUsuario', function (Request $request, Response $response) {
        $datos = $request->getParsedBody();

        if (UsuarioController::VerificarUsuario($datos) ) {
            $newResponse = $response->getBody()->write(json_encode($datos['tipo']));
            $newResponse = $response->withStatus(200);
        } else {
            $newResponse = $response->getBody()->write("Datos de usuario inválidos.");
            $newResponse = $response->withStatus(401);
        }

        return $newResponse;
    });

$app->get('/crearToken', function (Request $request, Response $response) {
        $datos = $request->getParsedBody();

        if (UsuarioController::VerificarUsuario($datos) ) {
            $token= AutentificadorJWT::CrearToken($datos); 
            $payload = json_encode($token);
            $newResponse = $response->getBody()->write($payload);
            $newResponse = $response->withStatus(200);
        } else {
            $newResponse = $response->getBody()->write("Datos de usuario inválidos.");
            $newResponse = $response->withStatus(401);
        }

        return $newResponse;
    })->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS80');

$app->group('/criptos', function (RouteCollectorProxy $group) {

    $group->get('[/]', \CriptoController::class . ':TraerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
    $group->get('/filtro/{clave}', \CriptoController::class . ':TraerFiltro')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
    $group->get('/{id}', \CriptoController::class . ':TraerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
    $group->post('[/]', \CriptoController::class . ':CargarUno');

  })->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS80');

$app->group('/ventas', function (RouteCollectorProxy $group) {

    $group->post('[/]', \VentaController::class . ':CargarUno');
    $group->get('/filtro/{clave}', \VentaController::class . ':TraerFiltro')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  })->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS80');



$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Recuperatorio Segundo Parcial - Laurenzano");
    return $response;

});

$app->run();
