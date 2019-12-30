<?php
/**
*@package pXP
*@file gen-MODTipoParametro.php
*@author  (max.camacho)
*@date 03-07-2019 13:09:09
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTipoParametro extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTipoParametro(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_tipo_parametro_sel';
		$this->transaccion='SSOM_TPR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tipo_parametro','int4');
		$this->captura('tipo_parametro','varchar');
		$this->captura('descrip_parametro','text');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
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
			
	function insertarTipoParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_parametro_ime';
		$this->transaccion='SSOM_TPR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
        $this->setParametro('tipo_parametro','tipo_parametro','varchar');
		$this->setParametro('descrip_parametro','descrip_parametro','text');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTipoParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_parametro_ime';
		$this->transaccion='SSOM_TPR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_parametro','id_tipo_parametro','int4');
		$this->setParametro('tipo_parametro','tipo_parametro','varchar');
		$this->setParametro('descrip_parametro','descrip_parametro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTipoParametro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_tipo_parametro_ime';
		$this->transaccion='SSOM_TPR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_parametro','id_tipo_parametro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>