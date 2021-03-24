<?php
/**
*@package pXP
*@file gen-ACTEquipoResponsable.php
*@author  (max.camacho)
*@date 02-08-2019 14:03:25
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEquipoResponsable extends ACTbase{

	function listarEquipoResponsable(){
		$this->objParam->defecto('ordenacion','id_equipo_responsable');

		$this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_aom')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('id_aom'));
        }
		if($this->objParam->getParametro('item')!=''){
				$this->objParam->addFiltro("eqre.id_funcionario not in (select crer.id_funcionario
												  from ssom.tcronograma_equipo_responsable crer
												  where crer.id_cronograma = ".$this->objParam->getParametro('item').")");
		}

        if($this->objParam->getParametro('codigo_parametro')!=''){
            $this->objParam->addFiltro("par.codigo_parametro=  ''".$this->objParam->getParametro('codigo_parametro')."''");
        }



				// Fin*****

        if($this->objParam->getParametro('v_id_aom')!='' && $this->objParam->getParametro('v_codigo_parametro')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('v_id_aom')." and "."par.codigo_parametro = ''".$this->objParam->getParametro('v_codigo_parametro')."''");
        }
        // >>inicio ====<1> Query que lista equipo responsable que aun no estan asignados al cronograma  =====
        if($this->objParam->getParametro('p_id_aom')!='' && $this->objParam->getParametro('p_id_cronograma')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('p_id_aom')." and eqre.id_equipo_responsable not in (select eqr.id_equipo_responsable
                                                                                                                                            from ssom.tequipo_responsable eqr
                                                                                                                                            join ssom.tcronograma_equipo_responsable crer on eqr.id_equipo_responsable = crer.id_equipo_responsable
                                                                                                                                            join ssom.tcronograma cronog on crer.id_cronograma = cronog.id_cronograma
                                                                                                                                            where cronog.id_cronograma = ".$this->objParam->getParametro('p_id_cronograma').")");
        }
        //=====<2> Query que lista equipo responsables no asignado al cronograma mas el equipo responsable en edicion ======
        if($this->objParam->getParametro('pe_id_aom')!='' && $this->objParam->getParametro('pe_id_cronograma')!='' && $this->objParam->getParametro('pe_id_equipo_responsable')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('pe_id_aom')." and eqre.id_equipo_responsable not in (select eqr.id_equipo_responsable
                                                                                                                                            from ssom.tequipo_responsable eqr
                                                                                                                                            join ssom.tcronograma_equipo_responsable crer on eqr.id_equipo_responsable = crer.id_equipo_responsable
                                                                                                                                            join ssom.tcronograma cronog on crer.id_cronograma = cronog.id_cronograma
                                                                                                                                            where cronog.id_cronograma = ".$this->objParam->getParametro('pe_id_cronograma')." and eqr.id_equipo_responsable not in (".$this->objParam->getParametro('pe_id_equipo_responsable').") )");
        }// >>Fin====
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEquipoResponsable','listarEquipoResponsable');
		} else{
			$this->objFunc=$this->create('MODEquipoResponsable');

			$this->res=$this->objFunc->listarEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    /*function listarEquipoRespCronog(){
        $this->objParam->defecto('ordenacion','id_equipo_responsable');

        $this->objParam->defecto('dir_ordenacion','asc');
        // Metodo que filtra Responsables (funcionarios) en base al id padre (id_aom)
        //var_dump(id_aom);
        if($this->objParam->getParametro('p_id_aom')!='' && $this->objParam->getParametro('p_id_cronograma')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('p_id_aom')." and eqre.id_equipo_responsable not in (select eqr.id_equipo_responsable
                                                                                                                                            from ssom.tequipo_responsable eqr
                                                                                                                                            join ssom.tactividad_equipo_responsable aer on eqr.id_equipo_responsable = aer.id_equipo_responsable
                                                                                                                                            join ssom.tactividad act on aer.id_actividad = act.id_actividad
                                                                                                                                            where act.id_actividad = ".$this->objParam->getParametro('p_id_crongrama').")");
        }
        if($this->objParam->getParametro('pe_id_aom')!='' && $this->objParam->getParametro('pe_id_cronograma')!='' && $this->objParam->getParametro('pe_id_equipo_responsable')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('pe_id_aom')." and eqre.id_equipo_responsable not in (select eqr.id_equipo_responsable
                                                                                                                                            from ssom.tequipo_responsable eqr
                                                                                                                                            join ssom.tactividad_equipo_responsable aer on eqr.id_equipo_responsable = aer.id_equipo_responsable
                                                                                                                                            join ssom.tactividad act on aer.id_actividad = act.id_actividad
                                                                                                                                            where act.id_actividad = ".$this->objParam->getParametro('pe_id_cronograma')." and eqr.id_equipo_responsable not in (".$this->objParam->getParametro('pe_id_equipo_responsable').") )");
        }
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipoResponsable','listarEquipoResponsable');
        } else{
            $this->objFunc=$this->create('MODEquipoResponsable');

            $this->res=$this->objFunc->listarEquipoRespCronog($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }*/
    function esMiembroDelEquipo(){
        $this->objParam->defecto('ordenacion','id_equipo_responsable');
        $this->objParam->defecto('dir_ordenacion','asc');
        /* Metodo que filtra Responsables (funcionarios) en base al id padre (id_aom) */
        //var_dump(id_aom);

        if($this->objParam->getParametro('v_id_aom')!='' && $this->objParam->getParametro('p_id_funcionario')!=''){
            $this->objParam->addFiltro("eqre.id_aom = ".$this->objParam->getParametro('v_id_aom')." and "."eqre.id_funcionario = ".$this->objParam->getParametro('p_id_funcionario'));
        }

        $this->objFunc=$this->create('MODEquipoResponsable');
        $this->res=$this->objFunc->listarEquipoResponsable($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

	function insertarEquipoResponsable(){
		$this->objFunc=$this->create('MODEquipoResponsable');
		if($this->objParam->insertar('id_equipo_responsable')){
			$this->res=$this->objFunc->insertarEquipoResponsable($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarEquipoResponsable(){
			$this->objFunc=$this->create('MODEquipoResponsable');
		$this->res=$this->objFunc->eliminarEquipoResponsable($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function insertarItemEquipoResponsable(){
		$this->objFunc=$this->create('MODEquipoResponsable');
		$this->res=$this->objFunc->insertarItemEquipoResponsable($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
}

?>
