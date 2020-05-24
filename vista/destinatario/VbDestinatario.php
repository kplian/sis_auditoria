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
    Phx.vista.VbDestinatario = {
        require:'../../../sis_auditoria/vista/destinatario/Destinatario.php',
        requireclase:'Phx.vista.Destinatario',
        nombreVista: 'VbDestinatario',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            Phx.vista.VbDestinatario.superclass.constructor.call(this,config);
            this.init();
        }
    };
</script>
