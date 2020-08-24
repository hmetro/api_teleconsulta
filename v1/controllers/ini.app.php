<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 * @author Brayan Narváez <prinick@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use app\models as Model;
use Ocrend\Kernel\Models\ModelsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Convertir esta api en RESTFULL para recibir JSON
 */
$app->before(function () use ($app) {
    try {
        global $config, $http;

        # Verificar si la api no está activa
        if (!$config['api']['active']) {
            throw new ModelsException('Servicio inactivo', 4070);
        }

        if ($http->getMethod() == 'OPTIONS') {
            throw new ModelsException('OPTIONS', 4090);
        }

        # Verificar si es peticion Auth o Index
        if ($http->getPathInfo() != '/') {
            # Peticion index
            if (//explode('/', $http->getPathInfo())[1] != 'medicos' and                 
                //explode('/', $http->getPathInfo())[1] != 'historias-clinicas' and
                //and explode('/', $http->getPathInfo())[1] != 'diagnosticos' and
                //and explode('/', $http->getPathInfo())[1] != 'citas' and
                //and explode('/', $http->getPathInfo())[1] != 'pacientes' and 
                //and explode('/', $http->getPathInfo())[1] != 'facturas' and
                //and explode('/', $http->getPathInfo())[1] != 'agendas-medico' and
                explode('/', $http->getPathInfo())[1] != 'login' 
                and explode('/', $http->getPathInfo())[1] != 'register'
                /*and explode('/', $http->getPathInfo())[1] != 'auth'
                and explode('/', $http->getPathInfo())[1] != 'verify'
                and explode('/', $http->getPathInfo())[1] != 'generate'
                and explode('/', $http->getPathInfo())[1] != 'login'
                and explode('/', $http->getPathInfo())[1] != 'register'
                and explode('/', $http->getPathInfo())[1] != 'lostpass'
                and explode('/', $http->getPathInfo())[1] != 'changepass'
                and explode('/', $http->getPathInfo())[1] != 'especialidades'
                and explode('/', $http->getPathInfo())[1] != 'pagos'                
                and explode('/', $http->getPathInfo())[1] != 'sintomas'
                and explode('/', $http->getPathInfo())[1] != 'portafolio'
                and explode('/', $http->getPathInfo())[1] != 'forms'
                and explode('/', $http->getPathInfo())[1] != 'sms'*/                
            ) {

                # Verificar SI EXISTE TOKEN Y SI ES VALIDO
                $u     = new Model\Auth;
                $error = $u->Check($http->headers->get("Authorization"));
                if (!is_bool($error)) {
                    throw new ModelsException($error['message'], $error['errorCode']);
                }

            }

        }

        # Recibir JSON
        if (0 === strpos($http->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($http->getContent(), true);
            $http->request->replace(is_array($data) ? $data : array());
        }

    } catch (ModelsException $e) {
        if ($e->getMessage() == 'OPTIONS') {
            return new Response('', 200);
        } else {

            # Capturar error de token caducado
            if ($e->getCode() == 4031) {

                return $app->json(array(
                    'status'    => false,
                    'message'   => $e->getMessage(),
                    'errorCode' => $e->getCode(),
                    # 'data'    => explode('/', $http->getPathInfo())[2],
                ), 401);

            } else {

                return $app->json(array(
                    'status'    => false,
                    'message'   => $e->getMessage(),
                    'errorCode' => $e->getCode(),
                    # 'data'    => explode('/', $http->getPathInfo())[2],
                ));

            }

        }

    }
});

/**
 * Servidores autorizados para consumir la api.
 */
$app->after(function (Request $request, Response $response) {

    global $http, $config;

    # Setear respuesta para responses 500
    $getPathInfo = explode('/', $http->getPathInfo())[1];

    if ($getPathInfo === 'auth' or $getPathInfo === 'login' or $getPathInfo === 'register') {
        $response->setStatusCode(200);
    }

    #$response->headers->set('Access-Control-Allow-Origin', $config['api']['origin']);
    #$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    #$response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

});

$app->options("{anything}", function () {
    return new \Symfony\Component\HttpFoundation\JsonResponse(null, 204);
})->assert("anything", ".*");

$app->error(function (\Exception $e, $code) use ($app) {
    # Capturar errores de la api
    return $app->json(array(
        'status'    => false,
        'message'   => $e->getMessage(),
        'errorCode' => $e->getCode(),
    ));
});

# solo enviar token no url para activar cuenta : listo
# total en obj:data : listo
# key unico para generar mas tokens : listo
# eliminar message manjear codes de error : listo end poitn auth
