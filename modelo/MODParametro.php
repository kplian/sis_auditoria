<?php
/**
*@package pXP
*@file gen-MODParametro.php
*@author  (max.camacho)
*@date 03-07-2019 16:18:31
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODParametro extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarParametro(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_parametro_sel';
		$this->transaccion='SSOM_PRM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_parametro','int4');
		$this->captura('id_tipo_parametro','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('valor_parametro','varchar');
		$this->captura('codigo_parametro','varchar');
		//$this->captura('tipo_parametro','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo_parametro','varchar');
		$this->captura('descrip_parametro','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_ime';
		$this->transaccion='SSOM_PRM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_parametro','id_tipo_parametro','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('valor_parametro','valor_parametro','varchar');
		$this->setParametro('codigo_parametro','codigo_parametro','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_ime';
		$this->transaccion='SSOM_PRM_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('id_tipo_parametro','id_tipo_parametro','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('valor_parametro','valor_parametro','varchar');
		$this->setParametro('codigo_parametro','codigo_parametro','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function eliminarParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_parametro_ime';
		$this->transaccion='SSOM_PRM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_parametro','id_parametro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
}
?>