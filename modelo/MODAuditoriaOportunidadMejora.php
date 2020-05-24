<?php
/**
*@package pXP
*@file gen-MODAuditoriaOportunidadMejora.php
*@author  (max.camacho)
*@date 17-07-2019 17:41:55
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAuditoriaOportunidadMejora extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
	function listarAuditoriaOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
		$this->transaccion='SSOM_AOM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		$this->captura('id_aom','int4');
		$this->captura('id_proceso_wf','int4');
		$this->captura('nro_tramite_wf','varchar');
		$this->captura('id_funcionario','int4');
        $this->captura('id_uo','int4');
        $this->captura('id_gconsultivo','int4');
        $this->captura('id_tobjeto','varchar');
        $this->captura('id_estado_wf','int4');
        $this->captura('id_tnorma','varchar');  // corregir
        $this->captura('id_tipo_om','int4');
        $this->captura('id_tipo_auditoria','int4');
        $this->captura('fecha_prog_inicio','date');
        $this->captura('fecha_prog_fin','date');
        $this->captura('fecha_prev_inicio','date');
        $this->captura('fecha_prev_fin','date');
        $this->captura('recomendacion','text');
        $this->captura('codigo_aom','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('descrip_aom1','text');
        $this->captura('estado_reg','varchar');
		$this->captura('estado_wf','varchar');
		$this->captura('nombre_estado','varchar');
        $this->captura('fecha_eje_inicio','date');
        $this->captura('fecha_eje_fin','date');
        $this->captura('lugar','varchar');
        $this->captura('formulario_ingreso','text');
        $this->captura('estado_form_ingreso','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_unidad','varchar');
        $this->captura('desc_funcionario2','text');
        $this->captura('nombre_gconsultivo','varchar');
        $this->captura('desc_tipo_objeto','varchar');
		$this->captura('desc_tipo_norma','varchar');
		$this->captura('codigo_parametro','varchar');
		$this->captura('desc_tipo_om','varchar');
        $this->captura('tipo_auditoria','text');
		$this->captura('codigo_tpo_aom','varchar');
		$this->captura('requiere_programacion','varchar');
		$this->captura('requiere_formulario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAuditoriaOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_proceso_wf','id_proceso_wf','int4');
		$this->setParametro('nro_tramite_wf','nro_tramite_wf','varchar');
		//$this->setParametro('resumen','resumen','text');
		$this->setParametro('resumen','resumen','codigo_html');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('fecha_prog_inicio','fecha_prog_inicio','date');
		$this->setParametro('recomendacion','recomendacion','text');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('id_gconsultivo','id_gconsultivo','int4');
		$this->setParametro('fecha_prev_inicio','fecha_prev_inicio','date');
		$this->setParametro('fecha_prev_fin','fecha_prev_fin','date');
		$this->setParametro('fecha_prog_fin','fecha_prog_fin','date');
		$this->setParametro('descrip_aom2','descrip_aom2','text');
		$this->setParametro('nombre_aom1','nombre_aom1','varchar');
		$this->setParametro('documento','documento','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado_wf','estado_wf','varchar');
		$this->setParametro('id_tobjeto','id_tobjeto','int4');
		$this->setParametro('id_estado_wf','id_estado_wf','int4');
		$this->setParametro('id_tnorma','id_tnorma','int4');
		$this->setParametro('fecha_eje_inicio','fecha_eje_inicio','date');
		$this->setParametro('codigo_aom','codigo_aom','varchar');
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');
		$this->setParametro('descrip_aom1','descrip_aom1','text');
		$this->setParametro('lugar','lugar','varchar');
		$this->setParametro('id_tipo_om','id_tipo_om','int4');

        $this->setParametro('formulario_ingreso','formulario_ingreso','text');
        $this->setParametro('estado_form_ingreso','estado_form_ingreso','int4');

		$this->setParametro('fecha_eje_fin','fecha_eje_fin','date');
		$this->setParametro('nombre_aom2','nombre_aom2','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAuditoriaOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_MOD';
		$this->tipo_procedimiento='IME';
        //$this->setParametro('id_funcionario','id_funcionario','int4');

		//Define los parametros para la funcion
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_proceso_wf','id_proceso_wf','int4');
		$this->setParametro('nro_tramite_wf','nro_tramite_wf','varchar');
		//$this->setParametro('resumen','resumen','text');
		$this->setParametro('resumen','resumen','codigo_html');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('fecha_prog_inicio','fecha_prog_inicio','date');
		$this->setParametro('recomendacion','recomendacion','text');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('id_gconsultivo','id_gconsultivo','int4');
		$this->setParametro('fecha_prev_inicio','fecha_prev_inicio','date');
		$this->setParametro('fecha_prev_fin','fecha_prev_fin','date');
		$this->setParametro('fecha_prog_fin','fecha_prog_fin','date');
		$this->setParametro('descrip_aom2','descrip_aom2','text');
		$this->setParametro('nombre_aom1','nombre_aom1','varchar');
		$this->setParametro('documento','documento','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado_wf','estado_wf','varchar');
		$this->setParametro('id_tobjeto','id_tobjeto','int4');
		$this->setParametro('id_estado_wf','id_estado_wf','int4');
		$this->setParametro('id_tnorma','id_tnorma','int4');
		$this->setParametro('fecha_eje_inicio','fecha_eje_inicio','date');
		$this->setParametro('codigo_aom','codigo_aom','varchar');
		$this->setParametro('id_tipo_auditoria','id_tipo_auditoria','int4');
		$this->setParametro('descrip_aom1','descrip_aom1','text');
		$this->setParametro('lugar','lugar','varchar');
		$this->setParametro('id_tipo_om','id_tipo_om','int4');

        $this->setParametro('formulario_ingreso','formulario_ingreso','text');
        $this->setParametro('estado_form_ingreso','estado_form_ingreso','int4');

		$this->setParametro('fecha_eje_fin','fecha_eje_fin','date');
		$this->setParametro('nombre_aom2','nombre_aom2','varchar');
		//$this->setParametro('formulario','formulario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAuditoriaOportunidadMejora(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
		$this->transaccion='SSOM_AOM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('nombre_unidad','nombre_unidad','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
    function reporteResumen(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_RESU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        $this->setParametro('id_aom','id_aom','int4');
        //Definicion de la lista del resultado del query
        $this->captura('id_aom','int4');
        $this->captura('fecha_prev_inicio','date');
        $this->captura('fecha_prev_fin','date');
        $this->captura('nombre_aom1','varchar');
        $this->captura('descrip_aom1','text');
        $this->captura('nro_tramite_wf','varchar');
        $this->captura('desc_funcionario1','text');

        $this->armarConsulta();
        $this->ejecutarConsulta();
        // var_dump($this->respuesta);exit;
        return $this->respuesta;
    }



	/****************  Inicio ***********************/
	function getListUO(){
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_AOMX1_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');
        $this->captura('codigo','varchar');
        $this->captura('nivel_organizacional','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
	    //return "";
    }
    function getListFuncionario(){
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_AOMX2_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_persona','int4');
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','text');
        $this->captura('desc_funcionario2','text');
        $this->captura('nombre_cargo','varchar');
        $this->captura('descripcion_cargo','varchar');
        $this->captura('cargo_codigo','varchar');
        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
        //return "";
    }

    function getListAuditores(){
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_ADPTO_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('codigo','codigo','varchar');
        $this->setParametro('id_uo','id_uo','int4');
        //Definicion de la lista del resultado del query

        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','text');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function getLastAuditRecord(){
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_AOMX3_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_aom','int4');
        $this->captura('codigo_aom','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function updateSummary(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
        $this->transaccion='SSOM_AOMSR_MOD';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_aom','id_aom','int4');
        $this->setParametro('recomendacion','recomendacion','text');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function siguienteEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_auditoria_oportunidad_mejora_ime';
        $this->transaccion = 'SSOM_WFNEXT_INS';
        $this->tipo_procedimiento = 'IME';

        $this->setParametro('id_proceso_wf_act','id_proceso_wf_act','int4');
        $this->setParametro('id_estado_wf_act','id_estado_wf_act','int4');
        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('id_tipo_estado','id_tipo_estado','int4');
        $this->setParametro('id_funcionario_wf','id_funcionario_wf','int4');
        $this->setParametro('id_depto_wf','id_depto_wf','int4');
        $this->setParametro('obs','obs','text');
        $this->setParametro('json_procesos','json_procesos','text');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function anteriorEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
        $this->transaccion='SSOM_WFBACK_IME';
        $this->tipo_procedimiento='IME';
        //Define los parametros para la funcion
        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->setParametro('obs','obs','varchar');
        $this->setParametro('estado_destino','estado_destino','varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function getListStatusAudit(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_AUDSTATUS_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        //$this->setCount(false);

        /*$this->setParametro('p_fecha_de','p_fecha_de','date');
        $this->setParametro('p_fecha_hasta','p_fecha_hasta','date');
        $this->setParametro('p_estado','p_estado','varchar');
        $this->setParametro('p_id_unidad','p_id_unidad','int4');
        $this->setParametro('p_unidad','p_unidad','varchar');*/
        $this->setParametro('p_codigo_aom','p_codigo_aom','varchar');
        //var_dump($this->objParam);exit;
        //te.id_tipo_estado, te.id_tipo_proceso, te.codigo, te.nombre_estado, te.estado_reg

        //Definicion de la lista del resultado del query
        $this->captura('id_tipo_estado','int4');
        $this->captura('id_tipo_proceso','int4');
        $this->captura('codigo','varchar');
        $this->captura('nombre_estado','varchar');
        $this->captura('estado_reg','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function verificarInforme(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_ime';
        $this->transaccion='SSOM_ANEXT_MOD';
        $this->tipo_procedimiento='IME';//tipo de transaccion
        $this->setCount(false);

        $this->setParametro('p_id_aom','p_id_aom','int4');
        $this->setParametro('p_id_funcionario','p_id_funcionario','int4');
        $this->setParametro('p_lugar','p_lugar','varchar');
        $this->setParametro('p_id_tnorma','p_id_tnorma','varchar');
        $this->setParametro('p_id_tobjeto','p_id_tobjeto','varchar');
        $this->setParametro('p_fecha_eje_inicio','p_fecha_eje_inicio','date');
        $this->setParametro('p_fecha_eje_fin','p_fecha_eje_fin','date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
    /*****************  Fin ************************/
    /*
     * Inicio de Reportes
     * **/
    function reportAuditPDF(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_RPTA1_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        $this->setParametro('p_fecha_de','p_fecha_de','date');
        $this->setParametro('p_fecha_hasta','p_fecha_hasta','date');
        $this->setParametro('p_estado','p_estado','varchar');
        $this->setParametro('p_desc_estado','p_desc_estado','varchar');
        $this->setParametro('p_id_unidad','p_id_unidad','int4');
        $this->setParametro('p_unidad','p_unidad','varchar');

        //Definicion de la lista del resultado del query
        $this->captura('id_aom','int4');
        $this->captura('codigo_aom','varchar');
        $this->captura('nro_tramite_wf','varchar');
        $this->captura('id_tipo_auditoria','int4');
        $this->captura('tipo_auditoria','varchar');
        $this->captura('codigo_tpo_aom','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('descrip_aom1','text');

        $this->captura('id_tnorma','varchar');
        $this->captura('tipo_ctrl_auditoria','varchar');

        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');
        $this->captura('fecha_prog_inicio','date');
        $this->captura('fecha_prog_fin','date');
        $this->captura('id_tipo_om','int4');
        $this->captura('valor_tipo_om','varchar');
        $this->captura('estado_wf','varchar');
        $this->captura('nombre_estado','varchar');
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','varchar');

        /*$this->captura('id_gconsultivo','int4');
        $this->captura('nombre_gconsultivo','varchar');*/

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function reportAuditXLS(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_RPTA1_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        $this->setParametro('p_fecha_de','p_fecha_de','date');
        $this->setParametro('p_fecha_hasta','p_fecha_hasta','date');
        $this->setParametro('p_estado','p_estado','varchar');
        $this->setParametro('p_desc_estado','p_desc_estado','varchar');
        $this->setParametro('p_id_unidad','p_id_unidad','int4');
        $this->setParametro('p_unidad','p_unidad','varchar');

        //Definicion de la lista del resultado del query
        $this->captura('id_aom','int4');
        $this->captura('codigo_aom','varchar');
        $this->captura('nro_tramite_wf','varchar');
        $this->captura('id_tipo_auditoria','int4');
        $this->captura('tipo_auditoria','varchar');
        $this->captura('codigo_tpo_aom','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('descrip_aom1','text');

        $this->captura('id_tnorma','varchar');
        $this->captura('tipo_ctrl_auditoria','varchar');

        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');
        $this->captura('fecha_prog_inicio','date');
        $this->captura('fecha_prog_fin','date');
        $this->captura('id_tipo_om','int4');
        $this->captura('valor_tipo_om','varchar');
        $this->captura('estado_wf','varchar');
        $this->captura('nombre_estado','varchar');
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','varchar');

        /*$this->captura('id_gconsultivo','int4');
        $this->captura('nombre_gconsultivo','varchar');*/

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function reporteOM(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_auditoria_oportunidad_mejora_sel';
        $this->transaccion='SSOM_RPTOM_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        $this->setParametro('p_fecha_de','p_fecha_de','date');
        $this->setParametro('p_fecha_hasta','p_fecha_hasta','date');
        $this->setParametro('p_estado','p_estado','varchar');
        $this->setParametro('p_desc_estado','p_desc_estado','varchar');
        $this->setParametro('p_id_unidad','p_id_unidad','int4');
        $this->setParametro('p_unidad','p_unidad','varchar');
        $this->setParametro('p_id_gconsultivo','p_id_gconsultivo','int4');

        //Definicion de la lista del resultado del query
        $this->captura('id_aom','int4');
        $this->captura('codigo_aom','varchar');
        $this->captura('nro_tramite_wf','varchar');
        $this->captura('id_tipo_auditoria','int4');
        $this->captura('tipo_auditoria','varchar');
        $this->captura('codigo_tpo_aom','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('descrip_aom1','text');

        $this->captura('id_tnorma','varchar');
        $this->captura('tipo_ctrl_auditoria','varchar');

        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');
        $this->captura('fecha_prog_inicio','date');
        $this->captura('fecha_prog_fin','date');
        $this->captura('id_tipo_om','int4');
        $this->captura('valor_tipo_om','varchar');
        $this->captura('estado_wf','varchar');
        $this->captura('nombre_estado','varchar');
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario1','varchar');

        $this->captura('id_gconsultivo','int4');
        $this->captura('nombre_gconsultivo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
}
?>