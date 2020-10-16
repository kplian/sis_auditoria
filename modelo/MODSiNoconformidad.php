<?php
/**
*@package pXP
*@file gen-MODSiNoconformidad.php
*@author  (szambrana)
*@date 09-08-2019 15:16:47
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSiNoconformidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSiNoconformidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_si_noconformidad_sel';
		$this->transaccion='SSOM_SINOCONF_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sinc','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_nc','int4');
		$this->captura('id_si','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_si','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSiNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_si_noconformidad_ime';
		$this->transaccion='SSOM_SINOCONF_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('id_si','id_si','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSiNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_si_noconformidad_ime';
		$this->transaccion='SSOM_SINOCONF_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sinc','id_sinc','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('id_si','id_si','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSiNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_si_noconformidad_ime';
		$this->transaccion='SSOM_SINOCONF_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sinc','id_sinc','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarRespAreaGerente(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_REUO_IME';
        $this->tipo_procedimiento='IME';//tipo de transaccion

        //Definicion de la lista del resultado del query
       $this->setParametro('id_uo','id_uo','int4');
 
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
	}
			
}
?>