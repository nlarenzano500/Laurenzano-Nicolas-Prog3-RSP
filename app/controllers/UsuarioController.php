<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController implements IApiUsable {

    public static function VerificarUsuario($datos) {
        // Buscamos usuario
        $usr = $datos['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        
        if ($usuario->tipo == $datos['tipo'] && password_verify($datos['clave'], $usuario->clave) )
            return true;
        else
            return false;
    }

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $tipo = $parametros['tipo'];
        $nombre = $parametros['nombre'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->tipo = $tipo;
        $usr->nombre = $nombre;
        $usr->crearUsuario();

        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function TraerFiltro($request, $response, $args) {}

    public function ModificarUno($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        $idUsuario = $parametros['id_usuario'];
        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $tipo = $parametros['tipo'];
        $nombre = $parametros['nombre'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->tipo = $tipo;
        $usr->nombre = $nombre;

        $usr->modificarUsuario($idUsuario);

        $payload = json_encode(array("mensaje" => "Usuario modificado con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $idUsuario = $parametros['id_usuario'];
        Usuario::borrarUsuario($idUsuario);

        $payload = json_encode(array("mensaje" => "Usuario borrado con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
