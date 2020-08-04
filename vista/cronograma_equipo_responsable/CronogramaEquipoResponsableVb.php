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
    Phx.vista.CronogramaEquipoResponsableVb = {
        require:'../../../sis_auditoria/vista/cronograma_equipo_responsable/CronogramaEquipoResponsable.php',
        requireclase:'Phx.vista.CronogramaEquipoResponsable',
        nombreVista: 'CronogramaEquipoResponsableVb',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            Phx.vista.CronogramaEquipoResponsableVb.superclass.constructor.call(this,config);
            this.init();
        }
    };
</script>
