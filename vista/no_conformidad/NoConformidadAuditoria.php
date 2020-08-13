<?php
/**
 *@package pXP
 *@file NoConformidadAuditoria.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NoConformidadAuditoria = {
        require:'../../../sis_auditoria/vista/no_conformidad/NoConformidad.php',
        requireclase:'Phx.vista.NoConformidad',
        title:'No Conformidad',
        nombreVista: 'NoConformidadAuditoria',
        bedit:false,
        bnew:false,
        bdel:false,
        id_aom: null,
        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            console.log(this.maestro);
            this.id_aom = this.maestro.id_aom;
            this.Atributos[this.getIndAtributo('revisar')].grid=false;
            this.Atributos[this.getIndAtributo('rechazar')].grid=false;
            Phx.vista.NoConformidadAuditoria.superclass.constructor.call(this,config);
            this.getBoton('btnChequeoDocumentosWf').setVisible(false);
            this.getBoton('btnNoram').setVisible(false);
            this.store.baseParams.interfaz = this.nombreVista;
            this.store.baseParams.id_aom = this.id_aom;
            this.load({params:{start:0, limit:this.tam_pag}});
            this.init();
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/accion_propuesta/AccionePropuestaAuditoria.php',
                title:'Acciones Propuestas',
                height:'50%',
                cls:'AccionePropuestaAuditoria'
            }
        ],
    };

</script>
