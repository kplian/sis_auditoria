<?php
/**
*@package pXP
*@file gen-ACTAomRiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 20:00:49
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 20:00:49								CREACION

*/

class ACTAomRiesgoOportunidad extends ACTbase{    
			
	function listarAomRiesgoOportunidad(){
		$this->objParam->defecto('ordenacion','id_aom_ro');
		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_aom') != ''){
            $this->objParam->addFiltro("auro.id_aom = ".$this->objParam->getParametro('id_aom'));

        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAomRiesgoOportunidad','listarAomRiesgoOportunidad');
		} else{
			$this->objFunc=$this->create('MODAomRiesgoOportunidad');
			
			$this->res=$this->objFunc->listarAomRiesgoOportunidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAomRiesgoOportunidad(){
		$this->objFunc=$this->create('MODAomRiesgoOportunidad');	
		if($this->objParam->insertar('id_aom_ro')){
			$this->res=$this->objFunc->insertarAomRiesgoOportunidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAomRiesgoOportunidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarAomRiesgoOportunidad(){
			$this->objFunc=$this->create('MODAomRiesgoOportunidad');	
		$this->res=$this->objFunc->eliminarAomRiesgoOportunidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>