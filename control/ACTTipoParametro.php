<?php
/**
*@package pXP
*@file gen-ACTTipoParametro.php
*@author  (max.camacho)
*@date 03-07-2019 13:09:09
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoParametro extends ACTbase{    
			
	function listarTipoParametro(){
		$this->objParam->defecto('ordenacion','id_tipo_parametro');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoParametro','listarTipoParametro');
		} else{
			$this->objFunc=$this->create('MODTipoParametro');
			
			$this->res=$this->objFunc->listarTipoParametro($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoParametro(){
		$this->objFunc=$this->create('MODTipoParametro');	
		if($this->objParam->insertar('id_tipo_parametro')){
			$this->res=$this->objFunc->insertarTipoParametro($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoParametro($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoParametro(){
			$this->objFunc=$this->create('MODTipoParametro');	
		$this->res=$this->objFunc->eliminarTipoParametro($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>