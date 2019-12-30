<?php
/**
*@package pXP
*@file gen-ACTDestinatario.php
*@author  (max.camacho)
*@date 10-09-2019 23:09:14
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDestinatario extends ACTbase{    
			
	function listarDestinatario(){
		$this->objParam->defecto('ordenacion','id_destinatario_aom');

		$this->objParam->defecto('dir_ordenacion','asc');
       
        //var_dump("vakdsfhglskdhlgks",$this->objParam->getParametro('v_id_aom'),$this->objParam->getParametro('v_codigo_parametro'));exit;
		if($this->objParam->getParametro('v_id_aom')!='' && $this->objParam->getParametro('v_codigo_parametro')!=''){
            $this->objParam->addFiltro("dest.id_aom = ".$this->objParam->getParametro('v_id_aom')." and "."para.codigo_parametro = ''".$this->objParam->getParametro('v_codigo_parametro')."''");
        }

        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("dest.id_aom = ".$this->objParam->getParametro('id_aom'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDestinatario','listarDestinatario');
		} else{
			$this->objFunc=$this->create('MODDestinatario');
			
			$this->res=$this->objFunc->listarDestinatario($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDestinatario(){
		$this->objFunc=$this->create('MODDestinatario');
		
		if($this->objParam->insertar('id_destinatario_aom')){
			$this->res=$this->objFunc->insertarDestinatario($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDestinatario($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDestinatario(){
			$this->objFunc=$this->create('MODDestinatario');	
		$this->res=$this->objFunc->eliminarDestinatario($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>