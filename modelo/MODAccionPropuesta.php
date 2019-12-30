<?php
/**
*@package pXP
*@file gen-MODAccionPropuesta.php
*@author  (szambrana)
*@date 04-07-2019 22:32:50
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAccionPropuesta extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAccionPropuesta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_accion_propuesta_sel';
		$this->transaccion='SSOM_ACCPRO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_ap','int4');
		$this->captura('obs_resp_area','text');
		$this->captura('descripcion_ap','text'); 
		$this->captura('id_parametro','int4');
		$this->captura('id_funcionario','int4');
		$this->captura('descrip_causa_nc','text');
		$this->captura('estado_reg','varchar');
		$this->captura('efectividad_cumpl_ap','text');
		$this->captura('fecha_fin_ap','date');
		$this->captura('obs_auditor_consultor','text');
		$this->captura('id_nc','int4');
		$this->captura('fecha_inicio_ap','date');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		//******wf
        $this->captura('id_proceso_wf','int4');  //integrar con wf new
        $this->captura('id_estado_wf','int4'); //integrar con wf new
        $this->captura('nro_tramite','varchar'); //integrar con wf new
        $this->captura('estado_wf','varchar');//integrar con wf new		
		
		$this->captura('codigo_ap','varchar');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		//************************
		$this->captura('valor_parametro','varchar');
		$this->captura('funcionario_name','text');
		$this->captura('contador_estados','int4'); //contador_estados
		

		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAccionPropuesta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_propuesta_ime';
		$this->transaccion='SSOM_ACCPRO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('obs_resp_area','obs_resp_area','text');
		$this->setParametro('descripcion_ap','descripcion_ap','text');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('descrip_causa_nc','descrip_causa_nc','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('efectividad_cumpl_ap','efectividad_cumpl_ap','text');
		$this->setParametro('fecha_fin_ap','fecha_fin_ap','date');
		$this->setParametro('obs_auditor_consultor','obs_auditor_consultor','text');
		//$this->setParametro('estado_ap','estado_ap','varchar');
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('fecha_inicio_ap','fecha_inicio_ap','date');
		$this->setParametro('codigo_ap','codigo_ap','text');	
		$this->setParametro('nro_tramite_padre','nro_tramite_padre','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAccionPropuesta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_propuesta_ime';
		$this->transaccion='SSOM_ACCPRO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ap','id_ap','int4');
		$this->setParametro('obs_resp_area','obs_resp_area','text');
		$this->setParametro('descripcion_ap','descripcion_ap','text');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('descrip_causa_nc','descrip_causa_nc','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('efectividad_cumpl_ap','efectividad_cumpl_ap','text');
		$this->setParametro('fecha_fin_ap','fecha_fin_ap','date');
		$this->setParametro('obs_auditor_consultor','obs_auditor_consultor','text');
		
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('fecha_inicio_ap','fecha_inicio_ap','date');
		$this->setParametro('codigo_ap','codigo_ap','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAccionPropuesta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_accion_propuesta_ime';
		$this->transaccion='SSOM_ACCPRO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ap','id_ap','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarSomUsuario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_sel';
        $this->transaccion='SSOM_USU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //$this->setCount(false);

        //Definicion de la lista del resultado del query
        $this->captura('id_uo_funcionario','int4');
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','text');
        $this->captura('desc_funcionario2','text');
        $this->captura('id_uo','int4');
        $this->captura('nombre_cargo','varchar');
        $this->captura('fecha_asignacion','date');
        $this->captura('fecha_finalizacion','date');
        $this->captura('num_doc','int4');
        $this->captura('ci','varchar');
        $this->captura('codigo','varchar');
        $this->captura('email_empresa','varchar');
        $this->captura('estado_reg_fun','varchar');
        $this->captura('estado_reg_asi','varchar');
		$this->captura('id_cargo','int4');
		$this->captura('descripcion_cargo','varchar');
		$this->captura('cargo_codigo','varchar');
		$this->captura('nombre_unidad','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function siguienteEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_accion_propuesta_ime';
        $this->transaccion = 'SSOM_SIG_IME';
        $this->tipo_procedimiento = 'IME';
        //Define los parametros para la funcion
        $this->setParametro('id_proceso_wf_act', 'id_proceso_wf_act', 'int4');
        $this->setParametro('id_estado_wf_act', 'id_estado_wf_act', 'int4');
        $this->setParametro('id_funcionario_usu', 'id_funcionario_usu', 'int4');
        $this->setParametro('id_tipo_estado', 'id_tipo_estado', 'int4');
        $this->setParametro('id_funcionario_wf', 'id_funcionario_wf', 'int4');
        $this->setParametro('id_depto_wf', 'id_depto_wf', 'int4');
        $this->setParametro('obs', 'obs', 'text');
        $this->setParametro('json_procesos', 'json_procesos', 'text');
        // $this->setParametro('id_uo_padre', 'id_uo_padre', 'int4');		
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function anteriorEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_accion_propuesta_ime';
        $this->transaccion = 'SSOM_ANT_IME';
        $this->tipo_procedimiento = 'IME';
        //Define los parametros para la funcion
        $this->setParametro('id_proceso_wf', 'id_proceso_wf', 'int4');
        $this->setParametro('id_estado_wf', 'id_estado_wf', 'int4');
        $this->setParametro('obs', 'obs', 'text');
        $this->setParametro('estado_destino', 'estado_destino', 'varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
	
			
}
?>