<?php
/**
*@package pXP
*@file gen-MODActividad.php
*@author  (max.camacho)
*@date 05-08-2019 13:33:31
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODActividad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarActividad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_actividad_sel';
		$this->transaccion='SSOM_ATV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_actividad','int4');
		$this->captura('actividad','varchar');
		$this->captura('codigo_actividad','varchar');
		$this->captura('obs_actividad','text');
		$this->captura('estado_reg','varchar');
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
			
	function insertarActividad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_actividad_ime';
		$this->transaccion='SSOM_ATV_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('actividad','actividad','varchar');
		$this->setParametro('codigo_actividad','codigo_actividad','varchar');
		$this->setParametro('obs_actividad','obs_actividad','text');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarActividad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_actividad_ime';
		$this->transaccion='SSOM_ATV_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_actividad','id_actividad','int4');
		$this->setParametro('actividad','actividad','varchar');
		$this->setParametro('codigo_actividad','codigo_actividad','varchar');
		$this->setParametro('obs_actividad','obs_actividad','text');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarActividad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_actividad_ime';
		$this->transaccion='SSOM_ATV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_actividad','id_actividad','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>