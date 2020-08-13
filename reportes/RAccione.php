<?php
class RAccione extends ReportePDF{
    var $datos ;
    var $ancho_hoja;

    function Header() {
        $this->Ln(5);
        $url_imagen = dirname(__FILE__) . '/../../pxp/lib/images/Logo-BoA.png';

         $area = $this->datos[0]['nombre_unidad'];
         $reponsable = $this->datos[0]['desc_funcionario1'];
         $codigo = $this->datos[0]['nro_tramite_wf'];
         $desc_tipo_objeto = $this->datos[0]['desc_tipo_objeto'];
         $nombre_aom1 = $this->datos[0]['nombre_aom1'];

        $fecha_prog_inicio = date_format(date_create($this->datos[0]["fecha_prog_inicio"]), 'd/m/Y');
        $fecha_prog_fin = date_format(date_create($this->datos[0]["fecha_prog_fin"]), 'd/m/Y');

        $html = <<<EOF
		<style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;              
		}
		</style>
		<table style="width: 100%; padding: 10px">
            <tr>
                <th style="background-color: #006999;color: #fff; font-size: 17px;" colspan="2"><b>VERIFICACIÓN DE EFICACIA DE ACCIONES CORRECTIVAS IMPLEMENTADAS (0-R-206)</b></th>
            </tr>
            <tr>
                <td style="text-align: left; background-color: #D3D3D3;color: #4F4F9F;">
                   Empresa: ETR  ENDE Transmisión
                </td>
               <td style="text-align: right; background-color: #D3D3D3;color: #4F4F9F;">
                    Área: $area
                    <br/>
                    Responsable:$reponsable
                </td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 10px">
                   Código de la Auditoria : $codigo
                     <br/>
                   Objeto de la Auditoria : $desc_tipo_objeto
                     <br/>
                   Procesos Auditados: Gestión de Operación y Mantenimiento
                </td>
                <td style="text-align: center; font-size: 10px">
                   Nombre de la Auditoria : $nombre_aom1
                    <br/>
                   Fechas de ejecución: Inicio: $fecha_prog_inicio Finalización: $fecha_prog_fin
                    <br/>
                   Responsables del informe: $reponsable
                </td>
            </tr>
        </table>
EOF;

        $this->writeHTML ($html);
    }
    function resumen(){
        $this->Ln(30);
        $this->SetFont('times', '', 10);
        $procesos = '
 <style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;            
		}
		</style>
  <table style="width: 100%">
            <tr>
                <th style="background-color: #006999;color: #fff; width: 10%;"  align="center"><h3><b>Nro.</b></h3></th>
                <th style="background-color: #006999;color: #fff; width: 30%;"  align="center"><h3><b>Tipo de No Conformindad</b></h3></th>
                <th style="background-color: #006999;color: #fff; width: 30%;"  align="center"><h3><b>Estado de la No Conformidad</b></h3></th>
                <th style="background-color: #006999;color: #fff; width: 30%;"  align="center"><h3><b>Descripción de la No Conformidad</b></h3></th>
            </tr>
            ';





        $procesos.='</table>';
        $this->writeHTML ($procesos);

    }
    function setDatos($datos) {
        $this->datos = $datos;
        // var_dump($this->datos);exit;
    }
    function generarReporte() {
        $this->AddPage();
        // $this->SetMargins(17, 40, 15);
        $this->resumen();
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    }
}
?>