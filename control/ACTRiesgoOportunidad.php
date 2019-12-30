<?php
/**
*@package pXP
*@file gen-ACTRiesgoOportunidad.php
*@author  (max.camacho)
*@date 16-12-2019 17:57:34
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:57:34								CREACION

*/

class ACTRiesgoOportunidad extends ACTbase{    
			
	function listarRiesgoOportunidad(){
		$this->objParam->defecto('ordenacion','id_ro');

		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('p_id_tipo_ro') != '') {
            //var_dump($this->objParam->getParametro('p_id_tipo_ro'));exit;

            $this->objParam->addFiltro("riop.id_tipo_ro = ".$this->objParam->getParametro('p_id_tipo_ro'));

        }

//        if($this->objParam->getParametro('pe_tipo_ro') != '') {
//            //var_dump($this->objParam->getParametro('pe_tipo_ro'));exit;
//            $this->objParam->addFiltro("riop.id_tipo_ro in (select id_tipo_ro from ssom.ttipo_ro where tipo_ro in (".$this->objParam->getParametro('pe_tipo_ro')."))");
//        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRiesgoOportunidad','listarRiesgoOportunidad');
		} else{
			$this->objFunc=$this->create('MODRiesgoOportunidad');
			
			$this->res=$this->objFunc->listarRiesgoOportunidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRiesgoOportunidad(){
		$this->objFunc=$this->create('MODRiesgoOportunidad');	
		if($this->objParam->insertar('id_ro')){
			$this->res=$this->objFunc->insertarRiesgoOportunidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRiesgoOportunidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRiesgoOportunidad(){
			$this->objFunc=$this->create('MODRiesgoOportunidad');	
		$this->res=$this->objFunc->eliminarRiesgoOportunidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>