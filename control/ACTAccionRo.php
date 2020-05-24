<?php
/**
*@package pXP
*@file gen-ACTAccionRo.php
*@author  (max.camacho)
*@date 16-12-2019 19:41:57
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 19:41:57								CREACION

*/

class ACTAccionRo extends ACTbase{    
			
	function listarAccionRo(){
		$this->objParam->defecto('ordenacion','id_accion_ro');
		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_aom_ro')!=''){
            $this->objParam->addFiltro("aro.id_aom_ro = ".$this->objParam->getParametro('id_aom_ro'));
        }
        if($this->objParam->getParametro('p_id_aom_ro')!=''){
            $this->objParam->addFiltro("aro.id_aom_ro = ".$this->objParam->getParametro('p_id_aom_ro'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAccionRo','listarAccionRo');
		} else{
			$this->objFunc=$this->create('MODAccionRo');

			$this->res=$this->objFunc->listarAccionRo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAccionRo(){
		$this->objFunc=$this->create('MODAccionRo');	
		if($this->objParam->insertar('id_accion_ro')){
			$this->res=$this->objFunc->insertarAccionRo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAccionRo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarAccionRo(){
			$this->objFunc=$this->create('MODAccionRo');	
		$this->res=$this->objFunc->eliminarAccionRo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>