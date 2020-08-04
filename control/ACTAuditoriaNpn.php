<?php
/**
*@package pXP
*@file gen-ACTAuditoriaNpn.php
*@author  (max.camacho)
*@date 25-07-2019 21:19:37
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAuditoriaNpn extends ACTbase{

	function listarAuditoriaNpn(){
		$this->objParam->defecto('ordenacion','id_anpn');
		$this->objParam->defecto('dir_ordenacion','asc');

    if($this->objParam->getParametro('id_aom')!=''){
        $this->objParam->addFiltro("anpn.id_aom = ".$this->objParam->getParametro('id_aom'));
    }
		if($this->objParam->getParametro('id_norma')!=''){
        $this->objParam->addFiltro("anpn.id_norma = ".$this->objParam->getParametro('id_norma'));
    }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAuditoriaNpn','listarAuditoriaNpn');
		} else{
			$this->objFunc=$this->create('MODAuditoriaNpn');

			$this->res=$this->objFunc->listarAuditoriaNpn($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarAuditoriaNpn(){
		$this->objFunc=$this->create('MODAuditoriaNpn');
		if($this->objParam->insertar('id_anpn')){
			$this->res=$this->objFunc->insertarAuditoriaNpn($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarAuditoriaNpn($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarAuditoriaNpn(){
		$this->objFunc=$this->create('MODAuditoriaNpn');
		$this->res=$this->objFunc->eliminarAuditoriaNpn($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	  function insertarItemAuditoriaNpn(){
		$this->objFunc=$this->create('MODAuditoriaNpn');
		$this->res=$this->objFunc->insertarItemAuditoriaNpn($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

}

?>
