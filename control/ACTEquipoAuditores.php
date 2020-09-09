<?php
/**
*@package pXP
*@file gen-ACTEquipoAuditores.php
*@author  (admin.miguel)
*@date 03-09-2020 16:11:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:03								CREACION

*/

class ACTEquipoAuditores extends ACTbase{    
			
	function listarEquipoAuditores(){
		$this->objParam->defecto('ordenacion','id_equipo_auditores');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEquipoAuditores','listarEquipoAuditores');
		} else{
			$this->objFunc=$this->create('MODEquipoAuditores');
			
			$this->res=$this->objFunc->listarEquipoAuditores($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEquipoAuditores(){
		$this->objFunc=$this->create('MODEquipoAuditores');	
		if($this->objParam->insertar('id_equipo_auditores')){
			$this->res=$this->objFunc->insertarEquipoAuditores($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEquipoAuditores($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEquipoAuditores(){
			$this->objFunc=$this->create('MODEquipoAuditores');	
		$this->res=$this->objFunc->eliminarEquipoAuditores($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>