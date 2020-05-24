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
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODProceso','listarProceso');
		} else{
			$this->objFunc=$this->create('MODProceso');
			
			$this->res=$this->objFunc->listarProceso($this->objParam);
			//var_dump($this->res); exit;

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
	/*************   inicio definicion mas funciones ******************/
	function getListUO(){
        $this->objParam->defecto('ordenacion','id_uo');

        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODProceso');

        $this->res=$this->objFunc->getListUO($this->objParam);
        //var_dump($this->res); exit;

        $this->res->imprimirRespuesta($this->res->generarJson());
	    //return "";
    }
    /*************   fin definicion mas funciones ******************/
			
}

?>