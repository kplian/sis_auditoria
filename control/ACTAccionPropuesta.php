<?php
/**
 * @package pXP
 * @file gen-ACTAccionPropuesta.php
 * @author  (szambrana)
 * @date 04-07-2019 22:32:50
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */

class ACTAccionPropuesta extends ACTbase
{

    function listarAccionPropuesta()
    {
        $this->objParam->defecto('ordenacion', 'id_ap');
        $this->objParam->defecto('dir_ordenacion', 'asc');

        if ($this->objParam->getParametro('id_nc') != '') {
            $this->objParam->addFiltro("accpro.id_nc = " . $this->objParam->getParametro('id_nc'));
            if ($this->objParam->getParametro('interfaz') == 'AccionePropuestaAuditoria') {
                $this->objParam->addFiltro("accpro.estado_wf in (''propuesto'') ");
            }
        }
        if ($this->objParam->getParametro('interfaz') == 'AccionesPropuestaResponsable') {
            $this->objParam->addFiltro("accpro.estado_wf in (''NoConformidadSinAcciones'') ");
        }
        if ($this->objParam->getParametro('interfaz') == 'AccionesPropuestaAuditor') {
            $this->objParam->addFiltro("accpro.estado_wf in (''rechazado'',''implementado_aceptado_resp'',''verificadas'') ");
        }
        if ($this->objParam->getParametro('interfaz') == 'AccionesPropuestaImplementadas') {
            $this->objParam->addFiltro("accpro.estado_wf in (''implementadas'') ");
        }
        if ($this->objParam->getParametro('interfaz') == 'AccionesProImplementaVoBo') {
            $this->objParam->addFiltro("accpro.estado_wf in (''aceptado_resp'', ''rechazado_auditor'') ");
        }
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODAccionPropuesta', 'listarAccionPropuesta');
        } else {
            $this->objFunc = $this->create('MODAccionPropuesta');

            $this->res = $this->objFunc->listarAccionPropuesta($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarAccionPropuesta()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        if ($this->objParam->insertar('id_ap')) {
            $this->res = $this->objFunc->insertarAccionPropuesta($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarAccionPropuesta($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarAccionPropuesta()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->eliminarAccionPropuesta($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarSomUsuario()
    {
        $this->objParam->defecto('ordenacion', 'id_funcionario');

        $this->objParam->defecto('dir_ordenacion', 'asc');

        $this->objFunc = $this->create('MODNoConformidad');

        $this->res = $this->objFunc->listarSomUsuario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function siguienteEstado()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstado()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function aceptarAccion()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->aceptarAccion($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function multiCambiarEstadoAccionPropuesta()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->multiCambiarEstadoAccionPropuesta($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function aprobarEstado()
    {
        $this->objFunc = $this->create('MODAccionPropuesta');
        $this->res = $this->objFunc->aprobarEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }


}

?>