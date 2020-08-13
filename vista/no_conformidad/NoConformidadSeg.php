<?php
/**
 *@package pXP
 *@file NoConformidadSeg.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadSeg = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad',
        nombreVista: 'NoConformidadSeg',
        bedit:false,
        bnew:false,
        bdel:false,
        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            Phx.vista.NoConformidadSeg.superclass.constructor.call(this,config);
            this.store.baseParams.interfaz = this.nombreVista;
            this.load({params:{start:0, limit:this.tam_pag}});
            this.init();

            this.addButton('atras',{argument: { estado: 'anterior'},
                text:'Anterior',
                iconCls: 'batras',
                disabled:false,
                handler:this.onButtonAtras,
                tooltip: '<b>Pasar al anterior Estado</b>'
            });

            this.addButton('siguiente', {	text:'Siguiente',
                    iconCls: 'badelante',
                    disabled:true,
                    handler:this.onButtonSiguiente,
                    tooltip: '<b>Siguiente</b><p>Pasar al siguiente estado</p>'
            });
            this.addButton('btnReporte',
                {
                    text :'Informe No Conformidad',
                    iconCls : 'bpdf32',
                    disabled: false,
                    handler : this.onButtonReporte,
                    tooltip : '<b>Reporte</b><br/><b>No conformidades</b>'
                }
            );
        },
        preparaMenu:function(n){
            Phx.vista.NoConformidadSeg.superclass.preparaMenu.call(this, n);
            this.getBoton('siguiente').enable();
            this.getBoton('atras').enable();
            this.getBoton('atras').enable();
        },

        liberaMenu:function() {
            var tb = Phx.vista.NoConformidadSeg.superclass.liberaMenu.call(this);
            if (tb) {
                this.getBoton('siguiente').disable();
                this.getBoton('atras').disable();
                this.getBoton('atras').disable();
            }
        },
        onButtonAtras : function(res){
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
        onButtonSiguiente : function() {
            var rec = this.sm.getSelected();
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                'Estado de Wf',
                {
                    modal: true,
                    width: 700,
                    height: 450
                },
                {
                    data: {
                        id_estado_wf: rec.data.id_estado_wf,
                        id_proceso_wf: rec.data.id_proceso_wf
                    }
                }, this.idContenedor, 'FormEstadoWf',
                {
                    config: [{
                        event: 'beforesave',
                        delegate: this.onSaveWizard
                    }],
                    scope: this
                }
            );
        },

        onSaveWizard:function(wizard,resp){
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/siguienteEstado',
                params:{
                    id_proceso_wf_act:  resp.id_proceso_wf_act,
                    id_estado_wf_act:   resp.id_estado_wf_act,
                    id_tipo_estado:     resp.id_tipo_estado,
                    id_funcionario_wf:  resp.id_funcionario_wf,
                    id_depto_wf:        resp.id_depto_wf,
                    obs:                resp.obs,
                    json_procesos:      Ext.util.JSON.encode(resp.procesos)
                },
                success:this.successWizardS,
                failure: this.conexionFailure,
                argument:{wizard:wizard},
                timeout:this.timeout,
                scope:this
            });
        },
        successWizardS:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy();
            this.reload();
        },
        onButtonReporte :function () {
            var rec = this.sm.getSelected();
            Ext.Ajax.request({
                url:'../../sis_auditoria/control/NoConformidad/reporteNoConforPDF',

                params:{id_aom : rec.data.id_aom},
                success: this.successExport,
                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
                title:'Acciones Propuestas para la no conformidad',
                height:'50%',
                cls:'AccionPropuesta'
            }
        ],
    };

</script>
