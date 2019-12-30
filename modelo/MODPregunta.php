<?php
/**
*@package pXP
*@file gen-MODPregunta.php
*@author  (szambrana)
*@date 01-07-2019 19:04:06
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPregunta extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPregunta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_pregunta_sel';
		$this->transaccion='SSOM_PRPTNOR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pregunta','int4');
		$this->captura('nro_pregunta','int4');
		$this->captura('descrip_pregunta','text');
		$this->captura('estado_reg','varchar');
		$this->captura('id_pn','int4');
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
			
	function insertarPregunta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pregunta_ime';
		$this->transaccion='SSOM_PRPTNOR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nro_pregunta','nro_pregunta','int4');
		$this->setParametro('descrip_pregunta','descrip_pregunta','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_pn','id_pn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPregunta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pregunta_ime';
		$this->transaccion='SSOM_PRPTNOR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pregunta','id_pregunta','int4');
		$this->setParametro('nro_pregunta','nro_pregunta','int4');
		$this->setParametro('descrip_pregunta','descrip_pregunta','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_pn','id_pn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPregunta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pregunta_ime';
		$this->transaccion='SSOM_PRPTNOR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pregunta','id_pregunta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>