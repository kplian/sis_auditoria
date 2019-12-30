<?php
/**
*@package pXP
*@file gen-ACTOportunidadMejora.php
*@author  (max.camacho)
*@date 27-06-2019 22:05:51
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTOportunidadMejora extends ACTbase{    
			
	function listarOportunidadMejora(){
		$this->objParam->defecto('ordenacion','id_om');

		$this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('id_tipo_auditoria') != '') {
            $this->objParam->addFiltro("exm.id_tipo_auditoria = " . $this->objParam->getParametro('id_tipo_auditoria'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODOportunidadMejora','listarOportunidadMejora');
		} else{
			$this->objFunc=$this->create('MODOportunidadMejora');
			
			$this->res=$this->objFunc->listarOportunidadMejora($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarOportunidadMejora(){
		$this->objFunc=$this->create('MODOportunidadMejora');	
		if($this->objParam->insertar('id_om')){
			$this->res=$this->objFunc->insertarOportunidadMejora($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarOportunidadMejora($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarOportunidadMejora(){
			$this->objFunc=$this->create('MODOportunidadMejora');	
		$this->res=$this->objFunc->eliminarOportunidadMejora($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>