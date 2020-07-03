<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\models as Model;
use DateTime;
use Doctrine\DBAL\DriverManager;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Models\IModels;
use Ocrend\Kernel\Models\Models;
use Ocrend\Kernel\Models\ModelsException;
use Ocrend\Kernel\Models\Traits\DBModel;
use Ocrend\Kernel\Router\IRouter;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use Exception;

/**
 * Modelo Odbc GEMA -> Medicos
 */

class Medicos extends Models implements IModels
{
    use DBModel;

    # Variables de clase    
    private $conexion;

    private $start  = 0;
    private $length  = 10;
    private $startDate      = null;
    private $endDate        = null;
    private $codigoMedico   = null;
    private $tipoHorario    = 1;

    /**
     * Asigna los parámetros de entrada
     */
    private function setParameters()
    {
        global $http;

        foreach ($http->request->all() as $key => $value) {
            $this->$key = strtoupper($value);
        }

    }

    /**
     * Valida los parámetros de entrada
     */
    private function validarParametros(){
        global $config;

        //Código del médico
        if ($this->codigoMedico == null){
             throw new ModelsException($config['errors']['codigoMedicoObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->codigoMedico)) {
                    throw new ModelsException($config['errors']['codigoMedicoNumerico']['message'], 1);
            }
        }

        //Fecha de inicio
        if ($this->startDate == null){
             throw new ModelsException($config['errors']['startDateObligatorio']['message'], 1);
        } else {
            if ($this->endDate != null) {

                $startDate = $this->startDate;
                $endDate   = $this->endDate;

                $sd = new DateTime($startDate);
                $ed = new DateTime($endDate);

                if ($sd->getTimestamp() > $ed->getTimestamp()) {
                    throw new ModelsException($config['errors']['startDateIncorrecta']['message'], 1);
                }
            }
        }

        //Fecha final
        if ($this->endDate == null){
             throw new ModelsException($config['errors']['endDateObligatorio']['message'], 1);
        }

        //Max row to fetch
        if ($this->length == null){
             throw new ModelsException($config['errors']['lengthObligatorio']['message'], 1);
        } else {
            if ($this->length <= 0) {
                 throw new ModelsException($config['errors']['lengthIncorrecto']['message'], 1);
            }
        }

        //Min row to fetch
        if ($this->start == null){
             throw new ModelsException($config['errors']['startObligatorio']['message'], 1);
        } else {
            if ($this->start < 0) {
                throw new ModelsException($config['errors']['startIncorrecto']['message'], 1);
            }
        }
    }

    public function obtenerCitasDisponibles()
    {
        global $config;

        //Inicialización de variables
        $stid = null;
        $pc_datos = null;
        $existeDatos = false;
        $citasDisponibles[] = null;

        try {         
            //Asignar parámetros de entrada            
            $this->setParameters();

            //Validar parámetros de entrada            
            $this->validarParametros();

            //Conectar a la BDD
            $this->conexion->conectar();

            $pc_datos = oci_new_cursor($this->conexion->getConexion());

            $stid = oci_parse($this->conexion->getConexion(), "BEGIN PRO_TEL_AGENDAS_DISP(:pc_cod_medico, :pc_tip_horario, :pc_fec_ini, :pc_fec_fin,:pn_num_reg, :pn_num_pag, :pc_datos); END;");
           
            // Bind the input num_entries argument to the $max_entries PHP variable             
            oci_bind_by_name($stid,":pc_cod_medico",$this->codigoMedico,32);
            oci_bind_by_name($stid,":pc_tip_horario",$this->tipoHorario,32);
            oci_bind_by_name($stid,":pc_fec_ini",$this->startDate,32);
            oci_bind_by_name($stid,":pc_fec_fin",$this->endDate,32);
            oci_bind_by_name($stid,":pn_num_reg",$this->limit,32);
            oci_bind_by_name($stid,":pn_num_pag",$this->offset,32);
            oci_bind_by_name($stid, ":pc_datos", $pc_datos, -1, OCI_B_CURSOR);
           
            //Ejecuta el SP
            oci_execute($stid);

            //Ejecutar el REF CURSOR como un ide de sentencia normal
            oci_execute($pc_datos);  

            //Resultados de la consulta
            $citasDisponibles = array();

            while (($row = oci_fetch_array($pc_datos, OCI_BOTH)) != false) {
                $existeDatos = true;

                # RESULTADO OBJETO
                $citasDisponibles[] = array(
                    'codigoHorario' => $row[0],
                    'numeroTurno'=> $row[1],
                    'fecha' => $row[2],
                    'hora' => $row[3]
                );
                
            }

            //Verificar si la consulta devolvió datos
            if ($existeDatos) {
                return array(
                    'status' => true,                    
                    'data'   => $citasDisponibles
                        );
            }
            else {
                throw new ModelsException($config['errors']['noExistenResultados']['message'], 1);
            }

            

        } catch (ModelsException $e) {

            return array(
                    'status'    => false,
                    'data'      => [],
                    'message'   => $e->getMessage(),
                    'errorCode' => $e->getCode()
                );

        } catch (Exception $ex) {

            return array(
                    'status'    => false,
                    'data'      => [],
                    'message'   => $ex->getMessage(),
                    'errorCode' => -1
                );

        }
        finally {
            //Libera recursos de conexión
            if ($stid != null){
                oci_free_statement($stid);
            }

            if ($pc_datos != null){
                oci_free_statement($pc_datos);
            }

            //Cierra la conexión
            $this->conexion->cerrar();
        }
    }

    /**
     * __construct()
     */
    public function __construct(IRouter $router = null)
    {
        parent::__construct($router);

        //Instancia la clase conexión a la base de datos
        $this->conexion = new Conexion();

    }
}
