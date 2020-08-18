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
$app->post('/medicos/citas-disponibles', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->obtenerCitasDisponibles());
});

/**
 * Consulta las citas pasadas del paciente por código de médico
 *
 * @return json
 */
$app->post('/medicos/citas-pasadas', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->consultarCitasPacientePasadas());
});

/**
 * Consulta las citas pasadas del paciente por código de médico y nombres del paciente
 *
 * @return json
 */
$app->post('/medicos/citas-pasadas-por-nombres', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->consultarCitasPacientePasadasPorNombres());
});

/**
 * Consulta las citas pendientes del paciente por código de médico
 *
 * @return json
 */
$app->post('/medicos/citas-pendientes', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->consultarCitasPacientePendientes());
});

/**
 * Consulta las citas pendientes del paciente por código de médico y nombres del paciente
 *
 * @return json
 */
$app->post('/medicos/citas-pendientes-por-nombres', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->consultarAgendaPorNombres());
});

/**
 * Consulta los datos del médico
 *
 * @return json
 */
$app->post('/medicos/datos', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->obtenerDatosMedico());
});

/**
 * Crear la agenda del médico
 *
 * @return json
 */
$app->post('/medicos/crear-agenda', function () use ($app) {
    $u = new Model\Medicos;
    return $app->json($u->crearAgenda());
});

/**
 * Consulta la historia clínica del paciente
 *
 * @return json
 */
$app->post('/historias-clinicas/consultar', function () use ($app) {
    $u = new Model\HistoriaClinica;
    return $app->json($u->consultar());
});

/**
 * Probar transacción
 *
 * @return json
 */
$app->post('/historias-clinicas/probar-transaccion', function () use ($app) {
    $u = new Model\PruebaTransaccion;
    return $app->json($u->ejecutar());
});

/**
 * Consulta el listado de las historias clínicas anteriores
 *
 * @return json
 */
$app->post('/historias-clinicas/historias-clinicas-anteriores', function () use ($app) {
    $u = new Model\HistoriaClinica;
    return $app->json($u->consultarHistoriasClinicasAnteriores());
});

/**
 * Crea una historia clínica del paciente
 *
 * @return json
 */
$app->post('/historias-clinicas/crear', function () use ($app) {
    $u = new Model\HistoriaClinica;
    return $app->json($u->crear());
});

/**
 * Obtiene los datos de los Antecedentes Familiares de una admisión anterior
 *
 * @return json
 */
$app->post('/historias-clinicas/antecedentes-familiares-admision-anterior', function () use ($app) {
    $u = new Model\HistoriaClinica;
    return $app->json($u->obtenerAntecedentesFamiliaresAdmisionAnterior());
});

/**
 * Consulta los rangos
 *
 * @return json
 */
$app->post('/diagnosticos/consultar', function () use ($app) {
    $u = new Model\Diagnosticos;
    return $app->json($u->consultar());
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
 * Permite registrar la asistencia a la cita
 *
 * @return json
 */
$app->post('/citas/registrar-asistencia', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->registrarAsistencia());
});

/**
 * Permite consultar las citas pasadas del paciente
 *
 * @return json
 */
$app->post('/citas/citas-pasadas', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->consultarCitasPasadas());
});

/**
 * Permite consultar las citas pendientes del paciente
 *
 * @return json
 */
$app->post('/citas/citas-pendientes', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->consultarCitasPendientes());
});

/**
 * Permite consultar las citas pagadas a un médico
 *
 * @return json
 */
$app->post('/citas/citas-pagadas', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->consultarCitasPagadas());
});

/**
 * Permite realizar el re agendamiento de una cita
 *
 * @return json
 */
$app->post('/citas/re-agendar', function () use ($app) {
    $u = new Model\Citas;
    return $app->json($u->reAgendar());
});

/**
 * Permite registrar el pago de una consulta
 *
 * @return json
 */
$app->post('/pacientes/pago', function () use ($app) {
    $u = new Model\Pacientes;
    return $app->json($u->realizarPagoConsulta());
});

/**
 * Consulta los datos del paciente
 *
 * @return json
 */
$app->post('/pacientes/datos', function () use ($app) {
    $u = new Model\Pacientes;
    return $app->json($u->obtenerDatosPaciente());
});

/**
 * Registrar un paciente en Teleconsulta
 *
 * @return json
 */

$app->post('/pacientes/registrar', function () use ($app) {
    $auth = new Model\Register;
    return $app->json($auth->registrarPacienteTeleconsulta());
});

/**
 * Permite consultar los datos de la pre-factura web
 *
 * @return json
 */
$app->post('/facturas/generar-factura-web', function () use ($app) {
    $u = new Model\Facturas;
    return $app->json($u->generarFacturaWeb());
});

/**
 * Permite eliminar la agenda del médico
 *
 * @return json
 */
/*$app->post('/agendas-medico/eliminar', function () use ($app) {
    $u = new Model\Agendas;
    return $app->json($u->eliminar());
});*/

/**
 * Permite eliminar la agenda del médico por rango de fechas
 *
 * @return json
 */
$app->post('/agendas-medico/eliminar-por-rango-fechas', function () use ($app) {
    $u = new Model\Agendas;
    return $app->json($u->eliminarPorRangoDeFechas());
});

/**
 * Permite consultar las agendas creadas por el médico
 *
 * @return json
 */
$app->post('/agendas-medico/agendas-creadas', function () use ($app) {
    $u = new Model\Agendas;
    return $app->json($u->consultarAgendasCreadas());
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
