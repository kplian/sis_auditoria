<?php
/**
*@package pXP
*@file gen-MODOportunidadMejora.php
*@author  (max.camacho)
*@date 27-06-2019 22:05:51
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODOportunidadMejora extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_oportunidad_mejora_sel';
		$this->transaccion='SSOM_AOM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_om','int4');
		$this->captura('codigo_om','varchar');
		$this->captura('fecha_eje_fin','date');
		$this->captura('fecha_prog_fin','date');
		$this->captura('id_si','int4');
		$this->captura('fecha_planificacion','date');
		$this->captura('id_gc','int4');
		$this->captura('id_uo','int4');
		$this->captura('descrip_om','text');
		$this->captura('estado_reg','varchar');
		$this->captura('resumen_acta_om','text');
		$this->captura('fehca_eje_inicio','date');
		$this->captura('estado_om','varchar');
		$this->captura('fecha_prog_inicio','date');
		$this->captura('recomendacion_om','text');
		$this->captura('titulo_om','varchar');
		$this->captura('id_tipo_auditoria','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('img_om','varchar');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo_auditoria','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('codigo_om','codigo_om','varchar');
		$this->setParametro('fecha_eje_fin','fecha_eje_fin','date');
		$this->setParametro('fecha_prog_fin','fecha_prog_fin','date');
		$this->setParametro('id_si','id_si','int4');
		$this->setParametro('fecha_planificacion','fecha_planificacion','date');
		$this->setParametro('id_gc','id_gc','int4');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('descrip_om','descrip_om','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('resumen_acta_om','resumen_acta_om','text');
		$this->setParametro('fehca_eje_inicio','fehca_eje_inicio','date');
		$this->setParametro('estado_om','estado_om','varchar');
		$this->setParametro('fecha_prog_inicio','fecha_prog_inicio','date');
		$this->setParametro('recomendacion_om','recomendacion_om','text');
		$this->setParametro('titulo_om','titulo_om','varchar');
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_om','id_om','int4');
		$this->setParametro('codigo_om','codigo_om','varchar');
		$this->setParametro('fecha_eje_fin','fecha_eje_fin','date');
		$this->setParametro('fecha_prog_fin','fecha_prog_fin','date');
		$this->setParametro('id_si','id_si','int4');
		$this->setParametro('fecha_planificacion','fecha_planificacion','date');
		$this->setParametro('id_gc','id_gc','int4');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('descrip_om','descrip_om','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('resumen_acta_om','resumen_acta_om','text');
		$this->setParametro('fehca_eje_inicio','fehca_eje_inicio','date');
		$this->setParametro('estado_om','estado_om','varchar');
		$this->setParametro('fecha_prog_inicio','fecha_prog_inicio','date');
		$this->setParametro('recomendacion_om','recomendacion_om','text');
		$this->setParametro('titulo_om','titulo_om','varchar');
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_om','id_om','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>