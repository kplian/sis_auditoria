<?php
/**
*@package pXP
*@file gen-ACTSiNoconformidad.php
*@author  (szambrana)
*@date 09-08-2019 15:16:47
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSiNoconformidad extends ACTbase{    
			
	function listarSiNoconformidad(){
		$this->objParam->defecto('ordenacion','id_sinc');

		$this->objParam->defecto('dir_ordenacion','asc');
		//********SSS
        if($this->objParam->getParametro('id_nc')!=''){
            $this->objParam->addFiltro("sinoconf.id_nc = ".$this->objParam->getParametro('id_nc'));
        }
        //************
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSiNoconformidad','listarSiNoconformidad');
		} else{
			$this->objFunc=$this->create('MODSiNoconformidad');
			
			$this->res=$this->objFunc->listarSiNoconformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSiNoconformidad(){
		$this->objFunc=$this->create('MODSiNoconformidad');	
		if($this->objParam->insertar('id_sinc')){
			$this->res=$this->objFunc->insertarSiNoconformidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSiNoconformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSiNoconformidad(){
			$this->objFunc=$this->create('MODSiNoconformidad');	
		$this->res=$this->objFunc->eliminarSiNoconformidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>