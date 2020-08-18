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

$app->get('/', function () use ($app) {

    global $http, $config;

    $data = array(
        array(
            'PROVIDER'    => 'Hospital Metropolitano EC',
            'VERSION'     => '1.0.0',
            'DEPARTAMENT' => 'SISTEMAS HM',
            'DEVELOPER'   => 'Martin Chang Chávez',
            'SUPPORT'     => 'mchang@hmetro.med.ec',
            'LIVE'        => '27-03-2019',
            'PRODUCTION'  => $config['build']['production'],
            'API URL'     => $http->getUri(),
        ),
    );

    return $app->json($data);

});

/*$app->get('/auth/verify/{token}', function ($token) use ($app) {
    $u = new Model\Users;
    return $app->json($u->verify_TOKEN($token));
});*/

/**
 * Obtiene los datos del usuario conectado
 *
 * @return json
 */

/*$app->get('/account', function () use ($app) {
    $u = new Model\Account;
    return $app->json($u->getAccount());
});*/

/**
 * DOCUMENTO PDF AND XML FACTURA del Paciente -> Usuario
 *
 * @return json
 */

/*$app->get('/factura/{tipo}/{doc}', function ($tipo, $doc) use ($app) {
    $u = new Model\Ebilling;
    return $app->json($u->getFactura($tipo, $doc));
});*/

/**
 * DOCUMENTO PDF AND XML FACTURA del Paciente -> Usuario
 *
 * @return json
 */

/*$app->get('/resultado/lab/{sc}/{fecha}', function ($sc, $fecha) use ($app) {
    $u = new Model\Laboratorio;
    return $app->json($u->wsLab_GET_REPORT_PDF($sc, $fecha));
});*/
