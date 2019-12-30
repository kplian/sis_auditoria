<?php
/**
*@package pXP
*@file gen-ACTSistemaIntegrado.php
*@author  (szambrana)
*@date 24-07-2019 21:09:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSistemaIntegrado extends ACTbase{    
			
	function listarSistemaIntegrado(){
		$this->objParam->defecto('ordenacion','id_si');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSistemaIntegrado','listarSistemaIntegrado');
		} else{
			$this->objFunc=$this->create('MODSistemaIntegrado');
			
			$this->res=$this->objFunc->listarSistemaIntegrado($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSistemaIntegrado(){
		$this->objFunc=$this->create('MODSistemaIntegrado');	
		if($this->objParam->insertar('id_si')){
			$this->res=$this->objFunc->insertarSistemaIntegrado($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSistemaIntegrado($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSistemaIntegrado(){
			$this->objFunc=$this->create('MODSistemaIntegrado');	
		$this->res=$this->objFunc->eliminarSistemaIntegrado($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>