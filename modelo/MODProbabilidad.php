<?php
/**
*@package pXP
*@file gen-MODProbabilidad.php
*@author  (max.camacho)
*@date 16-12-2019 18:22:42
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 18:22:42								CREACION

*/

class MODProbabilidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarProbabilidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_probabilidad_sel';
		$this->transaccion='SSOM_PROB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_probabilidad','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_prob','varchar');
		$this->captura('desc_prob','text');
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
			
	function insertarProbabilidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_probabilidad_ime';
		$this->transaccion='SSOM_PROB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_prob','nombre_prob','varchar');
		$this->setParametro('desc_prob','desc_prob','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarProbabilidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_probabilidad_ime';
		$this->transaccion='SSOM_PROB_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_probabilidad','id_probabilidad','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_prob','nombre_prob','varchar');
		$this->setParametro('desc_prob','desc_prob','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarProbabilidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_probabilidad_ime';
		$this->transaccion='SSOM_PROB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_probabilidad','id_probabilidad','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>