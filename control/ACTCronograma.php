<?php
/**
*@package pXP
*@file gen-ACTCronograma.php
*@author  (max.camacho)
*@date 12-12-2019 15:50:53
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019 15:50:53								CREACION

*/

class ACTCronograma extends ACTbase{

	function listarCronograma(){
		$this->objParam->defecto('ordenacion','id_cronograma');

		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("cronog.id_aom = ".$this->objParam->getParametro('id_aom'));
        }// Fin*****
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCronograma','listarCronograma');
		} else{
			$this->objFunc=$this->create('MODCronograma');

			$this->res=$this->objFunc->listarCronograma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarCronograma(){
		$this->objFunc=$this->create('MODCronograma');
		if($this->objParam->insertar('id_cronograma')){
			$this->res=$this->objFunc->insertarCronograma($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarCronograma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarCronograma(){
			$this->objFunc=$this->create('MODCronograma');
		$this->res=$this->objFunc->eliminarCronograma($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function insertarCronogramaRecord(){
        $this->objFunc=$this->create('MODCronograma');
        if($this->objParam->insertar('id_cronograma')){
            $this->res=$this->objFunc->insertarCronogramaRecord($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
		function itemCronograma(){
			$this->objFunc=$this->create('MODCronograma');
			$this->res=$this->objFunc->itemCronograma($this->objParam);
			$this->res->imprimirRespuesta($this->res->generarJson());
		}

}

?>
