<?php
/**
*@package pXP
*@file gen-MODCronograma.php
*@author  (max.camacho)
*@date 12-12-2019 15:50:53
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019 15:50:53								CREACION

*/

class MODCronograma extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCronograma(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_cronograma_sel';
		$this->transaccion='SSOM_CRONOG_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cronograma','int4');
		$this->captura('nueva_actividad','varchar');
		$this->captura('obs_actividad','text');
		$this->captura('estado_reg','varchar');
		$this->captura('hora_ini_activ','time');
		$this->captura('fecha_ini_activ','date');
		$this->captura('fecha_fin_activ','date');
		$this->captura('id_actividad','int4');
		$this->captura('hora_fin_activ','time');
		$this->captura('id_aom','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('actividad','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nueva_actividad','nueva_actividad','varchar');
		$this->setParametro('obs_actividad','obs_actividad','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('hora_ini_activ','hora_ini_activ','time');
		$this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
		$this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
		$this->setParametro('id_actividad','id_actividad','int4');
		$this->setParametro('hora_fin_activ','hora_fin_activ','time');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cronograma','id_cronograma','int4');
		$this->setParametro('nueva_actividad','nueva_actividad','varchar');
		$this->setParametro('obs_actividad','obs_actividad','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('hora_ini_activ','hora_ini_activ','time');
		$this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
		$this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
		$this->setParametro('id_actividad','id_actividad','int4');
		$this->setParametro('hora_fin_activ','hora_fin_activ','time');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cronograma','id_cronograma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>