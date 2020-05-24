<?php
/**
*@package pXP
*@file gen-ACTParametro.php
*@author  (max.camacho)
*@date 03-07-2019 16:18:31
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTParametro extends ACTbase{    
			
	function listarParametro(){
		$this->objParam->defecto('ordenacion','id_parametro');
		$this->objParam->defecto('dir_ordenacion','asc');
		//************SSSS
        if($this->objParam->getParametro('id_tipo_parametro') != '') {
            $this->objParam->addFiltro("prm.id_tipo_parametro = " .$this->objParam->getParametro('id_tipo_parametro'));
        }
        
        if($this->objParam->getParametro('tipo_parametro') != '') {
            if($this->objParam->getParametro('codigo_parametro') != ''){
                $this->objParam->addFiltro("tpp.tipo_parametro = ''" .$this->objParam->getParametro('tipo_parametro')."'' and prm.codigo_parametro not in (".$this->objParam->getParametro('codigo_parametro').")");
            }
            else{
                $this->objParam->addFiltro("tpp.tipo_parametro = ''" .$this->objParam->getParametro('tipo_parametro')."''");
            }

        }
        if($this->objParam->getParametro('tipo_parametro_ed') != '') {
            //var_dump($this->objParam->getParametro('p_codigo_tipo_aom'));exit;
            if($this->objParam->getParametro('p_codigo_tipo_aom_ed') == 'AI'){
                $this->objParam->addFiltro("tpp.tipo_parametro = ''" .$this->objParam->getParametro('tipo_parametro_ed')."'' and prm.codigo_parametro not in (".$this->objParam->getParametro('p_codigo_parametro_ed').")");
            }
            else{
                $this->objParam->addFiltro("tpp.tipo_parametro = ''" .$this->objParam->getParametro('tipo_parametro_ed')."'' and prm.codigo_parametro not in (".$this->objParam->getParametro('p_codigo_parametro_ed').")");
            }

        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODParametro','listarParametro');
		} else{
			$this->objFunc=$this->create('MODParametro');
			
			$this->res=$this->objFunc->listarParametro($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarParametro(){
		$this->objFunc=$this->create('MODParametro');	
		if($this->objParam->insertar('id_parametro')){
			$this->res=$this->objFunc->insertarParametro($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarParametro($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarParametro(){
	    $this->objFunc=$this->create('MODParametro');
		$this->res=$this->objFunc->eliminarParametro($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function getListParametro(){

        $this->objParam->defecto('ordenacion','id_parametro');
        $this->objParam->defecto('dir_ordenacion','asc');
        //************SSS
       // var_dump($this->objParam->getParametro('x'));
        /*if($this->objParam->getParametro('x') != '') {
            $this->objParam->addFiltro("x =''".$this->objParam->getParametro('x')."''");
        }
        if($this->objParam->getParametro('parametro_to') == 'OBJETO_AUDITORIA') {
            $this->objParam->addFiltro("tpp.tipo_parametro =''".$this->objParam->getParametro('parametro_to')."''");
        }*/
        //var_dump('Hola parametro',$this->objParam);
        //************SSS
        $this->objFunc=$this->create('MODParametro');
        $this->res=$this->objFunc->getListParametro($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function getListParametro2(){
        $this->objParam->defecto('ordenacion','id_parametro');
        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODParametro');
        $this->res=$this->objFunc->getListParametro2($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function getListTipoOM(){
        $this->objParam->defecto('ordenacion','id_parametro');
        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODParametro');
        $this->res=$this->objFunc->getListTipoOM($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>