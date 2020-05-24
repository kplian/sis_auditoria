<?php
/**
*@package pXP
*@file gen-ACTAuditoriaOportunidadMejora.php
*@author  (max.camacho)
*@date 17-07-2019 17:41:55
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../reportes/RResumen.php');
class ACTAuditoriaOportunidadMejora extends ACTbase{
	function listarAuditoriaOportunidadMejora(){
		$this->objParam->defecto('ordenacion','id_aom');
		$this->objParam->defecto('dir_ordenacion','ASC');
		if($this->objParam->getParametro('pes_estado')== 'pendiente'){
            $this->objParam->addFiltro("aom.estado_wf = ''borrador''");
        }
        if($this->objParam->getParametro('pes_estado')== 'aprobado'){
            $this->objParam->addFiltro("aom.estado_wf = ''programada''");
        }
        if($this->objParam->getParametro('pes_estado')== 'ejecucion'){
            $this->objParam->addFiltro("aom.estado_wf <> ''borrador''");
        }
        if($this->objParam->getParametro('interfaz')== 'PlanificarAuditoria'){
            $this->objParam->addFiltro("aom.estado_wf in (''programada'',''planificacion'')");
        }
        if($this->objParam->getParametro('interfaz')== 'VBPlanificacionAuditoria'){
            $this->objParam->addFiltro("aom.estado_wf = ''vbplanificacion''");
        }
        if($this->objParam->getParametro('interfaz')== 'InformeAuditoria'){
            $this->objParam->addFiltro("aom.estado_wf = ''informe''");
        }
        if($this->objParam->getParametro('interfaz')== 'VBInformeAuditoria'){
            $this->objParam->addFiltro("aom.estado_wf = ''vbinforme''");
        }
        if($this->objParam->getParametro('interfaz')== 'VBAuditoria'){
            $this->objParam->addFiltro("aom.estado_wf = ''aceptado_responsable''");
        }
        if($this->objParam->getParametro('v_tipo_auditoria_nc')!=''){
            $this->objParam->addFiltro("aom.id_tipo_auditoria= ".$this->objParam->getParametro('v_tipo_auditoria_nc')." and aom.estado_wf in (''aceptado_responsable'') ");
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAuditoriaOportunidadMejora','listarAuditoriaOportunidadMejora');
		} else{
			$this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
			
			$this->res=$this->objFunc->listarAuditoriaOportunidadMejora($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function insertarAuditoriaOportunidadMejora(){
		$this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->objParam->addParametro('id_funcionario',$_SESSION["ss_id_funcionario"]);
		if($this->objParam->insertar('id_aom')){
			$this->res=$this->objFunc->insertarAuditoriaOportunidadMejora($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAuditoriaOportunidadMejora($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function eliminarAuditoriaOportunidadMejora(){
	    $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
		$this->res=$this->objFunc->eliminarAuditoriaOportunidadMejora($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function insertSummary(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->updateSummary($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function siguienteEstado(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function anteriorEstado(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function reporteResumen(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reporteResumen($this->objParam);
        $titulo = 'Resumen';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo=uniqid(md5(session_id()).$titulo);
        $nombreArchivo.='.pdf';
        $this->objParam->addParametro('orientacion','P');
        $this->objParam->addParametro('tamano','LETTER');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objReporteFormato=new RResumen($this->objParam);
        $this->objReporteFormato->setDatos($this->res->datos);
        $this->objReporteFormato->generarReporte();
        $this->objReporteFormato->output($this->objReporteFormato->url_archivo,'F');

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado',
            'Se generó con éxito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }







    /*function getListUO(){
        $this->objParam->defecto('ordenacion','id_nivel_organizacional');
        $this->objParam->defecto('dir_ordenacion','asc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListUO($this->objParam);
        if($this->objParam->getParametro('_adicionar')!=''){
            $respuesta = $this->res->getDatos();
            array_unshift ( $respuesta, array(  'id_uo'=>'0',
                'nombre_unidad'=>'Todos',
                'codigo'=>'Todos',
                'nivel_organizacional'=>'Todos'
            ));
            $this->res->setDatos($respuesta);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }*/
    function  getListFuncionarios(){
        $this->objParam->defecto('ordenacion','id_uo');
        $this->objParam->defecto('dir_ordenacion','asc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListUO($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function  getListFuncionario(){
        $this->objParam->defecto('ordenacion','id_funcionario');
        $this->objParam->defecto('dir_ordenacion','asc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListFuncionario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function  getListAuditores(){
        $this->objParam->defecto('ordenacion','id_funcionario');
        $this->objParam->defecto('dir_ordenacion','desc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListAuditores($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function  getLastAuditRecord(){
        $this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','desc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getLastAuditRecord($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function verificarInforme(){
        $this->objParam->addParametro('p_id_funcionario',$_SESSION["ss_id_funcionario"]);
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->verificarInforme($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function getListStatusAudit(){
        $this->objParam->defecto('ordenacion','codigo');
        $this->objParam->defecto('dir_ordenacion','desc');
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListStatusAudit($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarAuditoriaRangoFecha(){
        $this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');
        if($this->objParam->getParametro('p_fecha_de')!='' &&
            $this->objParam->getParametro('p_fecha_hasta')!='' &&
            $this->objParam->getParametro('p_id_uo')!='' ){
            $this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".
                $this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
        }
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->listarAuditoriaRangoFecha($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	function reporteAuditoria() {
        if($this->objParam->getParametro('p_formato_rpt')!='' ){
            if($this->objParam->getParametro('p_formato_rpt')=='pdf'){
                $this->reportAuditPDF();
            }
            else{
                if($this->objParam->getParametro('p_formato_rpt')=='xls'){
                    $this->reportAuditXLS();
                }
            }
        }
    }
    function reportAuditPDF() {
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reportAuditPDF($this->objParam);
        $orientacion = 'L';
        $tamano = 'LETTER';
        $titulo = 'Auditoria';
        $nombreArchivo = uniqid(md5(session_id()).'Reporte').".".$this->objParam->getParametro('p_formato_rpt');
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo',$titulo);
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->reporte = new RPTAuditoriaPDF($this->objParam);
        $this->reporte->setDatos($this->res->datos,$this->objParam->getParametro('p_fecha_de'),$this->objParam->getParametro('p_fecha_hasta'),$this->objParam->getParametro('p_estado'),$this->objParam->getParametro('p_desc_estado'),$this->objParam->getParametro('p_unidad'));
        $this->reporte->generarReporte();
        $this->reporte->output($this->reporte->url_archivo,'F');
        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }
    function reportAuditXLS() {
        $ordenacion = $this->objParam->parametros_consulta['ordenacion'];
        $dir_ordenacion = $this->objParam->parametros_consulta['dir_ordenacion'];
        $puntero  = $this->objParam->parametros_consulta['puntero'];
        $cantidad = $this->objParam->parametros_consulta['cantidad'];
        $filtro = $this->objParam->parametros_consulta['filtro'];

        $this->objParam->parametros_consulta['ordenacion'] = 'id_funcionario';
        $this->objParam->parametros_consulta['dir_ordenacion'] = 'ASC';
        $this->objParam->parametros_consulta['puntero'] = '0';
        $this->objParam->parametros_consulta['cantidad'] = '50';
        $this->objParam->parametros_consulta['filtro']= ' 0=0 ';

        $this->objParam->addFiltro("FUNCIO.id_funcionario = ".$_SESSION["ss_id_funcionario"]);

        $this->objFunSeguridad=$this->create('sis_organigrama/MODFuncionario');
        $this->res=$this->objFunSeguridad->listarFuncionario($this->objParam);
        $datos = $this->res->datos;
        $this->objParam->addParametro('funcionario',$datos);

        $this->objParam->parametros_consulta['ordenacion'] = $ordenacion;
        $this->objParam->parametros_consulta['dir_ordenacion']=$dir_ordenacion;
        $this->objParam->parametros_consulta['puntero'] = $puntero;
        $this->objParam->parametros_consulta['cantidad'] = $cantidad;
        $this->objParam->parametros_consulta['filtro'] = $filtro;
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reportAuditXLS($this->objParam);
        $orientacion = 'L';
        $tamano = 'LETTER';
        $titulo = 'Auditoria';
        $nombreArchivo = uniqid(md5(session_id()).'Reporte').".".$this->objParam->getParametro('p_formato_rpt');
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo',$titulo);
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos',$this->res->datos);
        $this->reporte = new RPTAuditoriaXLS($this->objParam);
        $this->reporte->setDatos($this->res->datos,$this->objParam->getParametro('p_fecha_de'),$this->objParam->getParametro('p_fecha_hasta'),$this->objParam->getParametro('p_estado'),$this->objParam->getParametro('p_desc_estado'),$this->objParam->getParametro('p_unidad'));
        $this->reporte->generarDatos();
        $this->reporte->generarReporte();
        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
    function reporteOportunidadMejora() {
        if($this->objParam->getParametro('p_formato_rpt')!='' ){
            if($this->objParam->getParametro('p_formato_rpt')=='pdf'){
                $this->reporteOMPDF();
            }
            else{
                if($this->objParam->getParametro('p_formato_rpt')=='xls'){
                    $this->reporteOMXLS();
                }
            }
        }
    }
    function reporteOMPDF() {
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reporteOM($this->objParam);
        $orientacion = 'L';
        $tamano = 'LETTER';
        $titulo = 'Auditoria';
        $nombreArchivo = uniqid(md5(session_id()).'Reporte').".".$this->objParam->getParametro('p_formato_rpt');
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo',$titulo);
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);

        $this->reporte = new RPTOportunidadMejoraPDF($this->objParam);
        $this->reporte->setDatos($this->res->datos,$this->objParam->getParametro('p_fecha_de'),$this->objParam->getParametro('p_fecha_hasta'),$this->objParam->getParametro('p_estado'),$this->objParam->getParametro('p_desc_estado'),$this->objParam->getParametro('p_unidad'));
        $this->reporte->generarReporte();
        $this->reporte->output($this->reporte->url_archivo,'F');
        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }
    function reporteOMXLS() {

        //guardamos las los parmetros originales de la consulta
        $ordenacion = $this->objParam->parametros_consulta['ordenacion'];
        $dir_ordenacion = $this->objParam->parametros_consulta['dir_ordenacion'];
        $puntero  = $this->objParam->parametros_consulta['puntero'];
        $cantidad = $this->objParam->parametros_consulta['cantidad'];
        $filtro = $this->objParam->parametros_consulta['filtro'];

        $this->objParam->parametros_consulta['ordenacion'] = 'id_funcionario';
        $this->objParam->parametros_consulta['dir_ordenacion'] = 'ASC';
        $this->objParam->parametros_consulta['puntero'] = '0';
        $this->objParam->parametros_consulta['cantidad'] = '50';
        $this->objParam->parametros_consulta['filtro'] = ' 0=0 ';
        $this->objParam->addFiltro("FUNCIO.id_funcionario = ".$_SESSION["ss_id_funcionario"]);
        $this->objFunSeguridad = $this->create('sis_organigrama/MODFuncionario');
        $this->res = $this->objFunSeguridad->listarFuncionario($this->objParam);
        $datos = $this->res->datos;
        $this->objParam->addParametro('funcionario',$datos);
        $this->objParam->parametros_consulta['ordenacion'] = $ordenacion;
        $this->objParam->parametros_consulta['dir_ordenacion']=$dir_ordenacion;
        $this->objParam->parametros_consulta['puntero'] = $puntero;
        $this->objParam->parametros_consulta['cantidad'] = $cantidad;
        $this->objParam->parametros_consulta['filtro'] = $filtro;
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reporteOM($this->objParam);
        $orientacion = 'L';
        $tamano = 'LETTER';
        $titulo = 'Auditoria';
        $nombreArchivo = uniqid(md5(session_id()).'Reporte').".".$this->objParam->getParametro('p_formato_rpt');
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo',$titulo);
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos',$this->res->datos);
        $this->reporte = new RPTOportunidadMejoraXLS($this->objParam);
        $this->reporte->setDatos($this->res->datos,$this->objParam->getParametro('p_fecha_de'),$this->objParam->getParametro('p_fecha_hasta'),$this->objParam->getParametro('p_estado'),$this->objParam->getParametro('p_desc_estado'),$this->objParam->getParametro('p_unidad'));
        $this->reporte->generarDatos();
        $this->reporte->generarReporte();
        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
}

?>