<?php
/**
*@package pXP
*@file gen-ACTParametroConfigAuditoria.php
*@author  (max.camacho)
*@date 20-08-2019 16:16:47
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTParametroConfigAuditoria extends ACTbase{    
			
	function listarParametroConfigAuditoria(){
		$this->objParam->defecto('ordenacion','id_param_config_aom');

		$this->objParam->defecto('dir_ordenacion','asc');

        //************SSSS
        //var_dump(param_estado_config);
        //var_dump('Hola parametro',$this->objParam->getParametro('param_estado_config'));


		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODParametroConfigAuditoria','listarParametroConfigAuditoria');
		} else{
			$this->objFunc=$this->create('MODParametroConfigAuditoria');
			
			$this->res=$this->objFunc->listarParametroConfigAuditoria($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarParametroConfigAuditoria(){
		$this->objFunc=$this->create('MODParametroConfigAuditoria');	
		if($this->objParam->insertar('id_param_config_aom')){
			$this->res=$this->objFunc->insertarParametroConfigAuditoria($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarParametroConfigAuditoria($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarParametroConfigAuditoria(){
			$this->objFunc=$this->create('MODParametroConfigAuditoria');	
		$this->res=$this->objFunc->eliminarParametroConfigAuditoria($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>