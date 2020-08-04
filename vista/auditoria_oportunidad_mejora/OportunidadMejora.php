<?php
/**
 *@package pXP
 *@file OportunidadMejora.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.OportunidadMejora = {
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        nombreVista: 'OportunidadMejora',
        dblclickEdit: false,
        gruposBarraTareas:[
            {name:'programada',title:'<h1 align="center">Programadas</h1>',grupo:0,height:0},
            {name:'aprobado_responsable',title:'<h1 align="left">Aprobado por Resp.</h1>',grupo:1,height:0}
        ],
        tam_pag:50,
        actualizarSegunTab: function(name, indice){
            if (this.finCons) {
                this.store.baseParams.pes_estado = name;
                this.load({params: {start: 0, limit: this.tam_pag}});
            }
        },
        bnewGroups:[0],
        bactGroups:[0,1,2],
        bdelGroups:[0],
        beditGroups:[0],
        bexcelGroups:[0,1,2],
        constructor: function(config) {
            this.eventoGrill();
            this.idContenedor = config.idContenedor;
            Phx.vista.OportunidadMejora.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.init();
            this.store.baseParams.interfaz = 'OportunidadMejora';
            this.iniciarEventoOM();
            this.load({params:{ start:0, limit:this.tam_pag}});
        },
        onButtonNew: function () {
            Phx.vista.OportunidadMejora.superclass.onButtonNew.call(this);
            this.Cmp.id_tipo_auditoria.setValue(2);
        },
        onButtonEdit:function(){
            Phx.vista.OportunidadMejora.superclass.onButtonEdit.call(this);
        },
        preparaMenu:function(n){
            const tb =this.tbar;
            Phx.vista.OportunidadMejora.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            const tb = Phx.vista.OportunidadMejora.superclass.liberaMenu.call(this);
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
            if(confirm('¿Desea APROBAR la Oportunidad de mejora')){
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
                id_gestion:  this.maestro.id_gestion,
                desde:  this.maestro.desde,
                hasta:  this.maestro.hasta,
                start:0,
                limit:50,
                sort:'id_aom',
                dir:'DESC',
                interfaz:'OportunidadMejora',
                contenedor: this.idContenedor
            };
            this.store.reload({ params: this.store.baseParams});
        },
        fwidth: '45%',
        fheight: '60%',
        iniciarEventoOM:function () {
           //  this.ocultarComponente(this.Cmp.id_tipo_om);
            this.ocultarComponente(this.Cmp.lugar);
            this.ocultarComponente(this.Cmp.id_tnorma);
            this.ocultarComponente(this.Cmp.id_tobjeto);
            // this.ocultarComponente(this.Cmp.id_gconsultivo);

            this.ocultarComponente(this.Cmp.fecha_prev_inicio);
            this.ocultarComponente(this.Cmp.fecha_prev_fin);
            this.ocultarComponente(this.Cmp.fecha_eje_inicio);
            this.ocultarComponente(this.Cmp.fecha_eje_fin);
        },

    };
</script>
