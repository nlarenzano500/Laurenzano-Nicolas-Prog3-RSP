<?php
use Slim\Psr7\Response;
require_once "./models/AutentificadorJWT.php";
require_once "./controllers/UsuarioController.php";

class MWparaAutentificar {

	public function VerificarUsuario($request, $handler) {
         
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta = "";

		$method = $request->getMethod();

		if($method == "GET") {
			$response = $handler->handle($request);

		} else {
			$objDelaRespuesta->esValido = false;
			$token = "";
			
			try  {
				$token = AutentificadorJWT::ObtenerToken($request);
				AutentificadorJWT::verificarToken($token);

				$payload=AutentificadorJWT::ObtenerData($token);
				if (UsuarioController::VerificarUsuario(array("usuario"=>$payload->usuario, "tipo"=>$payload->tipo, "clave"=>$payload->clave)) )
					$objDelaRespuesta->esValido=true;
				else
					$objDelaRespuesta->respuesta="Datos de usuario inválidos.";

			} catch (Exception $e) {
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}

			if($objDelaRespuesta->esValido) {
				// "POST", "PUT" y "DELETE" solo sirven para los admin

				if($payload->tipo=="admin") {
					$response = $handler->handle($request);
					$response->withStatus(200);

				} else {
					$objDelaRespuesta->respuesta="Solo administradores";
				}

			} else {
				$objDelaRespuesta->respuesta="Solo usuarios registrados";
				$objDelaRespuesta->elToken=$token;

			}  
		}

		if($objDelaRespuesta->respuesta != "") {
			$payload = json_encode($objDelaRespuesta);
			$newResponse = new Response();
			$newResponse->getBody()->write($payload);
      		$newResponse->withStatus(401);
			return $newResponse;
		}
		  
		return $response;   
	}
}