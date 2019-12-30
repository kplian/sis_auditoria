<?php
/**
*@package pXP
*@file gen-MODAuditoriaProceso.php
*@author  (max.camacho)
*@date 25-07-2019 15:51:56
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAuditoriaProceso extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAuditoriaProceso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_auditoria_proceso_sel';
		$this->transaccion='SSOM_AUPC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_aproceso','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_aom','int4');
		$this->captura('id_proceso','int4');
		$this->captura('ap_valoracion','varchar');
		$this->captura('obs_pcs','text');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_aom1','varchar');
		$this->captura('proceso','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
    /*function esSelectaProceso(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_proceso_sel';
        $this->transaccion='SSOM_AUPC_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('p_id_aom','p_id_aom','int4');
        $this->setParametro('p_id_proceso','p_id_proceso','int4');

        //Definicion de la lista del resultado del query
        $this->captura('id_aproceso','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('id_aom','int4');
        $this->captura('id_proceso','int4');
        $this->captura('ap_valoracion','varchar');
        $this->captura('obs_pcs','text');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('id_usuario_ai','int4');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('proceso','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }*/
	function insertarAuditoriaProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_proceso_ime';
		$this->transaccion='SSOM_AUPC_INS';
		$this->tipo_procedimiento='IME';

        /*$this->setParametro('p_id_aom','p_id_aom','int4');
        $this->setParametro('p_id_proceso','p_id_proceso','int4');*/
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_proceso','id_proceso','int4');
		$this->setParametro('ap_valoracion','ap_valoracion','varchar');
		$this->setParametro('obs_pcs','obs_pcs','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAuditoriaProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_proceso_ime';
		$this->transaccion='SSOM_AUPC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aproceso','id_aproceso','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_proceso','id_proceso','int4');
		$this->setParametro('ap_valoracion','ap_valoracion','varchar');
		$this->setParametro('obs_pcs','obs_pcs','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAuditoriaProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_proceso_ime';
		$this->transaccion='SSOM_AUPC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aproceso','id_aproceso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>