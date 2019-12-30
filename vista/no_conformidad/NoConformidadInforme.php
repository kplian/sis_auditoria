<?php
/**
 *@package pXP
 *@file PlanificacionAOM.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadInforme = {

        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'NoConformidad',
        nombreVista: 'NoConformidadInforme',

        constructor: function(config) {
            Phx.vista.NoConformidadInforme.superclass.constructor.call(this,config);
            this.init();
            //this.load({params:{start:0, limit:this.tam_pag, v_oportunidad: '0'}});
        },
        //south:undefined,
        east: {
                url:'../../../sis_auditoria/vista/pnorma_noconformidad/PNormaNoConformidadInforme.php',
                title:'Punto(s) de Norma NC',
                height:'50%',
                width: '40%',
                cls:'PNormaNoConformidadInforme',
        },
        onReloadPage:function(m){
            this.maestro=m;
            this.store.baseParams = {id_aom: this.maestro.id_aom};
            //Ext.apply(this.Cmp.id_centro_costo.store.baseParams,{id_gestion: this.maestro.id_gestion});
            this.load({params:{start:0, limit:50}})
            //Para Ocultar un campo del formulario
            //this.ocultarComponente(this.Cmp.id_aom);
            //Para poner un campo no editable
            this.Cmp.id_aom.disable(true);
        },
        loadValoresIniciales: function () {
            Phx.vista.NoConformidadInforme.superclass.loadValoresIniciales.call(this);
            this.Cmp.id_aom.setValue(this.maestro.id_aom);
        },


    };
</script>
