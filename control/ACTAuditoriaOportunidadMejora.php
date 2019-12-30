<?php
/**
*@package pXP
*@file gen-ACTAuditoriaOportunidadMejora.php
*@author  (max.camacho)
*@date 17-07-2019 17:41:55
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../reportes/RPTAuditoriaPDF.php');
require_once(dirname(__FILE__).'/../reportes/RPTAuditoriaXLS.php');
require_once(dirname(__FILE__).'/../reportes/RPTOportunidadMejoraPDF.php');
require_once(dirname(__FILE__).'/../reportes/RPTOportunidadMejoraXLS.php');

class ACTAuditoriaOportunidadMejora extends ACTbase{    

	function listarAuditoriaOportunidadMejora(){
		$this->objParam->defecto('ordenacion','id_aom');
		$this->objParam->defecto('dir_ordenacion','ASC');

        //** Para filtrar solo a las auditorias por atributo (es_oportunidad=0)
        if($this->objParam->getParametro('v_tipo_auditoria_etapa2')!='' && $this->objParam->getParametro('v_es_oportunidad_etapa2')!=''){
            //var_dump($this->objParam->getParametro('v_tipo_auditoria_etapa2').";".$this->objParam->getParametro('v_es_oportunidad_etapa2'));exit;
            //$es_oportunidad = "(".$this->objParam->getParametro('v_es_oportunidad_etapa2').")";
            //var_dump($es_oportunidad);exit;
            $this->objParam->addFiltro("tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_auditoria_etapa2')."''"." and "."aom.es_oportunidad in (".$this->objParam->getParametro('v_es_oportunidad_etapa2').")");
        }//**** fin ***
        if($this->objParam->getParametro('v_es_oportunidad')!=''){
            $this->objParam->addFiltro("aom.es_oportunidad = ".$this->objParam->getParametro('v_es_oportunidad'));
        }
        if($this->objParam->getParametro('v_tipo_auditoria')!=''){
            //var_dump($this->objParam->getParametro('v_oportunidad'));exit;
            $this->objParam->addFiltro("tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_auditoria')."''");
        }//**** fin ***
        if($this->objParam->getParametro('id_tipo_auditoria')!=''){
            $this->objParam->addFiltro("aom.id_tipo_auditoria = ".$this->objParam->getParametro('id_tipo_auditoria'));
        }
		if($this->objParam->getParametro('v_estado_wf')=='vob_informe'){
					$this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."''".","."''informe_observado"."'')");
        }	
		//PARA CARGAR LAS NO CONFORMIDADES DESDE EL MENU PRINCIPAL
		if($this->objParam->getParametro('v_tipo_auditoria_nc')!=''){
            $this->objParam->addFiltro("aom.id_tipo_auditoria= ".$this->objParam->getParametro('v_tipo_auditoria_nc')." and aom.estado_wf in (''informe'',''vob_informe'') ");
        }
		
        /*=================================================================================================================================================*/

        /* ====== Filter for profile of VBProgramarAuditoria, VBPlanificarAuditoria and VBInformeAuditoria =======*/
        if($this->objParam->getParametro('v_estado_wf')!=''){
            //var_dump($es_oportunidad);exit;
            if($this->objParam->getParametro('v_estado_wf')=='vob_programado'){
                //var_dump("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."''".","."''observado"."'')");
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."''".","."''observado"."'')");
            }
            if($this->objParam->getParametro('v_estado_wf')=='vob_planificacion'){
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."''".","."''plan_observado"."'')");
            }
            if($this->objParam->getParametro('v_estado_wf')=='vob_informe'){
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."''".","."''informe_observado"."'')");
            }
		
            /*else{
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf')."'')");
            }*/
        }
        if($this->objParam->getParametro('v_estado_wf_vb')!='' && $this->objParam->getParametro('v_estado_wf_vb1')!=''){
            //var_dump($es_oportunidad);exit;
            $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf_vb')."''".","."''".$this->objParam->getParametro('v_estado_wf_vb1')."'')");
        }

        /* ====== Filter for profile of ProgramarAuditoria =======*/
        if($this->objParam->getParametro('v_estado_wfp')!='' && $this->objParam->getParametro('v_estado_wfp1')!='' && $this->objParam->getParametro('v_estado_wfp2')!='' && $this->objParam->getParametro('v_estado_wfp3')!='' && ($this->objParam->getParametro('v_tpo_audit')!='Todos' || $this->objParam->getParametro('v_tpo_audit')=='Todos')){
            //var_dump("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wfp')."''".","."''".$this->objParam->getParametro('v_estado_wfp1')."''".","."''".$this->objParam->getParametro('v_estado_wfp2')."''".","."''".$this->objParam->getParametro('v_estado_wfp3')."'')"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tpo_audit')."''");exit;
            if($this->objParam->getParametro('v_tpo_audit')!='Todos'){
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wfp')."''".","."''".$this->objParam->getParametro('v_estado_wfp1')."''".","."''".$this->objParam->getParametro('v_estado_wfp2')."''".","."''".$this->objParam->getParametro('v_estado_wfp3')."'')"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tpo_audit')."''");
            }
            else{
                $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wfp')."''".","."''".$this->objParam->getParametro('v_estado_wfp1')."''".","."''".$this->objParam->getParametro('v_estado_wfp2')."''".","."''".$this->objParam->getParametro('v_estado_wfp3')."'')");
            }
        }
        /* ====== Filter for profile of PlanificarAuditoria =======*/
        if($this->objParam->getParametro('v_estado_wfpl')!='' && $this->objParam->getParametro('v_estado_wfpl1')!='' && $this->objParam->getParametro('v_estado_wfpl2')!='' && $this->objParam->getParametro('v_estado_wfpl3')!='' && $this->objParam->getParametro('v_estado_wfpl4')!='' && $this->objParam->getParametro('v_tipo_auditoria')!=''){
            //var_dump('v_estado_wf_ai');exit;
            $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wfpl')."''".","."''".$this->objParam->getParametro('v_estado_wfpl1')."''".","."''".$this->objParam->getParametro('v_estado_wfpl2')."''".","."''".$this->objParam->getParametro('v_estado_wfpl3')."''".","."''".$this->objParam->getParametro('v_estado_wfpl4')."'')"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_auditoria')."''");
        }
        /* ====== Filter for profile of InformeAuditoria =======*/
        if($this->objParam->getParametro('v_estado_wf_ai')!='' && $this->objParam->getParametro('v_estado_wf_ai1')!='' && $this->objParam->getParametro('v_estado_wf_ai2')!='' && $this->objParam->getParametro('v_estado_wf_ai3')!='' && $this->objParam->getParametro('v_estado_wf_ai4')!='' && $this->objParam->getParametro('v_estado_wf_ai5')!='' && $this->objParam->getParametro('v_tipo_aii')!=''){
            //var_dump($this->objParam->getParametro('v_estado_wf_ai').",".$this->objParam->getParametro('v_estado_wf_ai1').",".$this->objParam->getParametro('v_estado_wf_ai2').",".$this->objParam->getParametro('v_estado_wf_ai3').",".$this->objParam->getParametro('v_estado_wf_ai4').",".$this->objParam->getParametro('v_estado_wf_ai5').",".$this->objParam->getParametro('v_tipo_aii'));exit;
            //var_dump("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf_ai')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai1')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai2')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai3')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai4')."'')"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_aii')."''");exit;
            $this->objParam->addFiltro("aom.estado_wf in (''".$this->objParam->getParametro('v_estado_wf_ai')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai1')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai2')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai3')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai4')."''".","."''".$this->objParam->getParametro('v_estado_wf_ai5')."'')"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_aii')."''");
        }
        /* ====== Filter for profile of InformeOportunidadMejora =======*/
        if($this->objParam->getParametro('v_estado_wf_om')!='' && $this->objParam->getParametro('v_tipo_om')!=''){
            //var_dump($es_oportunidad);exit;
            $this->objParam->addFiltro("aom.estado_wf = ''".$this->objParam->getParametro('v_estado_wf_om')."''"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_om')."''");
        }/*** fin ***/
        /*=================================================================================================================================================*/

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
        //var_dump('holadfdfd');
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
    /****************  Inicio ***********************/
    function getListUO(){
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
    }
    function  getListFuncionarios(){
        $this->objParam->defecto('ordenacion','id_uo');
        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');

        $this->res=$this->objFunc->getListUO($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function  getListFuncionario(){
        //$this->objParam->defecto('ordenacion','id_responsable');
        $this->objParam->defecto('ordenacion','id_funcionario');
        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');

        $this->res=$this->objFunc->getListFuncionario($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function  getListAuditores(){
        //$this->objParam->defecto('ordenacion','id_responsable');
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
    function insertSummary(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->updateSummary($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function insertRecomendation(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->updateRecomendation($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function insertActaRC(){
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->updateActaRC($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function verificarPlanificacion(){
        //$this->objParam->defecto('ordenacion','id_uo');
        //$this->objParam->defecto('dir_ordenacion','asc');
        //$this->objParam->addFiltro("FUNCIO.id_funcionario = ".$_SESSION["ss_id_funcionario"]);
        $this->objParam->addParametro('p_id_funcionario',$_SESSION["ss_id_funcionario"]);
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->verificarPlanificacion($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function verificarInforme(){
        //$this->objParam->defecto('ordenacion','id_uo');
        //$this->objParam->defecto('dir_ordenacion','asc');
        //$this->objParam->addFiltro("FUNCIO.id_funcionario = ".$_SESSION["ss_id_funcionario"]);
        $this->objParam->addParametro('p_id_funcionario',$_SESSION["ss_id_funcionario"]);
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->verificarInforme($this->objParam);
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
    function getListStatusAudit(){
        //$this->objParam->defecto('ordenacion','id_responsable');
        $this->objParam->defecto('ordenacion','codigo');
        $this->objParam->defecto('dir_ordenacion','desc');
        //var_dump($this->objParam); exit;
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->getListStatusAudit($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    /*****************  Fin ************************/
    /*
     * Funciones para reportes
     * **/
    function listarAuditoriaRangoFecha(){
        $this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');
        //var_dump("holaaaaaaaaaaaaaaaa");
        /* ====== Filter for profile of InformeAuditoria =======*/
        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        if($this->objParam->getParametro('p_fecha_de')!='' && $this->objParam->getParametro('p_fecha_hasta')!='' && $this->objParam->getParametro('p_id_uo')!='' ){ /*." and ''".$this->objParam->getParametro('v_estado')."''"*/ /*&& $this->objParam->getParametro('v_estado')!='' */
            //var_dump('v_estado_wf_ai');exit;
            $this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".$this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
        }/*** fin ***/

        /* ====== Filter for profile of InformeOportunidadMejora =======*/
        //if($this->objParam->getParametro('v_estado_wf_om')!='' && $this->objParam->getParametro('v_tipo_om')!=''){
            //var_dump($es_oportunidad);exit;
            //$this->objParam->addFiltro("aom.estado_wf = ''".$this->objParam->getParametro('v_estado_wf_om')."''"." and "."tau.codigo_tpo_aom = ''".$this->objParam->getParametro('v_tipo_om')."''");
        //}/*** fin ***/

        /*if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAuditoriaOportunidadMejora','listarAuditoriaOportunidadMejora');
        } else{
            $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
            $this->res=$this->objFunc->listarAuditoriaRangoFecha($this->objParam);
        }*/
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->listarAuditoriaRangoFecha($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	/*============================== REPORTES DE AUDITORIA ========================*/
    function reporteAuditoria() {
        /*$this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');*/

        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //var_dump('Hola');exit;

        if($this->objParam->getParametro('p_formato_rpt')!='' ){
            //var_dump('v_estado_wf_ai');exit;
            //$this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".$this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
            //$this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".$this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
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
    function reportAuditPDF(/*$create_file=false, $onlyData = false*/) {
        /*$this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');*/

        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //var_dump('Hola');exit;

        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reportAuditPDF($this->objParam);
        //var_dump($this->res->datos);die;
        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //$dataSource = $this->listarAuditoriaRangoFecha();
        //var_dump($dataSource);

      //  $dataEntidad = "";
      //  $dataPeriodo = "";
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
        //$this->reporte->Header($dataSource->getDatos());

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }
    function reportAuditXLS(/*$create_file=false, $onlyData = false*/) {

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

        /* Fin de la aumento de codigo*/

        //var_dump($this->objParam);exit;
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reportAuditXLS($this->objParam);

        //  $dataEntidad = "";
        //  $dataPeriodo = "";
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
        //$this->reporte->imprimeCabecera();
        $this->reporte->generarReporte();
        //$this->reporte->generarReporte();

        //$this->reporte->output($this->reporte->url_archivo,'F');
        //$this->reporte->Header($dataSource->getDatos());

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
    function reporteOportunidadMejora() {
        /*$this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');*/

        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //var_dump('Hola');exit;

        if($this->objParam->getParametro('p_formato_rpt')!='' ){
            //var_dump('v_estado_wf_ai');exit;
            //$this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".$this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
            //$this->objParam->addFiltro("aom.fecha_reg between ''".$this->objParam->getParametro('p_fecha_de')."''"." and "."''".$this->objParam->getParametro('p_fecha_hasta')."''"." and aom.id_uo = ".$this->objParam->getParametro('p_id_uo'));
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
    function reporteOMPDF(/*$create_file=false, $onlyData = false*/) {
        /*$this->objParam->defecto('ordenacion','id_aom');
        $this->objParam->defecto('dir_ordenacion','ASC');*/

        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //var_dump('Hola');exit;

        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reporteOM($this->objParam);
        //var_dump($this->res->datos);die;
        //var_dump($this->objParam->getParametro('p_fecha_de').", ".$this->objParam->getParametro('p_fecha_hasta').", ".$this->objParam->getParametro('p_id_uo'));exit;
        //$dataSource = $this->listarAuditoriaRangoFecha();
        //var_dump($dataSource);

        //  $dataEntidad = "";
        //  $dataPeriodo = "";
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
        //$this->reporte->Header($dataSource->getDatos());

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }
    function reporteOMXLS(/*$create_file=false, $onlyData = false*/) {

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
        /* Fin de la aumento de codigo*/

        //var_dump($this->objParam);exit;
        $this->objFunc=$this->create('MODAuditoriaOportunidadMejora');
        $this->res=$this->objFunc->reporteOM($this->objParam);

        //$dataEntidad = "";
        //$dataPeriodo = "";
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
        //$this->reporte->imprimeCabecera();
        $this->reporte->generarReporte();
        //$this->reporte->generarReporte();

        //$this->reporte->output($this->reporte->url_archivo,'F');
        //$this->reporte->Header($dataSource->getDatos());

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se genera con exito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
}

?>