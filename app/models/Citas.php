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
 * Modelo Odbc GEMA -> Citas
 */

class Citas extends Models implements IModels
{
    use DBModel;

    # Variables de clase    
    private $conexion;
    private $codigoHorario;
    private $numeroTurno;
    private $codigoInstitucion;

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

        //Código de horario
        if ($this->codigoHorario == null){
             throw new ModelsException($config['errors']['codigoHorarioObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->codigoHorario)) {
                    throw new ModelsException($config['errors']['codigoHorarioNumerico']['message'],1);
            }
        }

        //Número de turno
        if ($this->numeroTurno == null){
             throw new ModelsException($config['errors']['numeroTurnoObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->numeroTurno)) {
                    throw new ModelsException($config['errors']['numeroTurnoNumerico']['message'], 1);
            }
        }
        
    }

    /**
     * Valida los parámetros de entrada cancelación de cita
     */
    private function validarParametrosCancelacionCita(){
        global $config;

        //Código de horario
        if ($this->codigoHorario == null){
             throw new ModelsException($config['errors']['codigoHorarioObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->codigoHorario)) {
                    throw new ModelsException($config['errors']['codigoHorarioNumerico']['message'], 1);
            }
        }

        //Número de turno
        if ($this->numeroTurno == null){
             throw new ModelsException($config['errors']['numeroTurnoObligatorio']['message'], 1);
        } else {
            //Validaciones de tipo de datos y rangos permitidos
            if (!is_numeric($this->numeroTurno)) {
                    throw new ModelsException($config['errors']['numeroTurnoNumerico']['message'], 1);
            }
        }
        
    }

    /**
     * Consulta el detalle de la cita
     */
    public function obtenerDetalleCita()
    {
        global $config;

        //Inicialización de variables
        $stid = null;
        $pc_datos = null;
        $existeDatos = false;        

        try {         
            //Asignar parámetros de entrada            
            $this->setParameters();

            //Validar parámetros de entrada            
            $this->validarParametros();

            //Conectar a la BDD
            $this->conexion->conectar();

            $pc_datos = oci_new_cursor($this->conexion->getConexion());

            $stid = oci_parse($this->conexion->getConexion(), "BEGIN PRO_TEL_CONFIRMA_CITA(:pn_cod_horario, :pn_num_turno, :pc_datos); END;");
           
            // Bind the input num_entries argument to the $max_entries PHP variable             
            oci_bind_by_name($stid,":pn_cod_horario",$this->codigoHorario,32);
            oci_bind_by_name($stid,":pn_num_turno",$this->numeroTurno,32);
            oci_bind_by_name($stid, ":pc_datos", $pc_datos, -1, OCI_B_CURSOR);
           
            //Ejecuta el SP
            oci_execute($stid);

            //Ejecutar el REF CURSOR como un ide de sentencia normal
            oci_execute($pc_datos);  

            //Resultados de la consulta
            $citasDisponibles = array();

            while (($row = oci_fetch_array($pc_datos, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                $existeDatos = true;

                # RESULTADO OBJETO
                return array(
                    'status' => true,
                    'data'   => array(
                        'nombresMedico' => $row['NOMBRE_MEDICO'],
                        'especialidadMedico' => $row['DESC_ESPECIALIDAD'],
                        'fechaCita' => $row['FECHA_CITA'],
                        'horaCita' => $row['HORA_CITA'],
                        'codigoOrganigrama' => $row['COD_ORGANIGRAMA'],
                        'descripcionOrganigrama' => $row['DESC_ORGANIGRAMA'],
                        'direccionOrganigrama' => $row['DIRECCION'],
                        'codigoConsulta' => $row['COD_CONSULTA'],
                        'valorConsulta' => $row['VALOR_CONSULTA']
                        )
                );

                //print("Parámetro: " . $row['PARAMETRO']);
            }

            //Verificar si la consulta devolvió datos
            if (!$existeDatos) {

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
     * Permite cancelar (eliminar) una cita
     */
    public function cancelar()
    {
        global $config;

        //Inicialización de variables
        $stmt = null;
        $codigoRetorno = null;
        $mensajeRetorno = null;

        //Siempre es 1 para el Hospital Metropolitano
        $this->codigoInstitucion  = 1;

        try {

            //Asignar parámetros de entrada            
            $this->setParameters();

            //Validar parámetros de entrada            
            $this->validarParametrosCancelacionCita();

            //Conectar a la BDD
            $this->conexion->conectar();
             
            $stmt = oci_parse($this->conexion->getConexion(),'BEGIN PRO_TEL_CANCELA_CITA(:pn_institucion, :pn_cod_horario, :pn_num_turno, :pn_retorno, :pc_mensaje); END;');

            // Bind the input parameter
            oci_bind_by_name($stmt,':pn_institucion',$this->codigoInstitucion,32);
            oci_bind_by_name($stmt,':pn_cod_horario',$this->codigoHorario,32);
            oci_bind_by_name($stmt,':pn_num_turno',$this->numeroTurno,32);
             
            // Bind the output parameter
            oci_bind_by_name($stmt,':pn_retorno',$codigoRetorno,32);
            oci_bind_by_name($stmt,':pc_mensaje',$mensajeRetorno,500);
                         
            oci_execute($stmt);
            
            //Valida el código de retorno del SP
            if($codigoRetorno == 0){
                //Cita cancelada exitosamente               
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
                    'errorCode' => $ex->getCode()
                );

        }
        finally {
            //Libera recursos de conexión
            if ($stmt != null){
                oci_free_statement($stmt);
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