<?php
/**
*@package pXP
*@file gen-MODCronogramaEquipoResponsable.php
*@author  (max.camacho)
*@date 12-12-2019 20:16:51
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019 20:16:51								CREACION

*/

class MODCronogramaEquipoResponsable extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCronogramaEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_cronograma_equipo_responsable_sel';
		$this->transaccion='SSOM_CRER_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cronog_eq_resp','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('v_participacion','varchar');
		$this->captura('obs_participacion','text');
		$this->captura('id_equipo_responsable','int4');
		$this->captura('id_cronograma','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('desc_funcionario1','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCronogramaEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_equipo_responsable_ime';
		$this->transaccion='SSOM_CRER_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('v_participacion','v_participacion','varchar');
		$this->setParametro('obs_participacion','obs_participacion','text');
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','varchar');
		$this->setParametro('id_cronograma','id_cronograma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCronogramaEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_equipo_responsable_ime';
		$this->transaccion='SSOM_CRER_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cronog_eq_resp','id_cronog_eq_resp','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('v_participacion','v_participacion','varchar');
		$this->setParametro('obs_participacion','obs_participacion','text');
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','int4');
		$this->setParametro('id_cronograma','id_cronograma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCronogramaEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_equipo_responsable_ime';
		$this->transaccion='SSOM_CRER_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cronog_eq_resp','id_cronog_eq_resp','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>