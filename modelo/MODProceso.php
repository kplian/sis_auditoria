<?php
/**
*@package pXP
*@file gen-MODProceso.php
*@author  (max.camacho)
*@date 15-07-2019 20:16:48
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODProceso extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarProceso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_proceso_sel';
		$this->transaccion='SSOM_PCS_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_proceso','int4');
		$this->captura('proceso','varchar');
		$this->captura('descrip_proceso','text');
		$this->captura('acronimo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_responsable','int4');
		$this->captura('codigo_proceso','varchar');
		$this->captura('vigencia','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_funcionario1','text');
		//$this->captura('nombre_unidad','varchar');
		//$this->captura('vigencia','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_proceso_ime';
		$this->transaccion='SSOM_PCS_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('proceso','proceso','varchar');
		$this->setParametro('descrip_proceso','descrip_proceso','text');
		$this->setParametro('acronimo','acronimo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('codigo_proceso','codigo_proceso','varchar');
		$this->setParametro('vigencia','vigencia','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_proceso_ime';
		$this->transaccion='SSOM_PCS_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_proceso','id_proceso','int4');
		$this->setParametro('proceso','proceso','varchar');
		$this->setParametro('descrip_proceso','descrip_proceso','text');
		$this->setParametro('acronimo','acronimo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('codigo_proceso','codigo_proceso','varchar');
		$this->setParametro('vigencia','vigencia','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarProceso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_proceso_ime';
		$this->transaccion='SSOM_PCS_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_proceso','id_proceso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>