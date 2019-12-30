<?php
/**
*@package pXP
*@file gen-MODGrupoConsultivo.php
*@author  (max.camacho)
*@date 22-07-2019 23:01:14
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODGrupoConsultivo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarGrupoConsultivo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_grupo_consultivo_sel';
		$this->transaccion='SSOM_GCT_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_gconsultivo','int4');
		$this->captura('nombre_programacion','varchar');
		$this->captura('id_empresa','int4');
		$this->captura('descrip_gconsultivo','text');
		$this->captura('nombre_gconsultivo','varchar');
		$this->captura('requiere_programacion','varchar');
		$this->captura('nombre_formulario','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('requiere_formulario','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('empresa','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarGrupoConsultivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_grupo_consultivo_ime';
		$this->transaccion='SSOM_GCT_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nombre_programacion','nombre_programacion','varchar');
		$this->setParametro('id_empresa','id_empresa','int4');
		$this->setParametro('descrip_gconsultivo','descrip_gconsultivo','text');
		$this->setParametro('nombre_gconsultivo','nombre_gconsultivo','varchar');
		$this->setParametro('requiere_programacion','requiere_programacion','varchar');
		$this->setParametro('nombre_formulario','nombre_formulario','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('requiere_formulario','requiere_formulario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarGrupoConsultivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_grupo_consultivo_ime';
		$this->transaccion='SSOM_GCT_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gconsultivo','id_gconsultivo','int4');
		$this->setParametro('nombre_programacion','nombre_programacion','varchar');
		$this->setParametro('id_empresa','id_empresa','int4');
		$this->setParametro('descrip_gconsultivo','descrip_gconsultivo','text');
		$this->setParametro('nombre_gconsultivo','nombre_gconsultivo','varchar');
		$this->setParametro('requiere_programacion','requiere_programacion','varchar');
		$this->setParametro('nombre_formulario','nombre_formulario','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('requiere_formulario','requiere_formulario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarGrupoConsultivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_grupo_consultivo_ime';
		$this->transaccion='SSOM_GCT_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gconsultivo','id_gconsultivo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
    function getListEmpresa(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_grupo_consultivo_sel';
        $this->transaccion='SSOM_GCTX1_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_empresa','int4');
        $this->captura('empresa','varchar');



        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
			
}
?>