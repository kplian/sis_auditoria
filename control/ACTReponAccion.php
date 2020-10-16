<?php
/**
*@package pXP
*@file gen-ACTReponAccion.php
*@author  (admin.miguel)
*@date 06-10-2020 15:21:07
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				06-10-2020 15:21:07								CREACION

*/

class ACTReponAccion extends ACTbase{    
			
	function listarReponAccion(){
		$this->objParam->defecto('ordenacion','id_repon_accion');
		$this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('id_ap')!=''){
            $this->objParam->addFiltro("ran.id_ap = ".$this->objParam->getParametro('id_ap'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODReponAccion','listarReponAccion');
		} else{
			$this->objFunc=$this->create('MODReponAccion');
			
			$this->res=$this->objFunc->listarReponAccion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarReponAccion(){
		$this->objFunc=$this->create('MODReponAccion');	
		if($this->objParam->insertar('id_repon_accion')){
			$this->res=$this->objFunc->insertarReponAccion($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarReponAccion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarReponAccion(){
			$this->objFunc=$this->create('MODReponAccion');	
		$this->res=$this->objFunc->eliminarReponAccion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>