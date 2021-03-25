<?php
/**
 * @package pXP
 * @file gen-ACTPuntoNorma.php
 * @author  (szambrana)
 * @date 01-07-2019 18:45:10
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */

class ACTPuntoNorma extends ACTbase
{

    function listarPuntoNorma()
    {
        $this->objParam->defecto('ordenacion', 'id_pn');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        //*************SSS
        if ($this->objParam->getParametro('id_norma') != '') {
            $this->objParam->addFiltro("ptonor.id_norma = " . $this->objParam->getParametro('id_norma'));
        }
        //**************
        //*************filtro combo
        if ($this->objParam->getParametro('id_norma') != '') {
            $this->objParam->addFiltro("ptonor.id_norma = " . $this->objParam->getParametro('id_norma'));
        }

        if ($this->objParam->getParametro('id_pn') != '') {
            $this->objParam->addFiltro("ptonor.id_pn = " . $this->objParam->getParametro('id_pn'));
        }
        //**************
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODPuntoNorma', 'listarPuntoNorma');
        } else {
            $this->objFunc = $this->create('MODPuntoNorma');

            $this->res = $this->objFunc->listarPuntoNorma($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarPuntoNorma()
    {
        $this->objFunc = $this->create('MODPuntoNorma');
        if ($this->objParam->insertar('id_pn')) {
            $this->res = $this->objFunc->insertarPuntoNorma($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarPuntoNorma($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarPuntoNorma()
    {
        $this->objFunc = $this->create('MODPuntoNorma');
        $this->res = $this->objFunc->eliminarPuntoNorma($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }


    function listarPuntoNormaMulti()
    {
        $this->objParam->defecto('ordenacion', 'id_pn');
        $this->objParam->defecto('dir_ordenacion', 'asc');

		if ($this->objParam->getParametro('descrip_pregunta') != '') {
			$this->objParam->addFiltro("((ptonor.nombre_pn::varchar ILIKE ''%".$this->objParam->getParametro('descrip_pregunta')."%'') or
                                    to_tsvector(ptonor.nombre_pn::varchar) @@ plainto_tsquery(''spanish'', ''".$this->objParam->getParametro('descrip_pregunta')."''))");
		}

        if ($this->objParam->getParametro('id_norma') != '') {
            /// var_dump($this->objParam->getParametro('id_norma') );exit;
            $this->objParam->addFiltro("ptonor.id_norma = " . $this->objParam->getParametro('id_norma'));
        }

        if ($this->objParam->getParametro('fill') != '') {
            $this->objParam->addFiltro("ptonor.id_norma = " . $this->objParam->getParametro('id_norma'));
            $this->objParam->addFiltro("ptonor.id_pn not in (select pnnc.id_pn
                                                    from ssom.tpnorma_noconformidad pnnc
                                                    where pnnc.id_nc = " . $this->objParam->getParametro('id_nc') . " and pnnc.id_norma = " . $this->objParam->getParametro('id_norma') . " )");
        }

        if ($this->objParam->getParametro('item') != '') {
            $this->objParam->addFiltro("ptonor.id_pn not in (select anpn.id_pn
					                                         from ssom.tauditoria_npn anpn
					                                         where anpn.id_aom = " . $this->objParam->getParametro('item') . ")");
        }

        if ($this->objParam->getParametro('itemNc') != '') {
            $this->objParam->addFiltro("ptonor.id_pn in ( select an.id_pn
																				from ssom.tauditoria_npn an
                                                                                inner join ssom.tno_conformidad no on no.id_aom = an.id_aom
																				where no.id_nc = " . $this->objParam->getParametro('itemNc') . ") and
                                                                                ptonor.id_pn not in (
                                                                                   select pp.id_pn
                                                                                  from ssom.tpnorma_noconformidad pp
                                                                                  where pp.id_nc = " . $this->objParam->getParametro('itemNc') . ") ");


        }
        $this->objFunc = $this->create('MODPuntoNorma');
        $this->res = $this->objFunc->listarPuntoNormaMulti($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }


}

?>
