<?php
/**
*@package pXP
*@file gen-ACTTipoRo.php
*@author  (max.camacho)
*@date 16-12-2019 17:36:24
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:36:24								CREACION

*/

class ACTTipoRo extends ACTbase{    
			
	function listarTipoRo(){
		$this->objParam->defecto('ordenacion','id_tipo_ro');

		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('p_tipo_ro') != '') {
            //var_dump($this->objParam->getParametro('p_tipo_ro'));exit;

            $this->objParam->addFiltro("tro.tipo_ro in (".$this->objParam->getParametro('p_tipo_ro').")");

            /*else{
                $this->objParam->addFiltro("tpp.tipo_parametro = ''" .$this->objParam->getParametro('tipo_parametro')."''");
            }*/

        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoRo','listarTipoRo');
		} else{
			$this->objFunc=$this->create('MODTipoRo');
			
			$this->res=$this->objFunc->listarTipoRo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoRo(){
		$this->objFunc=$this->create('MODTipoRo');	
		if($this->objParam->insertar('id_tipo_ro')){
			$this->res=$this->objFunc->insertarTipoRo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoRo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoRo(){
			$this->objFunc=$this->create('MODTipoRo');	
		$this->res=$this->objFunc->eliminarTipoRo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>