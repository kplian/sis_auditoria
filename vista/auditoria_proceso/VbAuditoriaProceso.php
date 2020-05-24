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
    Phx.vista.VbAuditoriaProceso = {
        require:'../../../sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php',
        requireclase:'Phx.vista.AuditoriaProceso',
        nombreVista: 'VbAuditoriaProceso',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            Phx.vista.VbAuditoriaProceso.superclass.constructor.call(this,config);
            this.init();
        }
    };
</script>
