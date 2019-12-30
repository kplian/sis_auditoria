<?php
/**
*@package pXP
*@file gen-MODAomRiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 20:00:49
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 20:00:49								CREACION

*/

class MODAomRiesgoOportunidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAomRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_aom_riesgo_oportunidad_sel';
		$this->transaccion='SSOM_AURO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_aom_ro','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_impacto','int4');
		$this->captura('id_probabilidad','int4');
		$this->captura('id_tipo_ro','int4');
		$this->captura('id_ro','int4');
        $this->captura('otro_nombre_ro','varchar');
		$this->captura('id_aom','int4');
		$this->captura('criticidad','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_ro','varchar');
		$this->captura('desc_tipo_ro','varchar');
		$this->captura('nombre_prob','varchar');
		$this->captura('nombre_imp','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAomRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_aom_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_AURO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_impacto','id_impacto','int4');
		$this->setParametro('id_probabilidad','id_probabilidad','int4');
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');
		$this->setParametro('id_ro','id_ro','int4');
        $this->setParametro('otro_nombre_ro','otro_nombre_ro','varchar');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('criticidad','criticidad','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAomRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_aom_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_AURO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aom_ro','id_aom_ro','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_impacto','id_impacto','int4');
		$this->setParametro('id_probabilidad','id_probabilidad','int4');
		$this->setParametro('id_tipo_ro','id_tipo_ro','int4');
		$this->setParametro('id_ro','id_ro','int4');
        $this->setParametro('otro_nombre_ro','otro_nombre_ro','varchar');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('criticidad','criticidad','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAomRiesgoOportunidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_aom_riesgo_oportunidad_ime';
		$this->transaccion='SSOM_AURO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aom_ro','id_aom_ro','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>