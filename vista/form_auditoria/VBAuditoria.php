<?php
/**
 *@package pXP
 *@file VBAuditoria.php
 *@author  MMV
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    var ini=null;
    var fin=null;
    var id_gestion=null;


    Phx.vista.VBAuditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'Auditoria',
        nombreVista: 'VBAuditoria',
        constructor: function(config) {
            Phx.vista.VBAuditoria.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.getBoton('sig_estado').setVisible(false);
            this.getBoton('btnObs').setVisible(false);
            this.init();
        },
        loadValoresIniciales:function(){
            Phx.vista.VBAuditoria.superclass.loadValoresIniciales.call(this);
        },
        onReloadPage:function(param){
            console.log('ENTRA')
            this.initFiltro(param);
        },
        initFiltro: function(param){
            this.store.baseParams=param;
            this.load( { params: { start:0, limit: this.tam_pag } });
        },
        preparaMenu : function(n) {
            var rec=this.sm.getSelected();
            if(rec.data.tipo_reg != 'summary'){
                var tb = Phx.vista.VBAuditoria.superclass.preparaMenu.call(this);
                this.getBoton('btnChequeoDocumentosWf').enable();
                return tb;
            }
            else{
                this.getBoton('btnChequeoDocumentosWf').disable();
            }
            return undefined;
        },
        liberaMenu : function() {
            var tb = Phx.vista.VBAuditoria.superclass.liberaMenu.call(this);
            this.getBoton('btnChequeoDocumentosWf').disable();
        },
        postReloadPage:function(data){
            ini=data.desde;
            fin=data.hasta;
            id_gestion=data.id_gestion;
        },
    };
</script>
