<?php
/**
*@package pXP
*@file gen-ACTProbabilidad.php
*@author  (max.camacho)
*@date 16-12-2019 18:22:42
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 18:22:42								CREACION

*/

class ACTProbabilidad extends ACTbase{    
			
	function listarProbabilidad(){
		$this->objParam->defecto('ordenacion','id_probabilidad');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODProbabilidad','listarProbabilidad');
		} else{
			$this->objFunc=$this->create('MODProbabilidad');
			
			$this->res=$this->objFunc->listarProbabilidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarProbabilidad(){
		$this->objFunc=$this->create('MODProbabilidad');	
		if($this->objParam->insertar('id_probabilidad')){
			$this->res=$this->objFunc->insertarProbabilidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarProbabilidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarProbabilidad(){
			$this->objFunc=$this->create('MODProbabilidad');	
		$this->res=$this->objFunc->eliminarProbabilidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>