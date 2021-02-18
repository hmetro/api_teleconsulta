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
 * Modelo Odbc GEMA -> Exámenes
 */

class Admisiones extends Models implements IModels
{
    use DBModel;

    # Variables de clase    
    private $conexion;
    private $numeroCompania = '01';
    private $codigoInstitucion = 1;
    private $numeroHistoriaClinica;
    private $numeroAdmision;        
    private $tamanioCodigoExamen = 9;
    private $tamanioDescripcionExamen = 120;
    private $entidadPedido = null;
    private $tipoPedido = '';

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

        //Número de historia clínica
        if ($this->numeroHistoriaClinica == null){
             throw new ModelsException($config['errors']['numeroHistoriaClinicaObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->numeroHistoriaClinica)) {
                    throw new ModelsException($config['errors']['numeroHistoriaClinicaNumerico']['message'], 1);
            }
        }
        
        //Número de admisión
        if ($this->numeroAdmision == null){
             throw new ModelsException($config['errors']['numeroAdmisionObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->numeroAdmision)) {
                    throw new ModelsException($config['errors']['numeroAdmisionNumerico']['message'], 1);
            }
        }   

        //Anulado
        if ($this->anulado == null){
             throw new ModelsException($config['errors']['anuladoObligatorio']['message'], 1);
        }     
    }

     /**
     * Elimianr la agenda del médico
    */
    public function darAltaTelemedicina()
    {
        global $config;
        $codigoRetorno = -1;
        $mensajeRetorno = null;

        //Inicialización de variables
        $stid = null;        
       
        try {         
            //Asignar parámetros de entrada            
            $this->setParameters();

            //Validar parámetros de entrada   
            $this->validarParametros();
            
            //Conectar a la BDD
            $this->conexion->conectar();

            //Setear idioma y formatos en español para Oracle
            $this->setSpanishOracle($stid);

            $stid = oci_parse($this->conexion->getConexion(), "BEGIN PRO_REGISTRA_ALTA_TELEMEDICINA(:pn_hcl, :pn_adm, :pc_anulado, :pc_observacion, :pn_error, :pc_msg_error); END;");

            // Bind the input num_entries argument to the $max_entries PHP variable             
            oci_bind_by_name($stid, ":pn_hcl", $this->numeroHistoriaClinica, 32);
            oci_bind_by_name($stid, ":pn_adm", $this->numeroAdmision, 32);
            oci_bind_by_name($stid, ":pc_anulado", $this->anulado, 1);
            oci_bind_by_name($stid, ":pc_observacion", $this->observacion, 90);

            oci_bind_by_name($stid, ":pn_error", $codigoRetorno, 32);
            oci_bind_by_name($stid, ":pc_msg_error", $mensajeRetorno, 500);
           
            //Ejecuta el SP
            oci_execute($stid);

           //Valida el código de retorno del SP
            if($codigoRetorno == 0){
                //Agend elimnada exitosamente               
                return array(
                        'status' => true,
                        'data'   => [],
                        'message'   => $mensajeRetorno
                    );
            } elseif ($codigoRetorno == 1) {
                //Mensajes de aplicación
                throw new ModelsException($mensajeRetorno, $codigoRetorno);
            } else {
                //Mensajes de errores técnicos
                throw new Exception($mensajeRetorno, $codigoRetorno);
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
            
            //Cierra la conexión
            $this->conexion->cerrar();
        }
    }
    

    private function setSpanishOracle($stid)
    {

        $sql = "alter session set NLS_LANGUAGE = 'SPANISH'";
        # Execute
        $stid = oci_parse($this->conexion->getConexion(),  $sql);
        oci_execute($stid);

        $sql = "alter session set NLS_TERRITORY = 'SPAIN'";
        # Execute
        $stid = oci_parse($this->conexion->getConexion(),  $sql);
        oci_execute($stid);

        $sql = " alter session set NLS_DATE_FORMAT = 'DD/MM/YYYY HH24:MI'";
        # Execute
        $stid = oci_parse($this->conexion->getConexion(),  $sql);
        oci_execute($stid);

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