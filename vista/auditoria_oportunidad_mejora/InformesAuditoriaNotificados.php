<?php
/**
 *@package pXP
 *@file InformesAuditoriaNotificados.php
 *@author  Maximilimiano Camacho
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformesAuditoriaNotificados = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'Auditoria',
        nombreVista: 'InformesAuditoriaNotificados',
        dblclickEdit: false,
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid=false;
            Phx.vista.InformesAuditoriaNotificados.superclass.constructor.call(this,config);
            this.getBoton('sig_estado').setVisible(false);
            this.getBoton('ant_estado').setVisible(false);
            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.addButton('notifcar_respo',{
                text:'Notificar Aceptar',
                grupo:[0],
                iconCls: 'bok',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });
            this.load({params:{start:0, limit:this.tam_pag}});
        },
        preparaMenu:function(n){
            const data = this.getSelectedData();
            const tb =this.tbar;
            Phx.vista.InformesAuditoriaNotificados.superclass.preparaMenu.call(this,n);
            this.getBoton('notifcar_respo').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            return tb
        },
        liberaMenu:function(){
            const data = this.getSelectedData();
            const tb = Phx.vista.InformesAuditoriaNotificados.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('notifcar_respo').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('diagrama_gantt').disable();
            }
            return tb
        },
        sigEstado:function(){
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm('¿Desea NOTIFICAR laa No Conformidades a sus respectivos responsables?')){
                if(confirm('Las No Conformidades seran NOTIFICADAS \n ¿Desea continuar?')) {
                    Ext.Ajax.request({
                        url: '../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
                        params: {
                            id_proceso_wf: id_proceso_wf,
                            id_estado_wf: id_estado_wf
                        },
                        success: this.successWizard,
                        failure: this.conexionFailure,
                        timeout: this.timeout,
                        scope: this
                    });
                }
            }
            Phx.CP.loadingHide();
        },
        successWizard:function(){
            Phx.CP.loadingHide();
            alert('Todas la No Conformidades han sido aceptadas.\n El informe ha sido ACEPTADO \n Se a enviado un aviso al equipo de auditores y responsables de no conformidades');
            this.reload();
        },
        arrayDefaultColumHidden:['nombre_aom1','nombre_unidad','desc_funcionario_resp',
            'nro_tramite','descrip_nc','lugar','desc_tipo_norma','desc_tipo_objeto',
            'desc_funcionario_destinatario','resumen','recomendacion'],
        rowExpander: new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<br>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Area:&nbsp;&nbsp;</b> {nombre_unidad}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Responsable Auditoria:&nbsp;&nbsp;</b> {desc_funcionario2}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo Norma:&nbsp;&nbsp;</b> {desc_tipo_norma}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Lugar:&nbsp;&nbsp;</b> {lugar}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Objeto Auditoria:&nbsp;&nbsp;</b> {desc_tipo_objeto}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Destinatario:&nbsp;&nbsp;</b> {desc_funcionario_destinatario}</p>',
            )
        }),
        south:{
                url:'../../../sis_auditoria/vista/no_conformidad/NoConformidadInforme.php',
                title:'No Conformidad',
                height:'50%',
                width: '40%',
                cls:'NoConformidadInforme'
            }

    };
</script>
