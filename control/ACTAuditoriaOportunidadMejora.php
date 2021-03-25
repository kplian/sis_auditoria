<?php
/**
 * @package pXP
 * @file gen-ACTAuditoriaOportunidadMejora.php
 * @author  (max.camacho)
 * @date 17-07-2019 17:41:55
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */
require_once(dirname(__FILE__) . '/../reportes/RResumen.php');
require_once(dirname(__FILE__) . '/../reportes/RReporteGeneralAuditoria.php');
require_once(dirname(__FILE__) . '/../reportes/RAuditoriaAnual.php');
require_once(dirname(__FILE__) . '/../reportes/RAccione.php');

class ACTAuditoriaOportunidadMejora extends ACTbase
{

    function listarAuditoriaOportunidadMejora()
    {
        $this->objParam->defecto('ordenacion', 'id_aom');
        $this->objParam->defecto('dir_ordenacion', 'ASC');
        if ($this->objParam->getParametro('id_aom') != '') {
            $this->objParam->addFiltro("aom.id_aom = " . $this->objParam->getParametro('id_aom'));
        }
        if ($this->objParam->getParametro('interfaz') == 'ProgramarAuditoria') {

            /*aom.estado_wf in (''programada'',''aprobado_responsable'') and */
            $filtroInit = "tau.codigo_tpo_aom = ''AETR''";

            if ($this->objParam->getParametro('id_gestion') != '') {
                $filtroInit = "aom.id_gestion = " . $this->objParam->getParametro('id_gestion') . "and aom.codigo_aom = ''AETR''";
            }


            if ($this->objParam->getParametro('id_gestion') != '' and $this->objParam->getParametro('tipo_estado') != '') {
                $filtroInit = "aom.estado_wf = ''" . $this->objParam->getParametro('tipo_estado') . "'' and aom.id_gestion =" . $this->objParam->getParametro('id_gestion');
            }
            if ($this->objParam->getParametro('id_gestion') != '' and $this->objParam->getParametro('id_uo') != '') {
                $filtroInit = "aom.id_gestion = " . $this->objParam->getParametro('id_gestion') . "and tau.codigo_tpo_aom = ''AETR''and aom.id_uo =" . $this->objParam->getParametro('id_uo');
            }
            if ($this->objParam->getParametro('id_gestion') != '' and $this->objParam->getParametro('id_uo') != '' and $this->objParam->getParametro('tipo_estado') != '') {
                $filtroInit = "aom.id_gestion = " . $this->objParam->getParametro('id_gestion') . "and tau.codigo_tpo_aom = ''AETR''and aom.id_uo =" .
                    $this->objParam->getParametro('id_uo') . "and aom.estado_wf = ''" . $this->objParam->getParametro('tipo_estado') . "''";
            }

            $this->objParam->addFiltro($filtroInit);
        }
        if ($this->objParam->getParametro('interfaz') == 'PlanificarAuditoria') {
            $this->objParam->addFiltro("aom.estado_wf not in (''programada'') and tau.codigo_tpo_aom = ''AETR''");
        }

        if ($this->objParam->getParametro('interfaz') == 'OportunidadMejora') {
            $this->objParam->addFiltro("aom.estado_wf in (''programada'',''aprobado_responsable'') and aom.codigo_aom != ''AETR''");
        }
        if ($this->objParam->getParametro('interfaz') == 'InformesAuditoriaNotificados') {
            $this->objParam->addFiltro("aom.estado_wf in (''notificar_responsable'',''notificar'')");
        }
        if ($this->objParam->getParametro('interfaz') == 'AuditorioAportunidadAcepRech') {
            $this->objParam->addFiltro("aom.estado_wf = ''notificar'' and tau.codigo_tpo_aom = ''AETR'' ");
        }
        if ($this->objParam->getParametro('interfaz') == 'OportunidadMejoraAcepRech') {
            $this->objParam->addFiltro("aom.estado_wf = ''notificar'' and tau.codigo_tpo_aom = ''OM''");
        }

        if ($this->objParam->getParametro('desde') != '' && $this->objParam->getParametro('hasta') != '') {
            $this->objParam->addFiltro("aom.fecha_prog_inicio >= '' " . $this->objParam->getParametro('desde') . "'' and aom.fecha_prog_fin <= ''" . $this->objParam->getParametro('hasta') . "''");
        }

        if ($this->objParam->getParametro('interfaz') == 'InformeAuditoria') {
            $this->objParam->addFiltro("aom.estado_wf not in (''programada'',''aprobado_responsable'',''planificacion'')");
        }
        if ($this->objParam->getParametro('interfaz') == 'OportunidadMejoraInforme') {
            $this->objParam->addFiltro("aom.estado_wf not in (''programada'') and aom.codigo_aom != ''AETR''");
        }

        if ($this->objParam->getParametro('v_tipo_auditoria_nc') != '') {
            $this->objParam->addFiltro("aom.id_tipo_auditoria= " . $this->objParam->getParametro('v_tipo_auditoria_nc') . " and aom.estado_wf in (''acciones_propuestas'') ");
        }

        if ($this->objParam->getParametro('interfaz') == 'Auditoria') {
            if ($this->objParam->getParametro('id_gestion') != '') {
                $this->objParam->addFiltro("aom.id_gestion =" . $this->objParam->getParametro('id_gestion'));
            }
            if ($this->objParam->getParametro('id_tipo_auditoria') != '') {
                $this->objParam->addFiltro("aom.id_tipo_auditoria =" . $this->objParam->getParametro('id_tipo_auditoria'));
            }
            if ($this->objParam->getParametro('id_uo') != '') {
                $this->objParam->addFiltro("aom.id_uo =" . $this->objParam->getParametro('id_uo'));
            }
            if ($this->objParam->getParametro('tipo_estado') != '') {
                $this->objParam->addFiltro("aom.estado_wf = ''" . $this->objParam->getParametro('tipo_estado') . "''");
            }
            if ($this->objParam->getParametro('desde') != '' && $this->objParam->getParametro('hasta') != '') {
                $this->objParam->addFiltro("aom.fecha_prog_inicio >= '' " . $this->objParam->getParametro('desde') . "'' and aom.fecha_prog_fin <= ''" . $this->objParam->getParametro('hasta') . "''");
            }
        }


        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODAuditoriaOportunidadMejora', 'listarAuditoriaOportunidadMejora');
        } else {
            $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
            $this->res = $this->objFunc->listarAuditoriaOportunidadMejora($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function getListAuditores()
    {
        $this->objParam->defecto('ordenacion', 'id_funcionario');
        $this->objParam->defecto('dir_ordenacion', 'desc');

        if ($this->objParam->getParametro('desc_funcionario1') != '') {
            $this->objParam->addFiltro("((fun.desc_funcionario1::varchar ILIKE ''%".$this->objParam->getParametro('desc_funcionario1')."%'') or
                                    to_tsvector(fun.desc_funcionario1::varchar) @@ plainto_tsquery(''spanish'', ''".$this->objParam->getParametro('desc_funcionario1')."''))");
        }

        if ($this->objParam->getParametro('item') != '') {
            $this->objParam->addFiltro(" fun.id_funcionario not in
                                                        (select  eqre.id_funcionario
                                                from ssom.tequipo_responsable eqre
                                                inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                                                where eqre.id_aom = " . $this->objParam->getParametro('item') . " and  par.codigo_parametro = ''MEQ'')");
        }
        if ($this->objParam->getParametro('destinatario') != '') {
            $this->objParam->addFiltro(" fun.id_funcionario not in
                                                        (select de.id_funcionario
                                                        from ssom.tdestinatario de
                                                        where de.id_aom = " . $this->objParam->getParametro('destinatario') . ")");
        }

        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->getListAuditores($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarAuditoriaOportunidadMejora()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->objParam->addParametro('id_funcionario', $_SESSION["ss_id_funcionario"]);
        if ($this->objParam->insertar('id_aom')) {
            $this->res = $this->objFunc->insertarAuditoriaOportunidadMejora($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarAuditoriaOportunidadMejora($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarAuditoriaOportunidadMejora()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->eliminarAuditoriaOportunidadMejora($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertSummary()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->updateSummary($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function siguienteEstado()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstado()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteResumen()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->reporteResumen($this->objParam);
        $titulo = 'Resumen';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo = uniqid(md5(session_id()) . $titulo);
        $nombreArchivo .= '.pdf';
        $this->objParam->addParametro('orientacion', 'P');
        $this->objParam->addParametro('tamano', 'LETTER');
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);
        $this->objReporteFormato = new RResumen($this->objParam);
        $this->objReporteFormato->setDatos($this->res->datos);
        $this->objReporteFormato->generarReporte();
        $this->objReporteFormato->output($this->objReporteFormato->url_archivo, 'F');

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado',
            'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

    function getListFuncionario()
    {
        $this->objParam->defecto('ordenacion', 'id_funcionario');
        $this->objParam->defecto('dir_ordenacion', 'ASC');
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->getListFuncionario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteAuditoriaListar()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $cbteHeader = $this->objFunc->reporteAuditoriaListar($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteAuditoriaProceso()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $cbteHeader = $this->objFunc->reporteAuditoriaProceso($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteAuditoriaEquipo()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $cbteHeader = $this->objFunc->reporteAuditoriaEquipo($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteAuditoriaNorma()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $cbteHeader = $this->objFunc->reporteAuditoriaNorma($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteAuditoriaCrorograma()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $cbteHeader = $this->objFunc->reporteAuditoriaCrorograma($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteAuditoria()
    {
        $dataAuditoria = $this->reporteAuditoriaListar();
        $dataProcesos = $this->reporteAuditoriaProceso();
        $dataEquipo = $this->reporteAuditoriaEquipo();
        $dataNorma = $this->reporteAuditoriaNorma();
        $dataCrorograma = $this->reporteAuditoriaCrorograma();

        $titulo = 'Resumen';

        $nombreArchivo = uniqid(md5(session_id()) . $titulo);
        $nombreArchivo .= '.pdf';
        $this->objParam->addParametro('orientacion', 'P');
        $this->objParam->addParametro('tamano', 'LETTER');
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);
        $this->objReporteFormato = new RReporteGeneralAuditoria($this->objParam);
        $this->objReporteFormato->setDatos(
            $dataAuditoria->datos,
            $dataProcesos->datos,
            $dataEquipo->datos,
            $dataNorma->datos,
            $dataCrorograma->datos
        );
        $this->objReporteFormato->generarReporte();
        $this->objReporteFormato->output($this->objReporteFormato->url_archivo, 'F');

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado',
            'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

    function getListUO()
    {
        $this->objParam->defecto('ordenacion', 'id_uo');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('nivel') != '') {
            $this->objParam->addFiltro("n.numero_nivel in (" . $this->objParam->getParametro('nivel') . ")");
        }
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->getListUO($this->objParam);

        if ($this->objParam->getParametro('_adicionar') != '') {
            $respuesta = $this->res->getDatos();
            array_unshift($respuesta, array('id_uo' => '0',
                'nombre_unidad' => 'Todos',
                'codigo' => 'Todos',
                'nivel_organizacional' => 'Todos'
            ));
            $this->res->setDatos($respuesta);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteAuditoriaAnual()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->reporteAuditoriaAnual($this->objParam);
        $titulo = 'AuditoriaAnual';
        $nombreArchivo = uniqid(md5(session_id()) . $titulo);
        $nombreArchivo .= '.xls';
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);
        $this->objParam->addParametro('datos', $this->res->datos);
        $this->objReporteFormato = new RAuditoriaAnual($this->objParam);
        $this->objReporteFormato->generarDatos();
        $this->objReporteFormato->generarReporte();
        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

    function aprobarEstado()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->aprobarEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function planifiacionAuditoria()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->planifiacionAuditoria($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function getProceso()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->getProceso($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarEstados()
    {
        $this->objParam->defecto('ordenacion', 'id_aom');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if ($this->objParam->getParametro('progrmar') != '') {
            $this->objParam->addFiltro(" ts.codigo in (''programada'',''aprobado_responsable'')");
        }

        if ($this->objParam->getParametro('planificacion') != '') {
            $this->objParam->addFiltro(" ts.codigo not in (''programada'',''aprobado_responsable'')");
        }

        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->listarEstados($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteAcciones()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->reporteAcciones($this->objParam);
        $titulo = 'Acciones';

        // Genera el nombre del archivo (aleatorio + titulo)

        $nombreArchivo = uniqid(md5(session_id()) . $titulo);
        $nombreArchivo .= '.pdf';
        $this->objParam->addParametro('orientacion', 'L');
        $this->objParam->addParametro('tamano', 'LETTER');
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);
        $this->objReporteFormato = new RAccione($this->objParam);
        $this->objReporteFormato->setDatos($this->res->datos);
        $this->objReporteFormato->generarReporte();
        $this->objReporteFormato->output($this->objReporteFormato->url_archivo, 'F');

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado',
            'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

    function listarFuncionarioVigentes()
    {
        $this->objParam->defecto('ordenacion', 'id_funcionario');
        $this->objParam->defecto('dir_ordenacion', 'ASC');
        if ($this->objParam->getParametro('desc_funcionario1') != '') {
            $this->objParam->addFiltro("((fc.desc_funcionario1::varchar ILIKE ''%".$this->objParam->getParametro('desc_funcionario1')."%'') or
                                    to_tsvector(fc.desc_funcionario1::varchar) @@ plainto_tsquery(''spanish'', ''".$this->objParam->getParametro('desc_funcionario1')."''))");
        }
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->listarFuncionarioVigentes($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function getCorrelativo()
    {
        $this->objFunc = $this->create('MODAuditoriaOportunidadMejora');
        $this->res = $this->objFunc->getCorrelativo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>
