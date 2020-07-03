<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use app\models\hm\tasks as Model;

# Tarea para extracción de las citas agendadas y paso a tabla temporal para el posterior envio de sms
# a los clientes

$app->get('/citas-imagen-cc', function () use ($app) {
    $u = new Model\SMSToImagen;
    return $app->json($u->getCitasImagenCC());
});

$app->get('/send-sms-imagen-cc', function () use ($app) {
    $u = new Model\SMSToImagen;
    return $app->json($u->sendSMSToImagen());
});

/**
 * PROCESOENVIO DE CARGA AUTOMATICA USUARIOS WEB PACIENTES QUE SALIERON DE ADMISION DOS HORAS
 * @return json
 */

$app->get('/usuarios-temp-camp-nueva-web', function () use ($app) {
    $u = new Model\EmailToWeb;
    return $app->json($u->getPtesUsrsWebHM());
});

/**
 * PROCESOENVIO DE CARGA AUTOMATICA USUARIOS WEB PACIENTES QUE SALIERON DE ADMISION DOS HORAS
 * @return json
 */

$app->get('/email/send-template-nuevos-usuarios-web', function () use ($app) {
    $u = new Model\EmailToWeb;
    return $app->json($u->sendTemplateCampNuevosUsuariosHM());
});
