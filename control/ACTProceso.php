<?php
/**
*@package pXP
*@file gen-ACTProceso.php
*@author  (max.camacho)
*@date 15-07-2019 20:16:48
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTProceso extends ACTbase{

	function listarProceso(){
		$this->objParam->defecto('ordenacion','id_proceso');
		$this->objParam->defecto('dir_ordenacion','asc');

		if ($this->objParam->getParametro('proceso') != '') {
			$this->objParam->addFiltro("((pcs.proceso::varchar ILIKE ''%".$this->objParam->getParametro('proceso')."%'') or
                                    to_tsvector(pcs.proceso::varchar) @@ plainto_tsquery(''spanish'', ''".$this->objParam->getParametro('proceso')."''))");
		}
		if($this->objParam->getParametro('item') != ''){
				$this->objParam->addFiltro("pcs.id_proceso not in ( select aupc.id_proceso
										   from ssom.tauditoria_proceso aupc
										   where aupc.id_aom = ".$this->objParam->getParametro('item').") and pcs.vigencia = ''Si'' ");
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODProceso','listarProceso');
		} else{
			$this->objFunc=$this->create('MODProceso');
			$this->res=$this->objFunc->listarProceso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarProceso(){
		$this->objFunc=$this->create('MODProceso');
		if($this->objParam->insertar('id_proceso')){
			$this->res=$this->objFunc->insertarProceso($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarProceso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarProceso(){
			$this->objFunc=$this->create('MODProceso');
		$this->res=$this->objFunc->eliminarProceso($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
}

?>
