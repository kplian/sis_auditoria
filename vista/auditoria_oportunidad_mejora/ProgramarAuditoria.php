<?php
/**
 *@package pXP
 *@file ProgramarAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.ProgramarAuditoria = {
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        nombreVista: 'ProgramarAuditoria',
        dblclickEdit: false,
        constructor: function(config) {
            this.eventoGrill();
            this.idContenedor = config.idContenedor;
            Phx.vista.ProgramarAuditoria.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.init();
            // this.store.baseParams.pes_estado = 'programada';
            this.store.baseParams.interfaz = 'ProgramarAuditoria';
            this.iniciarEvento();
            this.load({params:{ start:0, limit:this.tam_pag}});
        },
        onButtonNew: function () {
            Phx.vista.ProgramarAuditoria.superclass.onButtonNew.call(this);
            this.Cmp.id_tipo_auditoria.setValue(1);
        },
        onButtonEdit:function(){
            Phx.vista.ProgramarAuditoria.superclass.onButtonEdit.call(this);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.ProgramarAuditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.ProgramarAuditoria.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
            }
            return tb
        },
        sigEstado:function(){
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm('¿Desea APROBAR la Auditoria')){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AuditoriaOportunidadMejora/aprobarEstado',
                    params:{
                        id_proceso_wf:  id_proceso_wf,
                        id_estado_wf:   id_estado_wf
                    },
                    success:this.successWizard,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            }else {
                Phx.CP.loadingHide();
            }
        },
        successWizard:function(){
            Phx.CP.loadingHide();
            this.reload();
        },
        eventoGrill:function () {
            this.Atributos[this.getIndAtributo('descrip_aom1')].grid=false;
            this.Atributos[this.getIndAtributo('lugar')].grid=false;
            this.Atributos[this.getIndAtributo('recomendacion')].grid=false;
            this.Atributos[this.getIndAtributo('id_gconsultivo')].grid=false;
            this.Atributos[this.getIndAtributo('id_tipo_om')].grid=false;
            this.Atributos[this.getIndAtributo('id_tnorma')].grid=false;
            this.Atributos[this.getIndAtributo('id_tobjeto')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_prev_inicio')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_prev_fin')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_eje_inicio')].grid=false;
            this.Atributos[this.getIndAtributo('fecha_eje_fin')].grid=false;
            this.Atributos[this.getIndAtributo('id_funcionario')].grid=false;
            this.Atributos[this.getIndAtributo('id_destinatario')].grid=false;
            this.Atributos[this.getIndAtributo('resumen')].grid=false;
        },
        onReloadPage : function(m){
          		this.maestro = m;
          		console.log('=22222>',this);
          		this.store.baseParams = {
                    tipo_filtro :this.maestro.tipo_filtro,
          			id_gestion:  this.maestro.id_gestion,
          			desde:  this.maestro.desde,
          			hasta:  this.maestro.hasta,
                    tipo_estado : this.maestro.id_tipo_estado,
                    id_uo: this.maestro.id_uo,
          			start:0,
          			limit:50,
          			sort:'id_aom',
          			dir:'DESC',
          			interfaz:'ProgramarAuditoria',
          			contenedor: this.idContenedor
          		};
          		this.store.reload({ params: this.store.baseParams});
       },
       fwidth: '45%',
       fheight: '60%',


};
</script>
