<?php
/**
 *@package pXP
 *@file NoConformidadSinAcciones.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadSinAcciones = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad',
        nombreVista: 'NoConformidadSinAcciones',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: false,
        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.NoConformidadSinAcciones.superclass.constructor.call(this,config);

            /// this.getBoton('btnChequeoDocumentosWf').setVisible(false);
            this.getBoton('btnNoram').setVisible(false);

            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.addButton('notifcar_respo',{
                text:'Notificar Resp.',
                iconCls: 'bok',
                disabled: true,
                handler: this.sigEstado,
                tooltip: '<b>Pasar al Siguiente Estado</b>'
            });

            this.addButton('atras',{argument: { estado: 'anterior'},
                text:'Anterior',
                iconCls: 'batras',
                disabled:true,
                handler:this.onButtonAtras,
                tooltip: '<b>Pasar al anterior Estado</b>'});
            this.store.baseParams.interfaz = 'NoConformidadSinAcciones';
            this.load({params:{start:0, limit:this.tam_pag}});

        },
        sigEstado:function(){
            Phx.CP.loadingShow();
            const rec = this.sm.getSelected();
            const id_estado_wf = rec.data.id_estado_wf;
            const id_proceso_wf = rec.data.id_proceso_wf;
            if(confirm('Deseas NOTIFICAR y SOLICITAR APROBACION de las acciones al Responsable de Area de la No Conformidad?')) {
                if (confirm('Las acciones serán NOTIFICADAS  al Responsable de Area de la no Conformmidad \n ¿Desea continuar?')) {
                   Ext.Ajax.request({
                        url: '../../sis_auditoria/control/NoConformidad/aprobarEstado',
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
            alert('Continuar');
            this.reload();
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.NoConformidadSinAcciones.superclass.preparaMenu.call(this,n);
            this.getBoton('notifcar_respo').enable();
            this.getBoton('atras').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.NoConformidadSinAcciones.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('notifcar_respo').disable();
                this.getBoton('atras').disable();
            }
            return tb
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/accion_propuesta/AccionePropuestaAuditoria.php',
                title:'Acciones',
                height:'50%',
                cls:'AccionePropuestaAuditoria'
            }
        ],
        onButtonAtras : function(res){
            //console.log("entra atras");
            var rec=this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
                'Estado de Wf',
                {
                    modal:true,
                    width:450,
                    height:250
                }, { data:rec.data, estado_destino: res.argument.estado}, this.idContenedor,'AntFormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onAntEstado
                    }
                    ],
                    scope:this
                });
        },
        onAntEstado: function(wizard,resp){
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/anteriorEstado',
                params:{
                    id_proceso_wf: resp.id_proceso_wf,
                    id_estado_wf:  resp.id_estado_wf,
                    obs: resp.obs,
                    estado_destino: resp.estado_destino
                },
                argument:{wizard:wizard},
                success:this.successEstadoSinc,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        successEstadoSinc:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy();
            this.reload();
        },
    };

</script>
