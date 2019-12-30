<?php
/**
*@package pXP
*@file gen-MODRiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 17:57:34
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:57:34								CREACION

*/

class MODRiesgoOportunidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_riesgo_oportunidad_sel';
		$this->transaccion='SSOM_RIOP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_ro','int4');
		$this->captura('id_tipo_ro','int4');
		$this->captura('nombre_ro','varchar');
		$this->captura('codigo_ro','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo_ro','varchar');
		$this->captura('desc_tipo_ro','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_RIOP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');
		$this->setParametro('nombre_ro','nombre_ro','varchar');
		$this->setParametro('codigo_ro','codigo_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_RIOP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ro','id_ro','int4');
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');
		$this->setParametro('nombre_ro','nombre_ro','varchar');
		$this->setParametro('codigo_ro','codigo_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_RIOP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ro','id_ro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>