<?php
/**
*@package pXP
*@file gen-ACTRespSistIntegrados.php
*@author  (szambrana)
*@date 02-08-2019 13:18:19
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRespSistIntegrados extends ACTbase{    
			
	function listarRespSistIntegrados(){
		$this->objParam->defecto('ordenacion','id_respsi');
		$this->objParam->defecto('dir_ordenacion','asc');
		//*******************
		if ($this->objParam->getParametro('id_si')!=''){
			$this->objParam->addFiltro("ressi.id_si = ".$this->objParam->getParametro('id_si'));
		}
		//******************
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRespSistIntegrados','listarRespSistIntegrados');
		} else{
			$this->objFunc=$this->create('MODRespSistIntegrados');
			
			$this->res=$this->objFunc->listarRespSistIntegrados($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRespSistIntegrados(){
		$this->objFunc=$this->create('MODRespSistIntegrados');	
		if($this->objParam->insertar('id_respsi')){
			$this->res=$this->objFunc->insertarRespSistIntegrados($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRespSistIntegrados($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRespSistIntegrados(){
			$this->objFunc=$this->create('MODRespSistIntegrados');	
		$this->res=$this->objFunc->eliminarRespSistIntegrados($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function listarRsinUsuario(){
        $this->objParam->defecto('ordenacion','id_funcionario');

        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODRespSistIntegrados');

        $this->res=$this->objFunc->listarRsinUsuario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>