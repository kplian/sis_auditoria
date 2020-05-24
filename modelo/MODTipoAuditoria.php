<?php
/**
*@package pXP
*@file gen-MODTipoAuditoria.php
*@author  (max.camacho)
*@date 17-07-2019 13:23:26
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTipoAuditoria extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTipoAuditoria(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_tipo_auditoria_sel';
		$this->transaccion='SSOM_TAU_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tipo_auditoria','int4');
		$this->captura('descrip_tauditoria','text');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo_auditoria','varchar');
		$this->captura('codigo_tpo_aom','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
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
			
	function insertarTipoAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_auditoria_ime';
		$this->transaccion='SSOM_TAU_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('descrip_tauditoria','descrip_tauditoria','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_auditoria','tipo_auditoria','varchar');
		$this->setParametro('codigo_tpo_aom','codigo_tpo_aom','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTipoAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_auditoria_ime';
		$this->transaccion='SSOM_TAU_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');
		$this->setParametro('descrip_tauditoria','descrip_tauditoria','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_auditoria','tipo_auditoria','varchar');
		$this->setParametro('codigo_tpo_aom','codigo_tpo_aom','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTipoAuditoria(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_auditoria_ime';
		$this->transaccion='SSOM_TAU_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
}
?>