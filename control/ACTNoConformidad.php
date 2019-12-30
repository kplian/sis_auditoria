<?php
/**
*@package pXP
*@file gen-ACTNoConformidad.php
*@author  (szambrana)
*@date 04-07-2019 19:53:16
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../reportes/RNoConformidades.php');

class ACTNoConformidad extends ACTbase{    
			
	function listarNoConformidad(){
		$this->objParam->defecto('ordenacion','id_nc');

		$this->objParam->defecto('dir_ordenacion','asc');
        //*** Metodo que filtra acorde al id del padre (Max)
        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("noconf.id_aom = ".$this->objParam->getParametro('id_aom'));
        }// Fin***** (Max)
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODNoConformidad','listarNoConformidad');
		} else{
			$this->objFunc=$this->create('MODNoConformidad');
			
			$this->res=$this->objFunc->listarNoConformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarNoConformidad(){
		$this->objFunc=$this->create('MODNoConformidad');	
		if($this->objParam->insertar('id_nc')){
			$this->res=$this->objFunc->insertarNoConformidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarNoConformidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarNoConformidad(){
			$this->objFunc=$this->create('MODNoConformidad');	
		$this->res=$this->objFunc->eliminarNoConformidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	//Devuelve al Gerente de Area 
    function listarRespAreaGerente(){
        
		$this->objFunc=$this->create('MODNoConformidad');	
		$this->res=$this->objFunc->listarRespAreaGerente($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarSomUsuario(){
        $this->objParam->defecto('ordenacion','id_funcionario');

        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODNoConformidad');

        $this->res=$this->objFunc->listarSomUsuario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	
    function siguienteEstado(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	
    function anteriorEstado(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteNoConforPDF(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->reporteNoConforPDF($this->objParam);

        //obtener titulo del reporte
        $titulo = 'No comformidad';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo=uniqid(md5(session_id()).$titulo);
        $nombreArchivo.='.pdf';
        $this->objParam->addParametro('orientacion','P');
        $this->objParam->addParametro('tamano','LETTER');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        //Instancia la clase de pdf

        $this->objReporteFormato=new RNoConformidades($this->objParam);
        $this->objReporteFormato->setDatos($this->res->datos);
        $this->objReporteFormato->generarReporte();
        $this->objReporteFormato->output($this->objReporteFormato->url_archivo,'F');


        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado',
            'Se generó con éxito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
    
	function listarFuncionariosUO(){
		$this->objParam->defecto('ordenacion','id_nc');

		$this->objParam->defecto('dir_ordenacion','asc');
            /// var_dump($this->objParam->getParametro('id_uo'));exit;
		$this->objFunc=$this->create('MODNoConformidad');
		$this->res=$this->objFunc->listarFuncionariosUO($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}    
	
	function asignarFuncRespNC(){
		$this->objFunc=$this->create('MODNoConformidad');	
		$this->res=$this->objFunc->asignarFuncRespNC($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

    function sigueienteGrupo(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->sigueienteGrupo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}

?>