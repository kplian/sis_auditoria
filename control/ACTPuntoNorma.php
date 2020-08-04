<?php
/**
*@package pXP
*@file gen-ACTPuntoNorma.php
*@author  (szambrana)
*@date 01-07-2019 18:45:10
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPuntoNorma extends ACTbase{

	function listarPuntoNorma(){
		$this->objParam->defecto('ordenacion','id_pn');
		$this->objParam->defecto('dir_ordenacion','asc');
		//*************SSS
        if($this->objParam->getParametro('id_norma')!=''){
            $this->objParam->addFiltro("ptonor.id_norma = ".$this->objParam->getParametro('id_norma'));
        }
		//**************
        //*************filtro combo
        if($this->objParam->getParametro('id_norma')!=''){
            $this->objParam->addFiltro("ptonor.id_norma = ".$this->objParam->getParametro('id_norma'));
        }
        //**************
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPuntoNorma','listarPuntoNorma');
		}else{
			$this->objFunc=$this->create('MODPuntoNorma');

			$this->res=$this->objFunc->listarPuntoNorma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarPuntoNorma(){
		$this->objFunc=$this->create('MODPuntoNorma');
		if($this->objParam->insertar('id_pn')){
			$this->res=$this->objFunc->insertarPuntoNorma($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarPuntoNorma($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarPuntoNorma(){
			$this->objFunc=$this->create('MODPuntoNorma');
		$this->res=$this->objFunc->eliminarPuntoNorma($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}


	function listarPuntoNormaMulti(){
		$this->objParam->defecto('ordenacion','id_pn');
		$this->objParam->defecto('dir_ordenacion','asc');

    if($this->objParam->getParametro('id_norma')!=''){
        $this->objParam->addFiltro("ptonor.id_norma = ".$this->objParam->getParametro('id_norma'));
    }

		if($this->objParam->getParametro('fill')!=''){
			  $this->objParam->addFiltro("ptonor.id_norma = ".$this->objParam->getParametro('id_norma'));
			  $this->objParam->addFiltro("ptonor.id_pn not in (select pnnc.id_pn
                                                    from ssom.tpnorma_noconformidad pnnc
                                                    where pnnc.id_nc = ".$this->objParam->getParametro('id_nc')." and pnnc.id_norma = ".$this->objParam->getParametro('id_norma')." )");
		}

		if($this->objParam->getParametro('item') != ''){
        $this->objParam->addFiltro("ptonor.id_pn not  in (select anpn.id_pn
					                                                from ssom.tauditoria_npn anpn
					                                                where anpn.id_aom = ".$this->objParam->getParametro('item') .")");
    }
		$this->objFunc=$this->create('MODPuntoNorma');
		$this->res=$this->objFunc->listarPuntoNormaMulti($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}


}

?>
