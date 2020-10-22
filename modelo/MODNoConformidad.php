<?php
/**
*@package pXP
*@file gen-MODNoConformidad.php
*@author  (szambrana)
*@date 04-07-2019 19:53:16
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODNoConformidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarNoConformidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_no_conformidad_sel';
		$this->transaccion='SSOM_NOCONF_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
				
		$this->setParametro('tipo_interfaz','tipo_interfaz','varchar');
		//Definicion de la lista del resultado del query
		$this->captura('id_nc','int4');
		$this->captura('obs_consultor','text');
		$this->captura('estado_reg','varchar');
		$this->captura('evidencia','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('id_uo','int4');
		$this->captura('descrip_nc','varchar');
		$this->captura('id_parametro','int4');
		$this->captura('obs_resp_area','text');
		$this->captura('id_aom','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');

		//********SSS***********
        $this->captura('id_uo_adicional','int4'); //integrar con wf new
        $this->captura('id_proceso_wf','int4');  //integrar con wf new
        $this->captura('id_estado_wf','int4'); //integrar con wf new
        $this->captura('nro_tramite','varchar'); //integrar con wf new
        $this->captura('estado_wf','varchar');//integrar con wf new

        //****************************
		$this->captura('codigo_nc','varchar');
		$this->captura('id_funcionario_nc','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');

		//*****************************
        $this->captura('nombreaom','text');
        $this->captura('valor_parametro','varchar');
        $this->captura('gerencia_uo1','varchar');
		$this->captura('gerencia_uo2','varchar');
        $this->captura('funcionario_uo','text');   
		$this->captura('contador_estados','int4');
		$this->captura('funcionario_resp_nc','text');

        $this->captura('calidad','bool');
        $this->captura('medio_ambiente','bool');
        $this->captura('seguridad','bool');
        $this->captura('responsabilidad_social','bool');
        $this->captura('sistemas_integrados','bool');

        $this->captura('revisar','varchar');
        $this->captura('rechazar','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('nombre_unidad','varchar');
        $this->captura('desc_funcionario_resp','text');
        $this->captura('nro_tramite_padre','varchar');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarNoConformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_no_conformidad_ime';
		$this->transaccion='SSOM_NOCONF_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('obs_consultor','obs_consultor','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('evidencia','evidencia','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('descrip_nc','descrip_nc','varchar');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('obs_resp_area','obs_resp_area','text');
		$this->setParametro('id_aom','id_aom','int4');
		$this->setParametro('id_uo_adicional','id_uo_adicional','int4');
		$this->setParametro('codigo_nc','codigo_nc','text');	
		$this->setParametro('nro_tramite_padre','nro_tramite_padre','varchar');

        $this->setParametro('calidad','calidad','bool');
        $this->setParametro('medio_ambiente','medio_ambiente','bool');
        $this->setParametro('seguridad','seguridad','bool');
        $this->setParametro('responsabilidad_social','responsabilidad_social','bool');
        $this->setParametro('sistemas_integrados','sistemas_integrados','bool');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarNoConformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_no_conformidad_ime';
		$this->transaccion='SSOM_NOCONF_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_nc','id_nc','int4');
		$this->setParametro('obs_consultor','obs_consultor','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('evidencia','evidencia','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_uo','id_uo','int4');
		$this->setParametro('descrip_nc','descrip_nc','varchar');
		$this->setParametro('id_parametro','id_parametro','int4');
		$this->setParametro('obs_resp_area','obs_resp_area','text');
		$this->setParametro('id_aom','id_aom','int4');
        $this->setParametro('id_uo_adicional','id_uo_adicional','int4');    
		$this->setParametro('codigo_nc','codigo_nc','text');

        $this->setParametro('calidad','calidad','bool');
        $this->setParametro('medio_ambiente','medio_ambiente','bool');
        $this->setParametro('seguridad','seguridad','bool');
        $this->setParametro('responsabilidad_social','responsabilidad_social','bool');
        $this->setParametro('sistemas_integrados','sistemas_integrados','bool');
      //  $this->setParametro('extra','extra','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarNoConformidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_no_conformidad_ime';
		$this->transaccion='SSOM_NOCONF_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_nc','id_nc','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	//***funcion que nos devuelve al gerente de area
	function listarRespAreaGerente(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_REUO_IME';
        $this->tipo_procedimiento='IME';//tipo de transaccion

        //Definicion de la lista del resultado del query
       $this->setParametro('id_uo','id_uo','int4');
 
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
	}
	
    //***funcion que nos devuelve al gerente de area
    function listarFuncionariosUO(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_sel';
        $this->transaccion='SSOM_FUO_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
         $this->setParametro('id_uo','id_uo','int4');
        
        $this->captura('id_funcionario','int4');
        $this->captura('desc_funcionario','text');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        // var_dump($this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
	}
	
	
    //***AQUI INSERTAMOS EL METAPROCESO "SSOM_USU_SEL" IMPLEMENTADO EN LA BASE DE DATOS (SERVIDOR) 
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

    //parametros para cambiar de estado siempre son los mismos parametros
    function siguienteEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_no_conformidad_ime';
        $this->transaccion = 'SSOM_SIGA_IME';
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
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function anteriorEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_no_conformidad_ime';
        $this->transaccion = 'SSOM_ANTE_IME';
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

    function reporteNoConforPDF(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_no_conformidad_sel';
        $this->transaccion = 'SSOM_RPT_NOCONF';
        $this->tipo_procedimiento = 'SEL';
        $this->setCount(false);

        //Define los parametros para la funcion
        $this->setParametro('id_proceso_wf', 'id_proceso_wf', 'int4');

        $this->captura('id_aom','int4');
        $this->captura('id_proceso_wf', 'int4');
        $this->captura('nro_tramite_wf', 'varchar');
        $this->captura('nombre_aom1', 'varchar');
        $this->captura('responsable', 'varchar');
        $this->captura('tipo_norma', 'varchar');
        $this->captura('tipo_objeto', 'varchar');
        $this->captura('valor_parametro', 'varchar');
        $this->captura('descrip_nc', 'varchar');
        $this->captura('evidencia', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

		// var_dump($this->respuesta);exit;
        return $this->respuesta;
    }	
	
    function asignarFuncRespNC(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ssom.ft_no_conformidad_ime';
        $this->transaccion = 'SSOM_RNCUO_IME';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_nc', 'id_nc', 'int4');
		$this->setParametro('id_funcionario_nc', 'id_funcionario_nc', 'int4');
		$this->armarConsulta();
        $this->ejecutarConsulta();
        return $this->respuesta;
	}

    function sigueienteGrupo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_SIAG_IME';
        $this->tipo_procedimiento='IME';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->setParametro('id_aom','id_aom','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function insertarItemNoConformidad(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_INTE_INS';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_aom','id_aom','int4');
        $this->setParametro('nro_tramite_padre','nro_tramite_padre','varchar');
        $this->setParametro('id_parametro','id_parametro','int4');
        $this->setParametro('id_uo','id_uo','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');

        $this->setParametro('calidad','calidad','bool');
        $this->setParametro('medio_ambiente','medio_ambiente','bool');
        $this->setParametro('responsabilidad_social','responsabilidad_social','bool');
        $this->setParametro('seguridad','seguridad','bool');
        $this->setParametro('sistemas_integrados','sistemas_integrados','bool');

        $this->setParametro('descrip_nc','descrip_nc','varchar');
        $this->setParametro('evidencia','evidencia','varchar');
        $this->setParametro('obs_resp_area','obs_resp_area','text');
        $this->setParametro('obs_consultor','obs_consultor','text');

        $this->setParametro('id_norma','id_norma','int4');
       // $this->setParametro('id_pn','id_pn','text');
        $this->setParametro('id_nc','id_nc','int4');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function getUo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_NOGET_IME';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_uo','id_uo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function aceptarNoConformidad(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_RNACE_IME';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_nc','id_nc','int4');
        $this->setParametro('fieldName','fieldName','varchar');
        $this->setParametro('id_funcionario_nc','id_funcionario_nc','int4');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function siTodoNoConformidad(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_NOTOD_IME';
        $this->tipo_procedimiento='IME';
        //Define los parametros para la funcion
        $this->setParametro('id_aom','id_aom','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function getNoConformidad(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_NGET_IME';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_nc','id_nc','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function aprobarEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_no_conformidad_ime';
        $this->transaccion='SSOM_ACES_IME';
        $this->tipo_procedimiento='IME';
        //Define los parametros para la funcion
        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function listarNoConformidadSuper(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ssom.ft_no_conformidad_sel';
        $this->transaccion='SSOM_NOCF_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->captura('id_nc','int4');
        $this->captura('obs_consultor','text');
        $this->captura('estado_reg','varchar');
        $this->captura('evidencia','varchar');
        $this->captura('id_funcionario','int4');
        $this->captura('id_uo','int4');
        $this->captura('descrip_nc','varchar');
        $this->captura('id_parametro','int4');
        $this->captura('obs_resp_area','text');
        $this->captura('id_aom','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_reg','int4');
        $this->captura('id_usuario_ai','int4');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('id_uo_adicional','int4');
        $this->captura('id_proceso_wf','int4');
        $this->captura('id_estado_wf','int4');
        $this->captura('nro_tramite','varchar');
        $this->captura('estado_wf','varchar');
        $this->captura('codigo_nc','varchar');
        $this->captura('id_funcionario_nc','int4');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('nro_tramite_wf','varchar');
        $this->captura('nombre_aom1','varchar');
        $this->captura('valor_parametro','varchar');
        $this->captura('responsable_auditoria','text');
        $this->captura('uo_auditoria','varchar');
        $this->captura('nof_auditoria','varchar');
        $this->captura('auditoria','text');
        $this->captura('funcionario_resp_nof','text');

        $this->captura('calidad','bool');
        $this->captura('medio_ambiente','bool');
        $this->captura('seguridad','bool');
        $this->captura('responsabilidad_social','bool');
        $this->captura('sistemas_integrados','bool');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

}
?>