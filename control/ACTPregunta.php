<?php
/**
 * @package pXP
 * @file gen-ACTPregunta.php
 * @author  (szambrana)
 * @date 01-07-2019 19:04:06
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */

class ACTPregunta extends ACTbase
{

    function listarPregunta()
    {
        $this->objParam->defecto('ordenacion', 'id_pregunta');
        $this->objParam->defecto('dir_ordenacion', 'asc');

        if ($this->objParam->getParametro('descrip_pregunta') != '') {
            $this->objParam->addFiltro("((prptnor.descrip_pregunta::varchar ILIKE ''%".$this->objParam->getParametro('descrip_pregunta')."%'') or
                                    to_tsvector(prptnor.descrip_pregunta::varchar) @@ plainto_tsquery(''spanish'', ''".$this->objParam->getParametro('descrip_pregunta')."''))");
        }
        //***************
        if ($this->objParam->getParametro('id_pn') != '') {
            $this->objParam->addFiltro("prptnor.id_pn = " . $this->objParam->getParametro('id_pn'));
        }

        if ($this->objParam->getParametro('item') != '') {
            $this->objParam->addFiltro("prptnor.id_pregunta not in (select p.id_pregunta
                                                                   from ssom.tauditoria_npnpg p
                                                                   where p.id_aom =" . $this->objParam->getParametro('item') . " )");
                        }


        //***************
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODPregunta', 'listarPregunta');
        } else {
            $this->objFunc = $this->create('MODPregunta');

            $this->res = $this->objFunc->listarPregunta($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarPregunta()
    {
        $this->objFunc = $this->create('MODPregunta');
        if ($this->objParam->insertar('id_pregunta')) {
            $this->res = $this->objFunc->insertarPregunta($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarPregunta($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarPregunta()
    {
        $this->objFunc = $this->create('MODPregunta');
        $this->res = $this->objFunc->eliminarPregunta($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}

?>