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
/*$app->post('/historias-clinicas/probar-transaccion', function () use ($app) {
    $u = new Model\PruebaTransaccion;
    return $app->json($u->ejecutar());
});*/

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
 * Obtiene la url del Reporte MSP002
 *
 * @return json
 */
$app->post('/historias-clinicas/reporte-002', function () use ($app) {
    $u = new Model\HistoriaClinica;
    return $app->json($u->obtenerEnlaceReporteMSP002());
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

$app->post('/register', function () use ($app) {
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
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

/*    global $http;

    $auth = new Model\Login;
    return $app->json($auth->auth_Api());
});*/

/**
 * Auntenticar api del hospital modelo LOGIN function auth_Api
 *
 * @return json
 */

/*$app->post('/generate', function () use ($app) {
    $auth = new Model\Regenerate;
    return $app->json($auth->generateUser_Token());
});*/

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
 * Verify token
 *
 * @return json
 */

/*$app->post('/auth/verify/{token}', function ($token) use ($app) {
    $u = new Model\Users;
    return $app->json($u->verify_TOKEN($token));
});*/