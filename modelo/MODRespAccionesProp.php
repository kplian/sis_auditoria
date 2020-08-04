<?php
/**
*@package pXP
*@file gen-MODRespAccionesProp.php
*@author  (szambrana)
*@date 17-09-2019 14:35:45
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODRespAccionesProp extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarRespAccionesProp(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_resp_acciones_prop_sel';
		$this->transaccion='SSOM_RESAP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_respap','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_ap','int4');
		$this->captura('id_funcionario','int4');
		//$this->captura('descrip_func','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_funcionario1','text');
        $this->captura('id_nc','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarRespAccionesProp(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_resp_acciones_prop_ime';
		$this->transaccion='SSOM_RESAP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_ap','id_ap','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		//$this->setParametro('descrip_func','descrip_func','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarRespAccionesProp(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_resp_acciones_prop_ime';
		$this->transaccion='SSOM_RESAP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_respap','id_respap','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_ap','id_ap','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		//$this->setParametro('descrip_func','descrip_func','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarRespAccionesProp(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_resp_acciones_prop_ime';
		$this->transaccion='SSOM_RESAP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_respap','id_respap','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
		//**********SSS editar esta funcion
	function listarRsinUsuario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_resp_sist_integrados_sel';
        $this->transaccion='SSOM_USUSI_SEL';
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
    function insertarItemRespAccionesProp(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_resp_acciones_prop_ime';
        $this->transaccion='SSOM_REAF_INS';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_nc','id_nc','int4');
        $this->setParametro('id_res_funcionarios','id_res_funcionarios','text');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
			
}
?>