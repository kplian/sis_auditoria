<?php
/**
*@package pXP
*@file gen-ACTImpacto.php
*@author  (max.camacho)
*@date 16-12-2019 18:31:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 18:31:26								CREACION

*/

class ACTImpacto extends ACTbase{    
			
	function listarImpacto(){
		$this->objParam->defecto('ordenacion','id_impacto');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODImpacto','listarImpacto');
		} else{
			$this->objFunc=$this->create('MODImpacto');
			
			$this->res=$this->objFunc->listarImpacto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarImpacto(){
		$this->objFunc=$this->create('MODImpacto');	
		if($this->objParam->insertar('id_impacto')){
			$this->res=$this->objFunc->insertarImpacto($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarImpacto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarImpacto(){
			$this->objFunc=$this->create('MODImpacto');	
		$this->res=$this->objFunc->eliminarImpacto($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>