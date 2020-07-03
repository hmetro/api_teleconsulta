<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use app\models as Model;

/**
 * Turnos disponibles
 *
 * @return json
 */
$app->post('/medicos/citasDisponibles', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->obtenerCitasDisponibles());
});

/**
 * Consulta el detalle de una cita
 *
 * @return json
 */
$app->post('/citas/detalle', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->obtenerDetalleCita());
});

/**
 * Permite cancelar (eliminar) una cita
 *
 * @return json
 */
$app->post('/citas/cancelar', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->cancelar());
});

/**
 * Auntenticar api
 *
 * @return json
$app->post('/auth', function () use ($app) {
$auth = new Model\Users;
return $app->json($auth->track_request_Api());
});

 */

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

$app->post('/auth', function () use ($app) {
    global $http;

    $auth = new Model\Login;
    return $app->json($auth->auth_Api());
});

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

$app->post('/generate', function () use ($app) {
    $auth = new Model\Regenerate;
    return $app->json($auth->generateUser_Token());
});

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

$app->post('/login', function () use ($app) {
    $auth = new Model\Login;
    return $app->json($auth->login_Api());
});

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

/*$app->post('/register', function () use ($app) {
    $auth = new Model\Register;
    return $app->json($auth->register_Api());
});*/

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

/*$app->post('/lostpass', function () use ($app) {
    $auth = new Model\Register;
    return $app->json($auth->lostpass_Api());
});*/

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

/*$app->post('/changepass', function () use ($app) {
    $auth = new Model\Register;
    return $app->json($auth->changepass_Api());
});*/

/**
 * Changed Pass
 *
 * @return json
 */

$app->post('/auth/verify/{token}', function ($token) use ($app) {
    $u = new Model\Users;
    return $app->json($u->verify_TOKEN($token));
});

/**
 * Facturas del Paciente -> Usuario
 *
 * @return json
 */

/*$app->post('/paciente/facturas', function () use ($app) {
    $u = new Model\Facturas;
    return $app->json($u->getFacturas());
});*/

/**
 * DEVUELVE HISTORIAL DE ATENCIONES DEL PACIENTE
 *
 * @return json
 */

/*$app->post('/paciente/historial', function () use ($app) {
    $u = new Model\Pacientes;
    return $app->json($u->getHistorialPaciente());
});*/

/**
 * DEVOLVER LOS RESULTADOS DE LABORATORIO DLE PACIENTE
 *
 * @return json
 */

/*$app->post('/resultados/lab', function () use ($app) {
    $u = new Model\Laboratorio;
    return $app->json($u->getResultadosLab());
});*/

/**
 * DEVOLVER LOS MEDICOS DE NUESTRA BDD
 *
 * @return json
 */
/*app->post('/medicos', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->getDirectorioMedicos_Rand());
});*/

/**
 * DEVOLVER LOS MEDICOS DE NUESTRA BDD
 *
 * @return json
 */

/*$app->post('/medicos/test', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->getDirectorioMedicos());
});*/

/**
 * DEVOLVER LOS MEDICOS DE NUESTRA BDD
 *
 * @return json
 */

/*$app->post('/sintomas', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->getSintomasDirectorio());
});*/

/**
 * DEVOLVER LOS PACIENTES A BORDO DEL MEDICO
 *
 * @return json
 */

/*$app->post('/medicos/pacientes', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->getPacientes_Medico());
});*/

/**
 * DEVOLVER LOS PACIENTES HISTORICO DEL MEDICO
 *
 * @return json
 */

/*$app->post('/medicos/historial/pacientes', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->getPacientes_Medico_Historico());
});*/

/**
 * DEVOLVER EL PORTAFOLIO DE PRODUCTOS
 *
 * @return json
 */

/*$app->post('/portafolio', function () use ($app) {
    $u = new Model\Pagos;
    return $app->json($u->getPortafolioWeb());
});*/

/**
 * Proceso PAGOS WEB
 *
 * @return json
 */

/*$app->post('/mis-pagos', function () use ($app) {
    $u = new Model\Orders;
    return $app->json($u->getAbonos_Procesados());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/ordenes/nueva', function () use ($app) {
    $u = new Model\Orders;
    return $app->json($u->getPaciente_New_Pedido());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/ordenes/{type}', function ($type) use ($app) {

    sleep(1.5);

    $u = new Model\Orders;
    switch ($type) {
        case 'lab':
            return $app->json($u->registroPedidoElectronicoWeb_LAB());
            break;
        case 'med':
            return $app->json($u->registroPedidoElectronicoWeb_MED());
            break;
        case 'imagen':
            return $app->json($u->registroPedidoElectronicoWeb_IMAGEN());
            break;
        default:
            return $app->json(array('message' => 'No existe un proceso definido'));
            break;
    }

});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/ordenes', function () use ($app) {
    $u = new Model\Orders;
    return $app->json($u->getPedidos_Medicos_Paciente());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/ordenes/detalle', function () use ($app) {
    $u = new Model\Orders;
    return $app->json($u->getDetalle_Pedidos());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/medico/ordenes', function () use ($app) {
    $u = new Model\Orders;
    return $app->json($u->getPedidos_Medicos());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/proveedores/facturas', function () use ($app) {
    $u = new Model\Proveedores;
    return $app->json($u->getFacturas());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/proveedores/pagos', function () use ($app) {
    $u = new Model\Proveedores;
    return $app->json($u->getPagos());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/proveedores/credito', function () use ($app) {
    $u = new Model\Proveedores;
    return $app->json($u->getNotas_Credito());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/proveedores/retenciones', function () use ($app) {
    $u = new Model\Proveedores;
    return $app->json($u->getRetenciones());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/renombrar', function () use ($app) {
    $u = new Model\Proveedores;
    return $app->json($u->setRename());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/especialidades', function () use ($app) {
    $u = new Model\Especialidades;
    return $app->json($u->getEspecialidades());
});*/

/**
 * PROCESO REGISTRO DE PEDIDOS ELECTRÓNICOS
 *
 * @return json
 */

/*$app->post('/forms', function () use ($app) {
    $u = new Model\Forms;
    return $app->json($u->postData());
});*/

/**
 * PROCESOENVIO DE SMSM AUTOMATICAMENTE PAR LA ACAMPAÑA DE CITAS D EIMAGEN
 *
 * @return json
 */

/*$app->post('/sms/citas-imagen-cc', function () use ($app) {
    $u = new Model\SMSEmpresarial;
    return $app->json($u->enviarsms());
});*/
