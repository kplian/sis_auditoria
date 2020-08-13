<?php
/**
 *@package pXP
 *@file Auditoria.php
 *@author  Maximilimiano Camacho
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Auditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        dblclickEdit: false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejoraBase.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejoraBase',
        title:'Auditoria',
        nombreVista: 'Auditoria',
        constructor: function(config) {
            this.maestro=config.maestro;
            Phx.vista.Auditoria.superclass.constructor.call(this,config);
            this.init();
            this.addBotonesGantt();
            this.addButton('btnChequeoDocumentosWf',{ text: 'Documentos',  iconCls: 'bchecklist',  disabled: true,  handler: this.loadCheckDocumentosRecWf,  tooltip: '<b>Documentos de la No conformidad</b><br/>Subir los documentos de evidencia.'});
            this.addButton('btnNoConf',{text :'No Conformida',iconCls:'bdocuments',disabled: true, handler : this.onNoCoformidad,tooltip : '<b>No conformidad</b>'});
            this.addButton('btmAccion', {text: 'Acciones Correctivas', iconCls: 'bpdf32', disabled: true, handler: this.onReporte, tooltip: '<b>Verificación de Acciones Correctivas Implementadas</b>'});
        },
        addBotonesGantt: function() {
            this.menuAdqGantt = new Ext.Toolbar.SplitButton({
                id: 'b-diagrama_gantt-' + this.idContenedor,
                text: 'Gantt',
                disabled: true,
                iconCls : 'bgantt',
                handler:this.diagramGanttDinamico,
                scope: this,
                menu:{
                    items: [{
                        id:'b-gantti-' + this.idContenedor,
                        text: 'Gantt Imagen',
                        tooltip: '<b>Muestra un reporte gantt en formato de imagen</b>',
                        handler:this.diagramGantt,
                        scope: this
                    }, {
                        id:'b-ganttd-' + this.idContenedor,
                        text: 'Gantt Dinámico',
                        tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
                        handler:this.diagramGanttDinamico,
                        scope: this
                    }
                    ]}
            });
            this.tbar.add(this.menuAdqGantt);
        },
        diagramGantt : function (){
            var data=this.sm.getSelected().data.id_proceso_wf;
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
                params: { 'id_proceso_wf': data },
                success: this.successExport,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        diagramGanttDinamico : function(){
            var data=this.sm.getSelected().data.id_proceso_wf;
            window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
        },
        preparaMenu:function(n){
            const data = this.getSelectedData();
            const tb =this.tbar;
            Phx.vista.Auditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('btnNoConf').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('btmAccion').enable();
            // this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            const data = this.getSelectedData();
            const tb = Phx.vista.Auditoria.superclass.liberaMenu.call(this);
            if(tb){
               this.getBoton('btnNoConf').disable();
               this.getBoton('btnChequeoDocumentosWf').disable();
               this.getBoton('btmAccion').disable();
               //  this.getBoton('ant_estado').disable();
            }
            return tb
        },
        onReloadPage:function(param){
            //Se obtiene la gestión en función de la fecha del comprobante para filtrar partidas, cuentas, etc.
            var me = this;
            this.initFiltro(param);
        },

        initFiltro: function(param){
            this.store.baseParams.interfaz = this.nombreVista;
            this.store.baseParams.id_gestion = param.id_gestion;
            this.store.baseParams.desde = param.desde;
            this.store.baseParams.hasta = param.hasta;
            this.store.baseParams.id_tipo_auditoria = param.id_tipo_auditoria;
            this.store.baseParams.tipo_estado = param.tipo_estado;
            this.store.baseParams.id_uo = param.id_uo;
            this.load( { params: { start:0, limit: this.tam_pag } });
        },
        postReloadPage:function(data){
            console.log(data)
        },
        onNoCoformidad:function(){
            var rec = this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_auditoria/vista/no_conformidad/NoConformidadAuditoria.php', 'No Conformidades',{
                width:'90%',
                height:'90%'
            }, rec.data,this.idContenedor, 'NoConformidadAuditoria');
        },
        loadCheckDocumentosRecWf:function() {
            var rec=this.sm.getSelected();
            rec.data.nombreVista = this.nombreVista;
            Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
                'Chequear documento del WF',
                {
                    width:'90%',
                    height:500
                },
                rec.data,
                this.idContenedor,
                'DocumentoWf'
            )
        },
        onReporte:function(){
            const rec=this.sm.getSelected();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/reporteAcciones',
                params:{'id_proceso_wf':rec.data.id_proceso_wf},
                success: this.successExport,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp',
            'nro_tramite','descrip_nc','lugar','desc_tipo_norma','desc_tipo_objeto',
            'desc_funcionario_destinatario','resumen','recomendacion'],
        rowExpander: new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<br>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre Auditoria:&nbsp;&nbsp;</b> {nombre_aom1}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario2}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo Norma:&nbsp;&nbsp;</b> {desc_tipo_norma}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Lugar:&nbsp;&nbsp;</b> {lugar}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Objeto Auditoria:&nbsp;&nbsp;</b> {desc_tipo_objeto}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Destinatario:&nbsp;&nbsp;</b> {desc_funcionario_destinatario}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Recomendacion:&nbsp;&nbsp;</b> {recomendacion}</p>',
            )
        })
    };
</script>
