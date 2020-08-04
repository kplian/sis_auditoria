<?php
class RReporteGeneralAuditoria extends ReportePDF{

    private $auditoria;
    private $proceso;
    private $equipo;
    private $norma;
    private $crorograma;

    function Header() {
        $url_imagen = dirname(__FILE__) . '/../../pxp/lib/images/logos/logo.png';

        $this->Ln(8);
        $this->MultiCell(40, 25, '', 1, 'C', 0, '', '');
        $this->SetFontSize(15);
        $this->SetFont('', 'B');
        $this->MultiCell(105, 25, "\n" .$this->auditoria[0]['tipo_auditoria'], 1, 'C', 0, '', '');
        $this->SetFont('times', '', 10);
        $this->MultiCell(0, 25, "\n" .$this->auditoria[0]['nro_tramite_wf'], 1, 'C', 0, '', '');
        $this->Image(dirname(__FILE__) . '/../../pxp/lib' . $_SESSION['_DIR_LOGO'], 17, 15, 36);
    }
    function resumen(){
        $this->SetFont('times', '', 10);

        $titulo = $this->auditoria[0]['titulo'];
        $area = $this->auditoria[0]['area'];
        $responsable = $this->auditoria[0]['responsable'];
        $fecha_inicio = $this->auditoria[0]['fecha_prog_inicio'];
        $fecha_fin = $this->auditoria[0]['fecha_prog_fin'];

        $norma= $this->auditoria[0]['tipo_norma'];
        $objetivo = $this->auditoria[0]['tipo_objeto'];
        $resumen = <<<EOF
        <style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;            
		}
		</style>
       <table style="width: 100%">
             <tr>
              <th style="background-color: #006999;color: #fff" colspan="3" align="center"><h3><b>Datos Generales</b></h3></th>
            </tr>
            <tr>   
                <th style="width: 20%"><b>Titulo</b></th> 
                <td style="width: 80%">$titulo</td>
            </tr>
            <tr>   
                <th><b>Area</b></th> 
                <td>$area</td>
            </tr>
            <tr>   
                <th><b>Resonsable</b></th> 
                <td>$responsable</td>
            </tr>
             <tr>
                <td style="width: 25%"><b>Tipo de Norma</b></td>
                <td style="width: 25%" align="center">$norma</td>
                <td style="width: 25%"><b>Objetivo Auditoria</b></td>
                <td style="width: 25%" align="center">$objetivo</td>
             </tr>
             <tr>
                <td style="width: 25%"><b>Fecha Inicio</b></td>
                <td style="width: 25%" align="center">$fecha_inicio</td>
                <td style="width: 25%"><b>Fecha Fin</b></td>
                <td style="width: 25%" align="center">$fecha_fin</td>
             </tr>
            
	   </table>	
EOF;
        $this->writeHTML ($resumen);
        $this->Ln(1);
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
                <th style="background-color: #006999;color: #fff" colspan="2" align="center"><h3><b>Procesos</b></h3></th>
            </tr>
            <tr>
                <th align="center"><b>Proceso</b></th>
                <th align="center"><b>Responsable</b></th>
            </tr>';

        foreach ( $this->proceso as $record){
            $procesos.='
            <tr>
                <th>'. $record["proceso"].'</th>
                <th>'. $record["responsable_proceso"].'</th>
            </tr>
            ';
        }

        $procesos.='</table>';
        $this->writeHTML ($procesos);
        $this->Ln(1);
        $this->SetFont('times', '', 10);
        $equipo = '
 <style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;            
		}
		</style>
  <table style="width: 100%">
            <tr>
                <th style="background-color: #006999;color: #fff" colspan="2" align="center"><h3><b>Equipo</b></h3></th>
            </tr>
            <tr>
                <th align="center"><b>Tipo Auditor</b></th>
                <th align="center"><b>Funcionario</b></th>
            </tr>';

        foreach ( $this->equipo as $record){
            $equipo.='
            <tr>
                <th>'. $record["tipo_equipo"].'</th>
                <th>'. $record["funcionario"].'</th>
            </tr>
            ';
        }
        $equipo.='</table>';
        $this->writeHTML ($equipo);
        $this->Ln(1);


        $this->SetFont('times', '', 10);
        $punto = '
 <style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;            
		}
		</style>
  <table style="width: 100%">
            <tr>
                <th style="background-color: #006999;color: #fff" colspan="2" align="center"><h3><b>Puntos de Norma</b></h3></th>
            </tr>
            <tr>
                <th style="width: 20%" align="center"><b>Norma</b></th>
                <th style="width: 80%" align="center"><b>Punto Norma</b></th>
            </tr>';
        $sigla ='';
        foreach ( $this->norma as $record){
            $punto.='<tr>';
            if ($sigla != $record["sigla_norma"]){
                $punto.='<th>'. $record["sigla_norma"].'</th>';
                $sigla= $record["sigla_norma"];
            }else{
                $punto.='<th> </th>';

            }

            $punto.='<th>'. $record["nombre_pn"].'</th>
            </tr>
            ';
        }
        $punto.='</table>';
        $this->writeHTML ($punto);
        $this->Ln(1);
        $this->SetFont('times', '', 10);
        $crorogram = '
 <style>
		table, th, td {
   			border: 1px solid black;
            border-collapse: collapse;            
		}
		</style>
  <table style="width: 100%">
            <tr>
                <th style="background-color: #006999;color: #fff" colspan="3" align="center"><h3><b>Crorograma</b></h3></th>
            </tr>
            <tr>
                <th style="width: 20%" align="center"><b>Activiedad</b></th>
                <th style="width: 55%" align="center"><b>Funcionario</b></th>
                <th style="width: 25%" align="center"><b>Fecha</b></th>
            </tr>';
        foreach ( $this->crorograma as $record){
            $crorogram.='
            <tr>
                <th>'. $record["actividad"].'</th>
                <th>'. $record["funcionario"].'</th>
                <th align="center">'. $record["fecha_ini_activ"] .' - '.$record["fecha_fin_activ"].'</th>
            </tr>
            ';
        }

        $crorogram.='</table>';
        $this->writeHTML ($crorogram);

    }
    function setDatos($auditoria,$proceso,$equipo,$norma,$crorograma) {
        $this->auditoria = $auditoria;
        $this->proceso = $proceso;
        $this->equipo = $equipo;
        $this->norma = $norma;
        $this->crorograma = $crorograma;

    }
    function generarReporte() {
        $this->setFontSubsetting(false);

        $this->SetMargins(15,40,15);
        $this->AddPage();
        $this->SetMargins(15,40,15);
        $this->resumen();
    }
}
?>