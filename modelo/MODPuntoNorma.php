<?php
/**
*@package pXP
*@file gen-MODPuntoNorma.php
*@author  (szambrana)
*@date 01-07-2019 18:45:10
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPuntoNorma extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPuntoNorma(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_punto_norma_sel';
		$this->transaccion='SSOM_PTONOR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pn','int4');
		$this->captura('id_norma','int4');
		$this->captura('nombre_pn','varchar');
		$this->captura('codigo_pn','varchar');
		$this->captura('descrip_pn','text');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('sigla_norma','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPuntoNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_punto_norma_ime';
		$this->transaccion='SSOM_PTONOR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_norma','id_norma','int4');
		$this->setParametro('nombre_pn','nombre_pn','varchar');
		$this->setParametro('codigo_pn','codigo_pn','varchar');
		$this->setParametro('descrip_pn','descrip_pn','text');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPuntoNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_punto_norma_ime';
		$this->transaccion='SSOM_PTONOR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pn','id_pn','int4');
		$this->setParametro('id_norma','id_norma','int4');
		$this->setParametro('nombre_pn','nombre_pn','varchar');
		$this->setParametro('codigo_pn','codigo_pn','varchar');
		$this->setParametro('descrip_pn','descrip_pn','text');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPuntoNorma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_punto_norma_ime';
		$this->transaccion='SSOM_PTONOR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pn','id_pn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPuntoNormaMulti(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_punto_norma_sel';
		$this->transaccion='SSOM_PTOM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);
		
		//Definicion de la lista del resultado del query
		$this->captura('id_pn','int4');
		$this->captura('id_norma','int4');
		$this->captura('nombre_pn','varchar');
		$this->captura('codigo_pn','varchar');
		$this->captura('descrip_pn','text');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('nombre_descrip','text');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>