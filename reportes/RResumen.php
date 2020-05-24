<?php
class RResumen extends ReportePDF{
    var $datos ;
    var $ancho_hoja;
    var $gerencia;
    var $numeracion;
    var $ancho_sin_totales;
    var $cantidad_columnas_estaticas;
    function Header() {
        $this->Ln(5);
        $html = <<<EOF
        <div style="text-align: center;">
        		<p><h1><b>Resumen de Auditoria</b></h1></p>
        </div>
EOF;
        $this->writeHTML ($html);
        $this->resumen();
    }
    function resumen(){
        $fecha = date_format(date_create($this->datos[0]["fecha_prev_inicio"]), 'd/m/Y');
        $titulo = $this->datos[0]["nombre_aom1"];

        $resumen = <<<EOF
        <div style="text-align: left;">
        		<p>En fecha $fecha conforme al Programa Anual de Auditorias Internas de la Empresa se realizó la auditoria:</p>
        		<p><b>Titulo:</b> $titulo</p>
        		<p>El Equipo auditor estuvo conformado por:</p>
        		<br/>
        			
EOF;
        $this->writeHTML ($resumen);
         foreach ( $this->datos as $value){
             $funcionario = $value['desc_funcionario1'];
             $tbl = <<<EOD
             <ul>
  <li>$funcionario</li>
</ul>
EOD;
             $this->writeHTML($tbl);
         }
        $equipo = <<<EOF
        <br/>
                <p><b>CONTENIDO.-</b></p>
        		<p>Se visitaron los trabajos en las estructuras 104 (Excavación); 105 (Nivelación y puesta de Grillas); 108 
        		(Excavación) en la zona de Paracti, y levantamiento de estructuras 8 y 10 en Santibáñez.El equipo auditor pondera el compromiso y 
        		responsabilidad del personal del Area y Proceso Auditados, Asi como el personal de la Gerencia y Administración.</p>
        		<p><b>CONCLUSION.-</b></p>
        		<p>Como resultado de la auditoria se encontraron oportunidades de mejora que se presentan en el Informe de No Conformidades.</p>
        </div>
EOF;
        $this->writeHTML ($equipo);

    }
    function setDatos($datos) {
        $this->datos = $datos;
    }
    function generarReporte() {
        $this->setFontSubsetting(false);
    }
}
?>