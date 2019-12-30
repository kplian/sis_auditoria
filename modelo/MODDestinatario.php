<?php
/**
*@package pXP
*@file gen-MODDestinatario.php
*@author  (max.camacho)
*@date 10-09-2019 23:09:14
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDestinatario extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarDestinatario(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_destinatario_sel';
		$this->transaccion='SSOM_DEST_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_destinatario_aom','int4');
		$this->captura('id_parametro','int4');
		$this->captura('id_aom','int4');
        $this->captura('id_funcionario','int4');
        $this->captura('exp_tec_externo','varchar');
        $this->captura('obs_destinatario','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('valor_parametro','varchar');
		$this->captura('codigo_parametro','varchar');
		$this->captura('desc_funcionario1','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDestinatario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_destinatario_ime';
		$this->transaccion='SSOM_DEST_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('id_aom','id_aom','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('exp_tec_externo','exp_tec_externo','varchar');
        $this->setParametro('obs_destinatario','obs_destinatario','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarDestinatario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_destinatario_ime';
		$this->transaccion='SSOM_DEST_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_destinatario_aom','id_destinatario_aom','int4');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('id_aom','id_aom','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('exp_tec_externo','exp_tec_externo','varchar');
        $this->setParametro('obs_destinatario','obs_destinatario','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDestinatario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_destinatario_ime';
		$this->transaccion='SSOM_DEST_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_destinatario_aom','id_destinatario_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>