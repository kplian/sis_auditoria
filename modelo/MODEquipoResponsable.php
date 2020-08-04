<?php
/**
*@package pXP
*@file gen-MODEquipoResponsable.php
*@author  (max.camacho)
*@date 02-08-2019 14:03:25
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEquipoResponsable extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_equipo_responsable_sel';
		$this->transaccion='SSOM_EQRE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion


		//Definicion de la lista del resultado del query
		$this->captura('id_equipo_responsable','int4');
		$this->captura('id_funcionario','int4');
		$this->captura('exp_tec_externo','varchar');
		$this->captura('id_parametro','int4');
		$this->captura('obs_participante','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_aom','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_aom1','varchar');
		$this->captura('desc_funcionario1','text');
		$this->captura('valor_parametro','varchar');
		$this->captura('codigo_parametro','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_responsable_ime';
		$this->transaccion='SSOM_EQRE_INS';
		$this->tipo_procedimiento='IME';

        $this->setParametro('field_codigo_parametro','field_codigo_parametro','varchar');

		//Define los parametros para la funcion
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('exp_tec_externo','exp_tec_externo','varchar');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('obs_participante','obs_participante','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function modificarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_responsable_ime';
		$this->transaccion='SSOM_EQRE_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
    $this->setParametro('exp_tec_externo','exp_tec_externo','varchar');
    $this->setParametro('id_parametro','id_parametro','int4');
    $this->setParametro('obs_participante','obs_participante','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function eliminarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_responsable_ime';
		$this->transaccion='SSOM_EQRE_ELI';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarItemEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_equipo_responsable_ime';
		$this->transaccion='SSOM_EQIS_INS';
		$this->tipo_procedimiento='IME';

		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('id_interno','id_interno','int4');
		$this->setParametro('id_equipo_auditor','id_equipo_auditor','text');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

}
?>
