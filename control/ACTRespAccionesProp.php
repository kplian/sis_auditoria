<?php
/**
*@package pXP
*@file gen-ACTRespAccionesProp.php
*@author  (szambrana)
*@date 17-09-2019 14:35:45
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRespAccionesProp extends ACTbase{    
			
	function listarRespAccionesProp(){
		$this->objParam->defecto('ordenacion','id_respap');
		$this->objParam->defecto('dir_ordenacion','asc');
		//*******************
		if ($this->objParam->getParametro('id_ap')!=''){
			$this->objParam->addFiltro("resap.id_ap = ".$this->objParam->getParametro('id_ap'));
		}
		//******************		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRespAccionesProp','listarRespAccionesProp');
		} else{
			$this->objFunc=$this->create('MODRespAccionesProp');
			
			$this->res=$this->objFunc->listarRespAccionesProp($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRespAccionesProp(){
		$this->objFunc=$this->create('MODRespAccionesProp');	
		if($this->objParam->insertar('id_respap')){
			$this->res=$this->objFunc->insertarRespAccionesProp($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRespAccionesProp($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRespAccionesProp(){
			$this->objFunc=$this->create('MODRespAccionesProp');	
		$this->res=$this->objFunc->eliminarRespAccionesProp($this->objParam);
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