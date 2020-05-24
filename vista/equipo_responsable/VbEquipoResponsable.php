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
    Phx.vista.VbEquipoResponsable = {
        require:'../../../sis_auditoria/vista/equipo_responsable/EquipoResponsable.php',
        requireclase:'Phx.vista.EquipoResponsable',
        nombreVista: 'VbEquipoResponsable',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            Phx.vista.VbEquipoResponsable.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        }
    };
</script>
