<?php
/**
 *@package pXP
 *@file AccionePropuestaNoConformidad.php
 *@author  MMV
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionePropuestaNoConformidad = {
        require:'../../../sis_auditoria/vista/accion_propuesta/AccionPropuesta.php',
        requireclase:'Phx.vista.AccionPropuesta',
        nombreVista: 'AccionePropuestaNoConformidad',
       
        constructor: function(config) {
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            this.Atributos[this.getIndAtributo('implementar')].grid=false;

            Phx.vista.AccionePropuestaNoConformidad.superclass.constructor.call(this,config);
            this.getBoton('atras').setVisible(false);
            this.getBoton('siguiente').setVisible(true);
            this.getBoton('diagrama_gantt').setVisible(true);
            this.getBoton('btnChequeoDocumentosWf').setVisible(true);
            this.getBoton('btnNoram').setVisible(false);

            this.init();
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_nc: this.maestro.id_nc,interfaz : this.nombreVista};
            this.load({params:{start:0, limit:50}});
        },
        loadValoresIniciales: function () {
            Phx.vista.AccionePropuestaNoConformidad.superclass.loadValoresIniciales.call(this);
        }
    }
</script>
