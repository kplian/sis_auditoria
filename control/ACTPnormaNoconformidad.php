<?php
/**
*@package pXP
*@file gen-ACTPnormaNoconformidad.php
*@author  (szambrana)
*@date 19-07-2019 15:25:54
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPnormaNoconformidad extends ACTbase{

	function listarPnormaNoconformidad(){
		$this->objParam->defecto('ordenacion','id_pnnc');
		$this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('id_nc')!=''){
            $this->objParam->addFiltro("pnnc.id_nc = ".$this->objParam->getParametro('id_nc'));
        }
        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("no.id_aom = ".$this->objParam->getParametro('id_aom'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPnormaNoconformidad','listarPnormaNoconformidad');
		} else{
			$this->objFunc=$this->create('MODPnormaNoconformidad');

			$this->res=$this->objFunc->listarPnormaNoconformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarPnormaNoconformidad(){
		$this->objFunc=$this->create('MODPnormaNoconformidad');
		if($this->objParam->insertar('id_pnnc')){
			$this->res=$this->objFunc->insertarPnormaNoconformidad($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarPnormaNoconformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarPnormaNoconformidad(){
			$this->objFunc=$this->create('MODPnormaNoconformidad');
		$this->res=$this->objFunc->eliminarPnormaNoconformidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

}

?>
