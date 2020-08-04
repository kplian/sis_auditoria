<?php
/**
 *@package pXP
 *@file VBPlanificacionAuditoria.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesPropuestaImplementadas = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionesPropuestaImplementadas',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.AccionesPropuestaImplementadas.superclass.constructor.call(this,config);
            this.getBoton('atras').setVisible(false);
            this.getBoton('siguiente').setVisible(false);
            this.getBoton('diagrama_gantt').setVisible(false);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);
            this.init();
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_nc: this.maestro.id_nc,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}});
        },
        loadValoresIniciales: function () {
            Phx.vista.AccionePropuestaNoConformidad.superclass.loadValoresIniciales.call(this);
        },
        preparaMenu:function(n){
            Phx.vista.AccionesPropuestaImplementadas.superclass.preparaMenu.call(this, n);
        },
        liberaMenu:function() {
            var tb = Phx.vista.AccionesPropuestaImplementadas.superclass.liberaMenu.call(this);
            if (tb) {
            }
        }
    }
</script>
