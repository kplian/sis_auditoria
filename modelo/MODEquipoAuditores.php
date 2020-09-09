<?php
/**
*@package pXP
*@file gen-MODEquipoAuditores.php
*@author  (admin.miguel)
*@date 03-09-2020 16:11:03
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:03								CREACION

*/

class MODEquipoAuditores extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEquipoAuditores(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_equipo_auditores_sel';
		$this->transaccion='SSOM_EUS_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo_auditores','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('obs_dba','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('id_tipo_participacion','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('desc_funcionario1','text');
        $this->captura('descripcion_cargo','varchar');
        $this->captura('email_empresa','varchar');
        $this->captura('desc_tipo','varchar');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarEquipoAuditores(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_auditores_ime';
		$this->transaccion='SSOM_EUS_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('obs_dba','obs_dba','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_tipo_participacion','id_tipo_participacion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEquipoAuditores(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_auditores_ime';
		$this->transaccion='SSOM_EUS_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo_auditores','id_equipo_auditores','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('obs_dba','obs_dba','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_tipo_participacion','id_tipo_participacion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEquipoAuditores(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_auditores_ime';
		$this->transaccion='SSOM_EUS_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo_auditores','id_equipo_auditores','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>