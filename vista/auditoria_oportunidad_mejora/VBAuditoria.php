<?php
/**
 *@package pXP
 *@file VBAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VBAuditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'Auditoria',
        nombreVista: 'VBAuditoria',

        constructor: function(config) {
            Phx.vista.VBAuditoria.superclass.constructor.call(this,config);
            this.getBoton('ant_estado').setVisible(false);
            this.getBoton('sig_estado').setVisible(false);

            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        }
    };
</script>
