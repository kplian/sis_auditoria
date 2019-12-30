<?php
/**
*@package pXP
*@file gen-MODImpacto.php
*@author  (max.camacho)
*@date 16-12-2019 18:31:26
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 18:31:26								CREACION

*/

class MODImpacto extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarImpacto(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_impacto_sel';
		$this->transaccion='SSOM_IMP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_impacto','int4');
		$this->captura('desc_imp','text');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_imp','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
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
			
	function insertarImpacto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_impacto_ime';
		$this->transaccion='SSOM_IMP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('desc_imp','desc_imp','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_imp','nombre_imp','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarImpacto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_impacto_ime';
		$this->transaccion='SSOM_IMP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_impacto','id_impacto','int4');
		$this->setParametro('desc_imp','desc_imp','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_imp','nombre_imp','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarImpacto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_impacto_ime';
		$this->transaccion='SSOM_IMP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_impacto','id_impacto','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>