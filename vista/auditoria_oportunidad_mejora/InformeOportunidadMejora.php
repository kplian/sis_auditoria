<?php
/**
 *@package pXP
 *@file InformeOportunidadMejora.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.InformeOportunidadMejora = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,

        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'AuditoriaOportunidadMejora',
        nombreVista: 'InformeOportunidadMejora',

        constructor: function(config) {
            this.idContenedor = config.idContenedor;
            Phx.vista.InformeOportunidadMejora.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});

        },
       tabsouth:[
            {
                url:'../../../sis_auditoria/vista/destinatario/Destinatario.php',
                title:':: Destinatario(s)',
                height:'45%',
                width: '40%',
                cls:'Destinatario'
            }
        ]

    };
</script>
