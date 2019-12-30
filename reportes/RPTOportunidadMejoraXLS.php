<?php
class RPTOportunidadMejoraXLS {
    private $docexcel;
    private $objWriter;
    private $numero;
    private $equivalencias=array();
    private $objParam;
    public  $url_archivo;

    private $datos;
    private $fecha_inicio;
    private $fecha_fin;
    private $estado;
    private $desc_estado;
    private $unidad;


    function __construct(CTParametro $objParam) {
        $this->objParam = $objParam;
        $this->url_archivo = "../../../reportes_generados/".$this->objParam->getParametro('nombre_archivo');
        set_time_limit(400);
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize'  => '10MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $this->docexcel = new PHPExcel();
        $this->docexcel->getProperties()->setCreator("PXP")
            ->setLastModifiedBy("PXP")
            ->setTitle($this->objParam->getParametro('titulo_archivo'))
            ->setSubject($this->objParam->getParametro('titulo_archivo'))
            ->setDescription('Reporte "'.$this->objParam->getParametro('titulo_archivo').'", generado por el framework PXP')
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Report File");

        // Para establecer orientacion de la pagina
        // Orientacion vertical
        /*$this->docexcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $this->docexcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);*/
        // Orientacion horizontal
        $this->docexcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        //$this->docexcel->getActiveSheet()->getPageSetup()->setOrientation("landscape");

        $this->equivalencias=array( 0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',
            9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',
            18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',
            26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',
            34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',
            42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',
            50=>'AY',51=>'AZ',
            52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',
            60=>'BI',61=>'BJ',62=>'BK',63=>'BL',64=>'BM',65=>'BN',66=>'BO',67=>'BP',
            68=>'BQ',69=>'BR',70=>'BS',71=>'BT',72=>'BU',73=>'BV',74=>'BW',75=>'BX',
            76=>'BY',77=>'BZ',
            78=>'CA',79=>'CB',80=>'CC',81=>'CD',82=>'CE',83=>'CF',84=>'CG',85=>'CH',
            86=>'CI',87=>'CJ',88=>'CK',89=>'CL',90=>'CM',91=>'CN',92=>'CO',93=>'CP',
            94=>'CQ',95=>'CR',96=>'CS',97=>'CT',98=>'CU',99=>'CV',100=>'CW',101=>'CX',
            102=>'CY',103=>'CZ',
            104=>'DA',105=>'DB',106=>'DC',107=>'DD',108=>'DE',109=>'DF',110=>'DG',111=>'DH',
            112=>'DI',113=>'DJ',114=>'DK',115=>'DL',116=>'DM',117>'DN',118=>'DO',119=>'DP',
            120=>'DQ',121=>'DR',122=>'DS',123=>'DT',124=>'DU',125=>'DV',126=>'DW',127=>'DX',
            128=>'DY',129=>'DZ',

            130=>'EA',131=>'EB',132=>'EC',133=>'ED',134=>'EE',135=>'EF',136=>'EG',137=>'EH',
            138=>'EI',139=>'EJ',140=>'EK',141=>'EL',142=>'EM',143>'EN',144=>'EO',145=>'EP',
            146=>'EQ',147=>'ER',148=>'ES',149=>'ET',150=>'EU',151=>'EV',152=>'EW',153=>'EX',
            154=>'EY',155=>'EZ');
    }
    //
    function imprimeCabecera() {
        $this->docexcel->createSheet();
        $this->docexcel->getActiveSheet()->setTitle('Reporte de Auditoria');
        $this->docexcel->setActiveSheetIndex(0);
        //$datos = $this->objParam->getParametro('datos');

        $funcionario = $this->objParam->getParametro('funcionario');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath(dirname(__FILE__) . '/../../pxp/lib' . $_SESSION['_DIR_LOGO']);
        $objDrawing->setCoordinates('A1'); //setOffsetX works properly
        $objDrawing->setOffsetX(5);
        $objDrawing->setOffsetY(5); //set width, height
        $objDrawing->setWidth(250);
        $objDrawing->setHeight(87);
        $objDrawing->setWorksheet($this->docexcel->getActiveSheet());

        $styleTitulosH1 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Arial'
                //'name'  => 'Time New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleTitulos2 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '0066CC'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            ),
            /*'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,

                ),
            )*/
        );
        $styleTitulos3 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 10,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleTitulosH4 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 10,
                //'name'  => 'Arial'
                //'name'  => 'Lucida Sans Unicode'
                'name'  => 'Time New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleTitulosH5 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 8,
                //'name'  => 'Arial Narrow'
                'name'  => 'Time New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        //if($this->estado == 'programado' || $this->estado == 'prog_aprob'){
            $this->docexcel->getActiveSheet()->getStyle('C3:H3')->applyFromArray($styleTitulosH1);
            $this->docexcel->getActiveSheet()->mergeCells('C3:H3');
            $this->docexcel->getActiveSheet()->setCellValue('C3','REPORTE DE AUDITORIA');
            /*============================== Parametros de Reporte de Auditoria ==============*/
            $this->docexcel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($styleTitulosH4);
            $this->docexcel->getActiveSheet()->mergeCells('A6:D6');
            $this->docexcel->getActiveSheet()->setCellValue('A6',"Area/Unidad: "." ".$this->unidad);

            $this->docexcel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($styleTitulosH4);
            $this->docexcel->getActiveSheet()->mergeCells('A7:D7');
            $this->docexcel->getActiveSheet()->setCellValue('A7',"Periodo: "." ".$this->fecha_inicio." - ".$this->fecha_fin);

            $this->docexcel->getActiveSheet()->getStyle('A8:D8')->applyFromArray($styleTitulosH4);
            $this->docexcel->getActiveSheet()->mergeCells('A8:D8');
            $this->docexcel->getActiveSheet()->setCellValue('A8',"Estado: "." ".$this->desc_estado);

            /*============================== Datos del Usuraio del Reporte ====================*/
            $this->docexcel->getActiveSheet()->getStyle('G4:H4')->applyFromArray($styleTitulosH5);
            $this->docexcel->getActiveSheet()->mergeCells('G4:H4');
            $this->docexcel->getActiveSheet()->setCellValue('G4',"Usuario: "." ".$funcionario[0]['desc_person']);

            $this->docexcel->getActiveSheet()->getStyle('G5:H5')->applyFromArray($styleTitulosH5);
            $this->docexcel->getActiveSheet()->mergeCells('G5:H5');
            $this->docexcel->getActiveSheet()->setCellValue('G5',"Fecha: "." ".date_create()->format('d-m-Y'));

            $this->docexcel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($styleTitulosH5);
            $this->docexcel->getActiveSheet()->mergeCells('G6:H6');
            $this->docexcel->getActiveSheet()->setCellValue('G6',"Hora: "." ".date_create()->format('H:i:s'));

            //$this->docexcel->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);

            /*===================== configuracion de ancho de las Columnas ==================*/
            $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
            $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->docexcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->docexcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $this->docexcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->docexcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);

            $this->docexcel->getActiveSheet()->getRowDimension(9)->setRowHeight(25);

            //$this->docexcel->getActiveSheet()->getStyle('I10')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('A9:I9')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('A9:I9')->applyFromArray($styleTitulos2);
            //*************************************Cabecera*****************************************
            $this->docexcel->getActiveSheet()->setCellValue('A9','Nº');
            $this->docexcel->getActiveSheet()->setCellValue('B9','NRO TRAMITE');
            $this->docexcel->getActiveSheet()->setCellValue('C9','TIPO');
            $this->docexcel->getActiveSheet()->setCellValue('D9','NOMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('E9','DESCRIPCION');
            $this->docexcel->getActiveSheet()->setCellValue('F9','GRUPO CONSULTIVO');
            $this->docexcel->getActiveSheet()->setCellValue('G9','UNIDAD');
            $this->docexcel->getActiveSheet()->setCellValue('H9','FECHA INICIO');
            $this->docexcel->getActiveSheet()->setCellValue('I9','FECHA FIN');

            /*============================ Para Ajustar texto ==========================*/
            $this->docexcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);
            $this->docexcel->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);
        //}

    }
    //
    function generarDatos() {
        $styleTitulos3 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 10,
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '707A82'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $this->numero = 1;
        $fila = 10;
        $datos = $this->objParam->getParametro('datos');
        //var_dump($datos);
        $this->imprimeCabecera(0);
        //if($this->estado == 'programado' || $this->estado == 'prog_aprob'){
            foreach ($this->datos as $value){
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $this->numero);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $value['nro_tramite_wf']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, trim($value['codigo_tpo_aom']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, trim($value['nombre_aom1']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, trim($value['descrip_aom1']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, trim($value['nombre_gconsultivo']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, trim($value['nombre_unidad']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $value['fecha_prog_inicio']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $value['fecha_prog_fin']);

                $fila++;
                $this->numero++;

            }
        //}
        /*if($this->estado != 'programado' && $this->estado != 'prog_aprob'){

            foreach ($this->datos as $value){
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $this->numero);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $value['nro_tramite_wf']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, trim($value['codigo_tpo_aom']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, trim($value['nombre_aom1']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, trim($value['descrip_aom1']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, trim($value['nombre_unidad']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $value['fecha_prog_inicio']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $value['fecha_prog_fin']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, trim($value['tipo_ctrl_auditoria']));
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, trim($value['desc_funcionario1']));

                $fila++;
                $this->numero++;
            }
        }*/
        /*$this->docexcel->getActiveSheet()->getStyle('B'.($fila+1).':F'.($fila+1).'')->applyFromArray($styleTitulos3);

        $this->docexcel->getActiveSheet()->getStyle('E'.(6).':E'.($fila+1).'')->getNumberFormat()->setFormatCode('#,##0.00');
        $this->docexcel->getActiveSheet()->getStyle('F'.(6).':F'.($fila+1).'')->getNumberFormat()->setFormatCode('#,##0.00');

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila+1,'TOTAL');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila+1,'=SUM(E6:E'.($fila-1).')');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila+1,'=SUM(F6:F'.($fila-1).')');


        $deb = 'SUM(E6:E'.($fila-1).')';
        $hab = 'SUM(F6:F'.($fila-1).')';
        $vari = '=+'.$deb.'-'.$hab;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila+3,'SALDO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila+3,$vari);*/

        //var_dump($fila-1);

    }
    //
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
    function generarReporte(){
        //$this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);
        $this->imprimeCabecera(0);
    }

    /*function generarResultado ($sheet,$a){
        $this->docexcel->createSheet($sheet);
        $this->docexcel->setActiveSheetIndex(0);
        $this->imprimeCabecera($sheet,'TOTAL');
        $this->docexcel->getActiveSheet()->setTitle('TOTALES');
        $this->docexcel->getActiveSheet()->setCellValue('E5','TOTAL');
        $this->docexcel->getActiveSheet()->setCellValue('F5',$a);
    }*/
}
?>