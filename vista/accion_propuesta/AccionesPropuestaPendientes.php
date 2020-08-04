<?php
/**
 *@package pXP
 *@file AccionesPropuestaPendientes.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesPropuestaPendientes = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionesPropuestaPendientes',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('implementar')].grid=false;
            Phx.vista.AccionesPropuestaPendientes.superclass.constructor.call(this,config);
            this.getBoton('atras').setVisible(false);
            this.getBoton('siguiente').setVisible(true);
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
        /*preparaMenu:function(n){
            Phx.vista.AccionesPropuestaPendientes.superclass.preparaMenu.call(this, n);
        },
        liberaMenu:function() {
            var tb = Phx.vista.AccionesPropuestaPendientes.superclass.liberaMenu.call(this);
            if (tb) {
            }
        },*/
        onButtonSiguiente:function () {
            Phx.CP.loadingShow();
            if(confirm('¿Acción Aprobada por Responsable?')){
                Ext.Ajax.request({
                    url:'../../sis_auditoria/control/AccionPropuesta/multiCambiarEstadoAccionPropuesta',
                    params:{
                        id_nc:  this.maestro.id_nc
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
    }
</script>
