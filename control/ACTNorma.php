<?php
/**
*@package pXP
*@file ACTNorma.php
*@author  (szambrana)
*@date 02-07-2019 19:11:48
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTNorma extends ACTbase{    
			
	function listarNorma(){
		$this->objParam->defecto('ordenacion','id_norma');

		$this->objParam->defecto('dir_ordenacion','asc');

        //var_dump($this->objParam->getParametro('id_parametro').", ".$this->objParam->getParametro('codigo_parametro')); exit;
        //var_dump($this->objParam->getParametro('id_parametro')); exit;
        if($this->objParam->getParametro('id_parametro')!=''){
            //var_dump($this->objParam->getParametro('id_tipo_norma')); exit;
            $this->objParam->addFiltro("nor.id_parametro = ".$this->objParam->getParametro('id_parametro'));
        }// Fin*****

        if($this->objParam->getParametro('p_codigo_parametro')!=''){
			//var_dump('entra '.$this->objParam->getParametro('p_codigo_parametro')); exit;
            if($this->objParam->getParametro('p_codigo_parametro')!='INTEG'){
                $this->objParam->addFiltro("nor.id_parametro = ".$this->objParam->getParametro('p_id_parametro'));
            }
        }// Fin*****

		if($this->objParam->getParametro('id_norma')!=''){
            $this->objParam->addFiltro("nor.id_norma = ".$this->objParam->getParametro('id_norma'));
        }// Fin*****

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODNorma','listarNorma');
		} else{
			$this->objFunc=$this->create('MODNorma');
			
			$this->res=$this->objFunc->listarNorma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarNorma(){
		$this->objFunc=$this->create('MODNorma');	
		if($this->objParam->insertar('id_norma')){
			$this->res=$this->objFunc->insertarNorma($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarNorma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarNorma(){
			$this->objFunc=$this->create('MODNorma');	
		$this->res=$this->objFunc->eliminarNorma($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>