<?php
/**
*@package pXP
*@file gen-ACTAuditoriaProceso.php
*@author  (max.camacho)
*@date 25-07-2019 15:51:56
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAuditoriaProceso extends ACTbase{

	function listarAuditoriaProceso(){
		$this->objParam->defecto('ordenacion','id_aproceso');
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("aupc.id_aom = ".$this->objParam->getParametro('id_aom'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAuditoriaProceso','listarAuditoriaProceso');
		} else{
			$this->objFunc=$this->create('MODAuditoriaProceso');
			$this->res=$this->objFunc->listarAuditoriaProceso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function insertarAuditoriaProceso(){
		$this->objFunc=$this->create('MODAuditoriaProceso');
		if($this->objParam->insertar('id_aproceso')){
			$this->res=$this->objFunc->insertarAuditoriaProceso($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarAuditoriaProceso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarAuditoriaProceso(){
        $this->objFunc=$this->create('MODAuditoriaProceso');
		$this->res=$this->objFunc->eliminarAuditoriaProceso($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function itemSelectionAuditoriaProceso(){
		$this->objFunc=$this->create('MODAuditoriaProceso');
		$this->res=$this->objFunc->itemSelectionAuditoriaProceso($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
}

?>
