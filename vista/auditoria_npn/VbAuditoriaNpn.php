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
    Phx.vista.VbAuditoriaNpn = {
        require:'../../../sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php',
        requireclase:'Phx.vista.AuditoriaNpn',
        nombreVista: 'VbAuditoriaNpn',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        constructor: function(config) {
            Phx.vista.VbAuditoriaNpn.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        }
    };
</script>
