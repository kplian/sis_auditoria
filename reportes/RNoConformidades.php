<?php
/**
 *@package pXP
 *@file RNoConformidades
 *@author  SAZP
 *@date 19-08-2019 15:28:39
 *@description Clase que genera el reporte de No conformidades
 * HISTORIAL DE MODIFICACIONES:

 */
class RNoConformidades extends  ReportePDF
{
    var $datos;
    function Header(){

        $this->Ln(8);
        $this->MultiCell(40, 25, '', 1, 'C', 0, '', '');
        $this->SetFontSize(15);
        $this->SetFont('', 'B');
        $this->MultiCell(105, 25, "\n" ."INFORME DE NO CONFORMIDADES", 1, 'C', 0, '', '');
        $this->SetFont('times', '', 10);
        $this->MultiCell(0, 25, "\n" ."0-R-210", 1, 'C', 0, '', '');
        $this->Image(dirname(__FILE__) . '/../../pxp/lib' . $_SESSION['_DIR_LOGO'], 17, 15, 36);
		
    }

    function reporteRequerimiento(){
        $this->SetFont('times', '', 10);

        $tipo = $this->datos[0]['tipo_norma'];
        $tramite =  $this->datos[0]['nro_tramite_wf'];
        $titulo = $this->datos[0]['nombre_aom1'];
        $responsable = $this->datos[0]['responsable'];
        $resumen = <<<EOF
        <style>
		table, th, td {
            border-collapse: collapse;     
            padding: 10px;       
		}
		</style>
       <table style="width: 100%">
            <tr>
                <th style="width:30%"><b>Tipo de Auditoria:</b>  $tipo</th>
                <td style="width:70%"><b>Código de la Auditoria:</b>  $tramite</td>
            </tr>
            <tr>
                <th><b>Nombre Auditoria:</b></th>
                <td>$titulo</td>
            </tr>
            <tr>
                <th><b>De:</b> Equipo Auditor</th>
                <td><b>A:</b> $responsable</td>
            </tr>
	   </table>	
EOF;
        $this->writeHTML ($resumen);
        $this->Ln(1);
        $this->SetFont('times', '', 10);

        $detalle = '
        <style>
		table, th, td {
   			border: 1px solid #3B3B9C;
            border-collapse: collapse;           
		}
		</style>
		 <table style="width: 100%">
		    <tr>
		        <th style="width:10%; background-color: #006999;color: #fff;" align="center"><b>Nro.</b></th>
		        <th style="width:20%; background-color: #006999;color: #fff;" align="center"><b>Tipo</b></th>
		        <th style="width:25%; background-color: #006999;color: #fff;" align="center"><b>Descripción</b></th>
		        <th style="width:25%; background-color: #006999;color: #fff;" align="center"><b>Evidencia / Justificación</b></th>
		        <th style="width:20%; background-color: #006999;color: #fff;" align="center"><b>Archivos Evidencia</b></th>
            </tr>
		 
        ';
        $numero = 1;
        foreach ($this->datos as $value){
            $detalle.='
                <tr>
                    <td>'.$numero.'</td>
                    <td>'.$value['valor_parametro'].'</td>
                    <td>'.$value['descrip_nc'].'</td>
                    <td>'.$value['evidencia'].'</td>
                    <td> - </td>
                </tr>
            ';
            $numero++;
        }

        $detalle.= ' </table>	';
        $this->writeHTML ($detalle);
        $this->Ln(1);

    }
    function setDatos($datos) {
        $this->datos = $datos;
    }

    function generarReporte() {
        $this->setFontSubsetting(false);

        $this->SetMargins(15,40,15);
        $this->AddPage();
        $this->SetMargins(15,40,15);
        $this->reporteRequerimiento();
    }
}
?>