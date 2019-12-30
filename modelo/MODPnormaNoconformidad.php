<?php
/**
*@package pXP
*@file gen-MODPnormaNoconformidad.php
*@author  (szambrana)
*@date 19-07-2019 15:25:54
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPnormaNoconformidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPnormaNoconformidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_pnorma_noconformidad_sel';
		$this->transaccion='SSOM_PNNC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pnnc','int4');
		$this->captura('id_nc','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_pn','int4');
		$this->captura('id_norma','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		//**********************SSS***
        $this->captura('desc_norma','varchar');
        $this->captura('desc_pn','varchar');
        //*********************
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPnormaNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pnorma_noconformidad_ime';
		$this->transaccion='SSOM_PNNC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_pn','id_pn','varchar');
		$this->setParametro('id_norma','id_norma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPnormaNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pnorma_noconformidad_ime';
		$this->transaccion='SSOM_PNNC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pnnc','id_pnnc','int4');
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_pn','id_pn','int4');
		$this->setParametro('id_norma','id_norma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPnormaNoconformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_pnorma_noconformidad_ime';
		$this->transaccion='SSOM_PNNC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pnnc','id_pnnc','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
}
?>