<?php
require_once './models/Cripto.php';
require_once './interfaces/IApiUsable.php';

class CriptoController implements IApiUsable {

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();

        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $nacionalidad = $parametros['nacionalidad'];

        // Creamos la instancia
        $elemento = new Cripto();
        $elemento->precio = $precio;
        $elemento->nombre = $nombre;
        $elemento->nacionalidad = $nacionalidad;
        $elemento->crear();

        $payload = json_encode(array("mensaje" => "Alta exitosa"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Cripto::obtenerTodos();
        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerFiltro($request, $response, $args) {
        $clave = $args['clave'];
        $lista = Cripto::obtenerTodosFiltro($clave);
        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args) {
        // Buscamos elemento por id
        $id = $args['id'];
        $elemento = Cripto::obtenerUno($id);
        $payload = json_encode($elemento);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args) {}
    public function BorrarUno($request, $response, $args) {}
    


}
