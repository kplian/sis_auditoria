<?php
/**
*@package pXP
*@file gen-MODCompetencia.php
*@author  (admin.miguel)
*@date 03-09-2020 16:11:08
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:08								CREACION

*/

class MODCompetencia extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCompetencia(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_competencia_sel';
		$this->transaccion='SSOM_COA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_competencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('obs_dba','varchar');
		$this->captura('id_equipo_auditores','int4');
		$this->captura('id_norma','int4');
		$this->captura('nro_auditorias','int4');
		$this->captura('hras_formacion','int4');
		$this->captura('meses_actualizacion','int4');
		$this->captura('calificacion','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_sigla_norma','varchar');
		$this->captura('nombre_norma','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_competencia_ime';
		$this->transaccion='SSOM_COA_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('obs_dba','obs_dba','varchar');
		$this->setParametro('id_equipo_auditores','id_equipo_auditores','int4');
		$this->setParametro('id_norma','id_norma','int4');
		$this->setParametro('nro_auditorias','nro_auditorias','int4');
		$this->setParametro('hras_formacion','hras_formacion','int4');
		$this->setParametro('meses_actualizacion','meses_actualizacion','int4');
		$this->setParametro('calificacion','calificacion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_competencia_ime';
		$this->transaccion='SSOM_COA_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('obs_dba','obs_dba','varchar');
		$this->setParametro('id_equipo_auditores','id_equipo_auditores','int4');
		$this->setParametro('id_norma','id_norma','int4');
		$this->setParametro('nro_auditorias','nro_auditorias','int4');
		$this->setParametro('hras_formacion','hras_formacion','int4');
		$this->setParametro('meses_actualizacion','meses_actualizacion','int4');
		$this->setParametro('calificacion','calificacion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_competencia_ime';
		$this->transaccion='SSOM_COA_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia','id_competencia','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>