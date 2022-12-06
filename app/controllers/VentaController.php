<?php
require_once './models/Venta.php';
require_once './interfaces/IApiUsable.php';

class VentaController implements IApiUsable {

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();

        $nombreCripto = $parametros['nombreCripto'];
        $usuario = $parametros['usuario'];
        $cantidad = $parametros['cantidad'];
        $precio = $parametros['precio'];

        // Creamos la instancia
        $elemento = new Venta();
        $elemento->nombreCripto = $nombreCripto;
        $elemento->usuario = $usuario;
        $elemento->cantidad = $cantidad;
        $elemento->precio = $precio;

        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $elemento->fecha = date('Y-m-d');
        $elemento->crear();

        $payload = json_encode(array("mensaje" => "Alta exitosa"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Venta::obtenerTodos();
        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerFiltro($request, $response, $args) {
        $clave = $args['clave'];

        if ($clave == 'nacionalidad') {
            $parametros = $request->getQueryParams();

            $nacionalidad = $parametros['nacionalidad'];
            $inicio = $parametros['inicio'];
            $fin = $parametros['fin'];
            $lista = Venta::obtenerTodosNacionalidad($nacionalidad, $inicio, $fin);
        }
            


        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args) {
        // Buscamos elemento por id
        $id = $args['id'];
        $elemento = Venta::obtenerUno($id);
        $payload = json_encode($elemento);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    







    
    public function ModificarUno($request, $response, $args)
    {
    }

    public function BorrarUno($request, $response, $args)
    {
    }
}
