<?php
/**
*@package pXP
*@file gen-ACTCronogramaEquipoResponsable.php
*@author  (max.camacho)
*@date 12-12-2019 20:16:51
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019 20:16:51								CREACION

*/

class ACTCronogramaEquipoResponsable extends ACTbase{    
			
	function listarCronogramaEquipoResponsable(){
		$this->objParam->defecto('ordenacion','id_cronog_eq_resp');

		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_cronograma')!=''){
            //echo 'entra..1';
            $this->objParam->addFiltro("crer.id_cronograma = ".$this->objParam->getParametro('id_cronograma'));
        }// Fin*****

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCronogramaEquipoResponsable','listarCronogramaEquipoResponsable');
		} else{
			$this->objFunc=$this->create('MODCronogramaEquipoResponsable');
			
			$this->res=$this->objFunc->listarCronogramaEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCronogramaEquipoResponsable(){
		$this->objFunc=$this->create('MODCronogramaEquipoResponsable');	
		if($this->objParam->insertar('id_cronog_eq_resp')){
			$this->res=$this->objFunc->insertarCronogramaEquipoResponsable($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCronogramaEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCronogramaEquipoResponsable(){
			$this->objFunc=$this->create('MODCronogramaEquipoResponsable');	
		$this->res=$this->objFunc->eliminarCronogramaEquipoResponsable($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>