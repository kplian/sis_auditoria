<?php
/**
*@package pXP
*@file gen-MODAuditoriaNpn.php
*@author  (max.camacho)
*@date 25-07-2019 21:19:37
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAuditoriaNpn extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAuditoriaNpn(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_auditoria_npn_sel';
		$this->transaccion='SSOM_ANPN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_anpn','int4');
		$this->captura('estado_reg','varchar');
        $this->captura('id_aom','int4'); //
		$this->captura('id_pn','int4');
		$this->captura('id_norma','int4');
        $this->captura('obs_apn','text'); //
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('sigla_norma','varchar');
        $this->captura('nombre_norma','varchar');
		$this->captura('desc_punto_norma','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAuditoriaNpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npn_ime';
		$this->transaccion='SSOM_ANPN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_pn','id_pn','int4');
		$this->setParametro('id_norma','id_norma','int4');
        $this->setParametro('obs_apn','obs_apn','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAuditoriaNpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npn_ime';
		$this->transaccion='SSOM_ANPN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_anpn','id_anpn','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_pn','id_pn','int4');
		$this->setParametro('id_norma','id_norma','int4');
        $this->setParametro('obs_apn','obs_apn','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAuditoriaNpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npn_ime';
		$this->transaccion='SSOM_ANPN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_anpn','id_anpn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>