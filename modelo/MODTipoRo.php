<?php
/**
*@package pXP
*@file gen-MODTipoRo.php
*@author  (max.camacho)
*@date 16-12-2019 17:36:24
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:36:24								CREACION

*/

class MODTipoRo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTipoRo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_tipo_ro_sel';
		$this->transaccion='SSOM_TRO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tipo_ro','int4');
		$this->captura('tipo_ro','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('desc_tipo_ro','text');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
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
			
	function insertarTipoRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_ro_ime';
		$this->transaccion='SSOM_TRO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('tipo_ro','tipo_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('desc_tipo_ro','desc_tipo_ro','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTipoRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_ro_ime';
		$this->transaccion='SSOM_TRO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');
		$this->setParametro('tipo_ro','tipo_ro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('desc_tipo_ro','desc_tipo_ro','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTipoRo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_ro_ime';
		$this->transaccion='SSOM_TRO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>