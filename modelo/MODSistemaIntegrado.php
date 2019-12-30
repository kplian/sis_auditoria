<?php
/**
*@package pXP
*@file gen-MODSistemaIntegrado.php
*@author  (szambrana)
*@date 24-07-2019 21:09:26
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSistemaIntegrado extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSistemaIntegrado(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_sistema_integrado_sel';
		$this->transaccion='SSOM_SISINT_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_si','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_si','varchar');
		$this->captura('descrip_si','varchar');
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
			
	function insertarSistemaIntegrado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_sistema_integrado_ime';
		$this->transaccion='SSOM_SISINT_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_si','nombre_si','varchar');
		$this->setParametro('descrip_si','descrip_si','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSistemaIntegrado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_sistema_integrado_ime';
		$this->transaccion='SSOM_SISINT_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_si','id_si','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_si','nombre_si','varchar');
		$this->setParametro('descrip_si','descrip_si','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSistemaIntegrado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_sistema_integrado_ime';
		$this->transaccion='SSOM_SISINT_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_si','id_si','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>