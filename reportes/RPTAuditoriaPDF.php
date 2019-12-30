<?php
class RPTAuditoriaPDF extends  ReportePDF
{
    function Header(){

        $this->ln(8);
        $height = 50;
        //cabecera del reporte
        $this->Cell(70, $height, '', 0, 0, 'C', false, '', 0, false, 'T', 'C');
        $this->SetFontSize(15);
        $this->SetFont('', 'B');
        $this->MultiCell(105, $height,  "REPORTE DE AUDITORIA", 0, 'C', 0, '', '');

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
    function reporteRequerimiento() {

        $this->SetFont('times', '', 11);
        ///$this->Cell(0, 7, ' AUDITORIAS PROGRAMADAS EN LA GESTIÓN - '." ".$this->fecha_inicio." - ".$this->fecha_fin, 1, 0, 'L', 0, '', 0);
        //$this->SetFont('times', '', 11);
        //$this->Cell(106, 7, ' Codigo de la Auditoria: ' . $this->datos[0]['nro_tramite_wf'], 1, 0, 'R', 0, '', 0);
        ///$this->ln();
        if($this->unidad != 'Todos'){
            $this->Cell(0, 7, 'ÁREA/UNIDAD: '." ".$this->unidad, 0, 0, 'L', 0, '', 0);
            $this->ln();
        }
        else{
            $this->Cell(0, 7, 'ÁREA/UNIDAD: '." ". "General", 0, 0, 'L', 0, '', 0);
            $this->ln();
        }

        $this->SetFont('times', '', 11);
        //$this->Cell(40, 0, 'De: '.$this->datos[0]['fecha_solicitud'], 1, 0, 'C', 0, '', 0);
        $this->Cell(0, 7, 'Periodo/Gestion:'." "." ".$this->fecha_inicio." - ".$this->fecha_fin, 0, 0, 'L', 0, '', 0);
        $this->ln();
        //if($this->estado == 'programado'){
            $this->Cell(0, 7, 'Estado: '." ".$this->desc_estado, 0, 0, 'L', 0, '', 0);
        /*}
        if($this->estado == 'prog_aprob'){
            $this->Cell(0, 7, 'Estado: '." Aprobado por el Responsable de Area", 0, 0, 'L', 0, '', 0);
        }*/
        //$this->Cell(0, 7, 'Estado: '." ".$this->datos[0]['nombre_estado'], 0, 0, 'L', 0, '', 0);
        $this->ln();
        $this->ln();

        $this->SetFillColor(0,255,0);
        //$this->Cell(0, 0, 'Nro.: '.$this->datos[0]['nro_tramite'], 1, 1, 'C', 0, '', 0);
        //$this->SetFillColor(249,249,249); // Grey
        //$this->SetDrawColor(0,0,255);
        //$this->SetTextColor(255,200,255);
        $cabeza_html = 'Nro.';
        $this->Cell(9, 0,$cabeza_html , 1, 0, 'C', 0, '', 0);
        //$this->Cell(28.4, 0, 'Codigo', 1, 0, 'C', 0, '', 0);
        $this->Cell(28.4, 0, 'Nro Tramite', 1, 0, 'C', 0, '', 0);
        $this->Cell(18.5, 0, 'Tipo Aud.', 1, 0, 'C', 0, '', 0);
        $this->Cell(50, 0, 'Nombre Auditoria', 1, 0, 'C', 0, '', 0);
        $this->Cell(35, 0, 'Descripcion', 1, 0, 'C', 0, '', 0);
        $this->Cell(31.2, 0, 'Area/Unidad', 1, 0, 'C', 0, '', 0);
        $this->Cell(22, 0, 'Fecha Inicio', 1, 0, 'C', 0, '', 0);
        $this->Cell(21.9, 0, 'Fecha Fin', 1, 0, 'C', 0, '', 0);
        //$this->Cell(37, 0, 'Estado Auditoria', 1, 0, 'C', 0, '', 0);
        $this->Cell(33.30, 0, 'Resp. Sugerido', 1, 0, 'C', 0, '', 0);

        //$this->SetTextColor(0,0,0);
        $this->ln();
        $numero = 1;
        $pagina = 0;
        //var_dump(count($this->datos));
        if(count($this->datos) > 0){
            foreach ($this->datos as $Row) {
                //$codigo = $Row['id_aom'];
                $nro_tramite = $Row['nro_tramite_wf'];
                $tipo_auditoria = $Row['codigo_tpo_aom'];
                $nombre_auditoria = $Row['nombre_aom1'];
                $desc_aom = $Row['descrip_aom1'];
                $area = $Row['nombre_unidad'];
                $fecha_inicio = $Row['fecha_prog_inicio'];
                $fecha_fin = $Row['fecha_prog_fin'];
                //$estado_aom = $Row['nombre_estado'];
                $responsable = $Row['desc_funcionario1'];

            $tbl = <<<EOD
    <table cellspacing="0" cellpadding="1" border="1" >
        <tr>
            <td width="32"  align="center">$numero</td>
            <!--<td width="31.6" align="center">$ codigo</td>-->
            <td width="100.6" align="center">$nro_tramite</td>
            <td width="65.4" align="center">$tipo_auditoria</td>
            <td width="177.4"  align="justify">$nombre_auditoria</td>
            <td width="123.6"  align="center">$desc_aom</td>
            <td width="110.6"  align="center">$area</td>
            <td width="78"  align="center">$fecha_inicio</td>
            <td width="77.5"  align="center">$fecha_fin</td>
            <!--<td width="100.5"  align="center">$ estado_aom</td>-->
            <td width="118.4"  align="center">$responsable</td>
        </tr>
    </table>
EOD;
                $this->SetFont('times', '', 9);
                $this->writeHTML($tbl, false, false, false, false, '');
                $numero++;
                $pagina++;
            }
        }
        else{
            $tbl = <<<EOD
    <table cellspacing="0" cellpadding="1" border="1" >
        <tr>
            <td width="100%"  align="center" colspan="9" bgcolor="#87cefa">No tiene ningún resultado que coincida con los parametros de Búsqueda...!!!</td>
        </tr>
    </table>
EOD;
            $this->SetFont('times', '', 9);
            $this->writeHTML($tbl, false, false, false, false, '');
            $numero++;
            $pagina++;
        }

    }
    function setDatos($datos,$fecha_inicio,$fecha_fin,$estado,$desc_estado,$unidad) {
        $this->datos = $datos;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->estado = $estado;
        $this->desc_estado = $desc_estado;
        $this->unidad = $unidad;
        //echo "".$this->datos.sizeof();
         //var_dump($this->fecha_inicio.", ".$this->fecha_fin);exit;
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