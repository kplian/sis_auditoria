<?php
/**
*@package pXP
*@file gen-ACTTipoAuditoria.php
*@author  (max.camacho)
*@date 17-07-2019 13:23:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoAuditoria extends ACTbase{    
			
	function listarTipoAuditoria(){
		$this->objParam->defecto('ordenacion','id_tipo_auditoria');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoAuditoria','listarTipoAuditoria');
		} else{
			$this->objFunc=$this->create('MODTipoAuditoria');
			
			$this->res=$this->objFunc->listarTipoAuditoria($this->objParam);
		}
        if($this->objParam->getParametro('_adicionar')!=''){

            $respuesta = $this->res->getDatos();

            array_unshift ( $respuesta, array(  'id_tipo_auditoria'=>'0',
                'descrip_tauditoria'=>'Todos',
                'estado_reg'=>'Todos',
                'tipo_auditoria'=>'Todos',
                'codigo_tpo_aom'=>'Todos'

            ));
            $this->res->setDatos($respuesta);
        }
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function insertarTipoAuditoria(){
		$this->objFunc=$this->create('MODTipoAuditoria');	
		if($this->objParam->insertar('id_tipo_auditoria')){
			$this->res=$this->objFunc->insertarTipoAuditoria($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoAuditoria($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoAuditoria(){
			$this->objFunc=$this->create('MODTipoAuditoria');	
		$this->res=$this->objFunc->eliminarTipoAuditoria($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>