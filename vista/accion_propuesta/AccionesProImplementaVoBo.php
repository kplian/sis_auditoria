<?php
/**
 *@package pXP
 *@file AccionesProImplementaVoBo.php
 *@author  (szambrana)
 *@date 04-07-2019 19:53:16
 *@Este archivo se hereda de clase NoConformidad
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccionesProImplementaVoBo = {

        require:'../../../sis_auditoria/vista/accion_propuesta/AccionesPropuestaImplementadas.php',
        requireclase:'Phx.vista.AccionesPropuestaImplementadas',
        title:'Acciones',
        nombreVista: 'AccionesProImplementaVoBo',
        bedit:false,
        bnew:false,
        bdel:false,
        dblclickEdit: true,
        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;
            Phx.vista.AccionesProImplementaVoBo.superclass.constructor.call(this,config);
            this.store.baseParams.interfaz = this.nombreVista;

            this.load({params:{start:0, limit:this.tam_pag}});
        }
    };

</script>
