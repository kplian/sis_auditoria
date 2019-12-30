<?php
/**
*@package pXP
*@file gen-MODNorma.php
*@author  (szambrana)
*@date 02-07-2019 19:11:48
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODNorma extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarNorma(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_norma_sel';
		$this->transaccion='SSOM_NOR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_norma','int4');
		$this->captura('id_parametro','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_norma','varchar');
		$this->captura('sigla_norma','varchar');
		$this->captura('descrip_norma','text');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		//***********SSS
		$this->captura('desc_tn','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_norma_ime';
		$this->transaccion='SSOM_NOR_INS';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_norma','nombre_norma','varchar');
		$this->setParametro('sigla_norma','sigla_norma','varchar');
		$this->setParametro('descrip_norma','descrip_norma','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_norma_ime';
		$this->transaccion='SSOM_NOR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_norma','id_norma','int4');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_norma','nombre_norma','varchar');
		$this->setParametro('sigla_norma','sigla_norma','varchar');
		$this->setParametro('descrip_norma','descrip_norma','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_norma_ime';
		$this->transaccion='SSOM_NOR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_norma','id_norma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>