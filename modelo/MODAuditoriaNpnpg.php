<?php
/**
*@package pXP
*@file gen-MODAuditoriaNpnpg.php
*@author  (max.camacho)
*@date 25-07-2019 21:34:47
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAuditoriaNpnpg extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAuditoriaNpnpg(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_auditoria_npnpg_sel';
		$this->transaccion='SSOM_APNP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_anpnpg','int4');
		$this->captura('pg_valoracion','varchar');
		$this->captura('obs_pg','text');
		$this->captura('id_pregunta','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_anpn','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_pn','varchar');
		$this->captura('id_pn','int4');
		$this->captura('descrip_pregunta','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAuditoriaNpnpg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npnpg_ime';
		$this->transaccion='SSOM_APNP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('pg_valoracion','pg_valoracion','varchar');
		$this->setParametro('obs_pg','obs_pg','text');
		$this->setParametro('id_pregunta','id_pregunta','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_anpn','id_anpn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAuditoriaNpnpg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npnpg_ime';
		$this->transaccion='SSOM_APNP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_anpnpg','id_anpnpg','int4');
		$this->setParametro('pg_valoracion','pg_valoracion','varchar');
		$this->setParametro('obs_pg','obs_pg','text');
		$this->setParametro('id_pregunta','id_pregunta','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_anpn','id_anpn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAuditoriaNpnpg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_npnpg_ime';
		$this->transaccion='SSOM_APNP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_anpnpg','id_anpnpg','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>