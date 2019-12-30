<?php
/**
*@package pXP
*@file gen-MODAccionRo.php
*@author  (max.camacho)
*@date 16-12-2019 19:41:57
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 19:41:57								CREACION

*/

class MODAccionRo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAccionRo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_accion_ro_sel';
		$this->transaccion='SSOM_ARO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_accion_ro','int4');
		$this->captura('id_aom_ro','int4');
		$this->captura('accion_ro','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('desc_accion_ro','text');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAccionRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_ro_ime';
		$this->transaccion='SSOM_ARO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aom_ro','id_aom_ro','int4');
		$this->setParametro('accion_ro','accion_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('desc_accion_ro','desc_accion_ro','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAccionRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_ro_ime';
		$this->transaccion='SSOM_ARO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_accion_ro','id_accion_ro','int4');
		$this->setParametro('id_aom_ro','id_aom_ro','int4');
		$this->setParametro('accion_ro','accion_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('desc_accion_ro','desc_accion_ro','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAccionRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_ro_ime';
		$this->transaccion='SSOM_ARO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_accion_ro','id_accion_ro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>