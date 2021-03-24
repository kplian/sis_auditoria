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


        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("noconf.id_aom = ".$this->objParam->getParametro('id_aom'));
        }
        if($this->objParam->getParametro('id_nc')!=''){
            $this->objParam->addFiltro("noconf.id_nc = ".$this->objParam->getParametro('id_nc'));
        }

        if($this->objParam->getParametro('interfaz') == 'NoConformidadSinAcciones'){
           $this->objParam->addFiltro("noconf.estado_wf in (''consultor'')");
        }
        if($this->objParam->getParametro('interfaz') == 'NoConformidadAccion'){
         /*   $this->objParam->addFiltro("noconf.estado_wf in (''correccion'') and (select count(a.id_ap)
                                                                                    from ssom.taccion_propuesta a
                                                                                        where a.id_nc = noconf.id_nc) > 0 ");*/
        }
 


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
    function insertarItemNoConformidad(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->insertarItemNoConformidad($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function getUo(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->getUo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function aceptarNoConformidad(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->aceptarNoConformidad($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function siTodoNoConformidad(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->siTodoNoConformidad($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function getNoConformidad(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->getNoConformidad($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function aprobarEstado(){
        $this->objFunc=$this->create('MODNoConformidad');
        $this->res=$this->objFunc->aprobarEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarNoConformidadSuper(){
        $this->objParam->defecto('ordenacion','id_nc');
        $this->objParam->defecto('dir_ordenacion','asc');

        if ($this->objParam->getParametro('tipo_interfaz')  == 'NoConformidadSuper'){
              $this->objParam->addFiltro("nof.estado_wf in (''aceptada_resp'',''rechazado_resp'')");
        }
        if($this->objParam->getParametro('id_nc')!=''){
            $this->objParam->addFiltro("nof.id_nc = ".$this->objParam->getParametro('id_nc'));
        }
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODNoConformidad','listarNoConformidadSuper');
        } else{
            $this->objFunc=$this->create('MODNoConformidad');
            $this->res=$this->objFunc->listarNoConformidadSuper($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>