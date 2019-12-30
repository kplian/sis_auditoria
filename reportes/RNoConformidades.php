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
    function Header(){
        $this->ln(8);
        $height = 50;
        //cabecera del reporte
        $this->Cell(70, $height, '', 0, 0, 'C', false, '', 0, false, 'T', 'C');
        $this->SetFontSize(15);
        $this->SetFont('', 'B');
        $this->MultiCell(105, $height,  "REPORTE DE NO CONFORMIDADES", 0, 'C', 0, '', '');

        $this->Image(dirname(__FILE__) . '/../../pxp/lib' . $_SESSION['_DIR_LOGO'], 17, 10, 36);
		
    }
    function Footer() {
        $this->setY(-15);
        $ormargins = $this->getOriginalMargins();
        $this->SetTextColor(0, 0, 0);
        //set style for cell border
        $line_width = 0.85 / $this->getScaleFactor();
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $ancho = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right']) / 3);
        $this->Ln(2);
        $cur_y = $this->GetY();
        //$this->Cell($ancho, 0, 'Generado por XPHS', 'T', 0, 'L');
        $this->Cell($ancho, 0, 'Usuario: '.$_SESSION['_LOGIN'], '', 0, 'L');
        $pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
        $this->Cell($ancho, 0, $pagenumtxt, '', 0, 'C');
        $this->Cell($ancho, 0, $_SESSION['_REP_NOMBRE_SISTEMA'], '', 0, 'R');
        $this->Ln();
        //   $fecha_rep = date("d-m-Y H:i:s");
        //  $this->Cell($ancho, 0, "Fecha : ".$fecha_rep, '', 0, 'L');
        $this->Ln($line_width);
        $this->Ln();
        $barcode = $this->getBarcode();
        $style = array(
            'position' => $this->rtl?'R':'L',
            'align' => $this->rtl?'R':'L',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false,
            'text' => false,
            'position' => 'R'
        );
        $this->write1DBarcode($barcode, 'C128B', $ancho*2, $cur_y + $line_width+5, '', (($this->getFooterMargin() / 3) - $line_width), 0.3, $style, '');

    }
    function reporteRequerimiento(){

        $this->SetFont('times', 'B', 11);
        $this->Cell(80, 7, ' Tipo de Auditoria: ', 1, 0, 'L', 0, '', 0);
        $this->SetFont('times', '', 11);
        $this->Cell(106, 7, ' Codigo de la Auditoria: ' . $this->datos[0]['nro_tramite_wf'], 1, 0, 'R', 0, '', 0);
		$this->ln();
		
        $this->Cell(0, 7, 'Nombre Auditoria: '. $this->datos[0]['nombre_aom1'], 1, 0, 'L', 0, '', 0);
        $this->ln();

        $this->SetFont('times', '', 11);
        //$this->Cell(40, 0, 'De: '.$this->datos[0]['fecha_solicitud'], 1, 0, 'C', 0, '', 0);
		$this->Cell(80, 7, 'De: Equipo Auditor', 1, 0, 'L', 0, '', 0);
        $this->Cell(106, 7, 'A: '.$this->datos[0]['destinatario'], 1, 0, 'R', 0, '', 0);
		$this->ln();
		$this->ln();
		
		//$this->Cell(0, 0, 'Nro.: '.$this->datos[0]['nro_tramite'], 1, 1, 'C', 0, '', 0);
		$this->Cell(9, 0, 'Nro.', 1, 0, 'C', 0, '', 0);
		$this->Cell(25, 0, 'Tipo', 1, 0, 'C', 0, '', 0);
		$this->Cell(60, 0, 'Descripcion', 1, 0, 'C', 0, '', 0);
		$this->Cell(55, 0, 'Evidencia/Justificacion', 1, 0, 'C', 0, '', 0);
		$this->Cell(37, 0, 'Archivos Evidencia', 1, 0, 'C', 0, '', 0);
        $this->ln();
        $numero = 1;
        $pagina = 0;
        foreach ($this->datos as $Row) {
            $tipo_nc = $Row['tipo_no_conf'];
            $descrip_nc = $Row['descrip_nc'];
            $evidencia_nc = $Row['evidencia'];
			$resp_nc = $Row['resp_area_no_conf']; //insertar nombres archivos evidencia
			
            $tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1" >
    <tr>
        <td width="31.8"  align="center">$numero</td>
        <td width="88.6" align="center">$tipo_nc</td>
        <td width="212.8" align="center">$descrip_nc</td>
        <td width="194.5" align="justify">$evidencia_nc</td>
        <td width="131.5"  align="center">$resp_nc</td>
    </tr>
</table>
EOD;
            $this->SetFont('times', '', 9);
            $this->writeHTML($tbl, false, false, false, false, '');
            $numero++;
            $pagina++;
        }
    }
    function setDatos($datos) {
        $this->datos = $datos;
        // var_dump($this->datos);exit;
    }

    function generarReporte() {
        $this->SetMargins(15,40,15);
        $this->setFontSubsetting(false);
        $this->AddPage();
        $this->SetMargins(15,40,15);
        $this->reporteRequerimiento();
    }
}
?>