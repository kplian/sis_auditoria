<?php
/**
*@package pXP
*@file gen-ACTGrupoConsultivo.php
*@author  (max.camacho)
*@date 22-07-2019 23:01:14
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTGrupoConsultivo extends ACTbase{    
			
	function listarGrupoConsultivo(){
		$this->objParam->defecto('ordenacion','id_gconsultivo');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODGrupoConsultivo','listarGrupoConsultivo');
		} else{
			$this->objFunc=$this->create('MODGrupoConsultivo');
			
			$this->res=$this->objFunc->listarGrupoConsultivo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarGrupoConsultivo(){
		$this->objFunc=$this->create('MODGrupoConsultivo');	
		if($this->objParam->insertar('id_gconsultivo')){
			$this->res=$this->objFunc->insertarGrupoConsultivo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarGrupoConsultivo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarGrupoConsultivo(){
			$this->objFunc=$this->create('MODGrupoConsultivo');	
		$this->res=$this->objFunc->eliminarGrupoConsultivo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function getListEmpresa(){
	    $this->objParam->defecto('ordenacion','id_empresa');
	    $this->objParam->defecto('dir_ordenacion', 'asc') ;

	    $this->objFunc=$this->create('MODGrupoConsultivo');
	    $this->res=$this->objFunc->getListEmpresa($this->objParam);

	    $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>