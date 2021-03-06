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

$app->post('/metrored/paciente/respuesta', function () use ($app) {
    $u = new Model\Metrored;
    return $app->json($u->setRespuesta());
});
