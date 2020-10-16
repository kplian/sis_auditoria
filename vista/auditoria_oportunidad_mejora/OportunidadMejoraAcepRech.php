<?php
/**
 *@package pXP
 *@file OportunidadMejoraAcepRech.php
 *@author  Maximilimiano Camacho
 *@date 02-10-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.OportunidadMejoraAcepRech = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'Auditoria',
        nombreVista: 'OportunidadMejoraAcepRech',
        dblclickEdit: false,

        constructor: function(config) {
            Phx.vista.OportunidadMejoraAcepRech.superclass.constructor.call(this,config);
            // this.getBoton('ant_estado').setVisible(false);
            // this.getBoton('sig_estado').setVisible(false);
            this.store.baseParams.interfaz = this.nombreVista;
            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        },
        preparaMenu:function(n){
            const data = this.getSelectedData();
            const tb =this.tbar;
            Phx.vista.OportunidadMejoraAcepRech.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            const data = this.getSelectedData();
            const tb = Phx.vista.OportunidadMejoraAcepRech.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
            }
            return tb
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/no_conformidad/NoConformidadAceptada.php',
                title:'No Conformidad',
                height:'50%',
                cls:'NoConformidadAceptada'
            }
        ]
    };
</script>
