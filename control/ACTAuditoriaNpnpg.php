<?php
/**
*@package pXP
*@file gen-ACTAuditoriaNpnpg.php
*@author  (max.camacho)
*@date 25-07-2019 21:34:47
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAuditoriaNpnpg extends ACTbase{    
			
	function listarAuditoriaNpnpg(){
		$this->objParam->defecto('ordenacion','id_anpnpg');
		$this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("apnp.id_aom = ".$this->objParam->getParametro('id_aom'));
        }


		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAuditoriaNpnpg','listarAuditoriaNpnpg');
		} else{
			$this->objFunc=$this->create('MODAuditoriaNpnpg');
			
			$this->res=$this->objFunc->listarAuditoriaNpnpg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAuditoriaNpnpg(){
		$this->objFunc=$this->create('MODAuditoriaNpnpg');	
		if($this->objParam->insertar('id_anpnpg')){
			$this->res=$this->objFunc->insertarAuditoriaNpnpg($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAuditoriaNpnpg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarAuditoriaNpnpg(){
			$this->objFunc=$this->create('MODAuditoriaNpnpg');	
		$this->res=$this->objFunc->eliminarAuditoriaNpnpg($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	//function getList
			
}

?>