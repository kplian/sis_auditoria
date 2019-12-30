<?php
/**
*@package pXP
*@file gen-MODParametroConfigAuditoria.php
*@author  (max.camacho)
*@date 20-08-2019 16:16:47
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODParametroConfigAuditoria extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarParametroConfigAuditoria(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_parametro_config_auditoria_sel';
		$this->transaccion='SSOM_PCAOM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_param_config_aom','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('param_gestion','int4');
		$this->captura('param_fecha_a','date');
		$this->captura('param_fecha_b','date');
		$this->captura('param_prefijo','varchar');
		$this->captura('param_serie','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarParametroConfigAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_config_auditoria_ime';
		$this->transaccion='SSOM_PCAOM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('param_gestion','param_gestion','int4');
		$this->setParametro('param_fecha_a','param_fecha_a','date');
		$this->setParametro('param_fecha_b','param_fecha_b','date');
		$this->setParametro('param_prefijo','param_prefijo','varchar');
		$this->setParametro('param_serie','param_serie','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarParametroConfigAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_config_auditoria_ime';
		$this->transaccion='SSOM_PCAOM_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_param_config_aom','id_param_config_aom','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('param_gestion','param_gestion','int4');
		$this->setParametro('param_fecha_a','param_fecha_a','date');
		$this->setParametro('param_fecha_b','param_fecha_b','date');
        $this->setParametro('param_prefijo','param_prefijo','varchar');
		$this->setParametro('param_serie','param_serie','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarParametroConfigAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_config_auditoria_ime';
		$this->transaccion='SSOM_PCAOM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_param_config_aom','id_param_config_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>