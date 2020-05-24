<?php
/**
 *@package pXP
 *@file VBInformeAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 13-08-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VBInformeAuditoria = {
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:'Auditoria - Oportunidad Mejora',
        nombreVista: 'VBInformeAuditoria',

        constructor: function(config) {
            Phx.vista.VBInformeAuditoria.superclass.constructor.call(this,config);
            this.store.baseParams.interfaz = this.nombreVista;

            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        },
        preparaMenu:function(n){
            var tb =this.tbar;
            Phx.vista.VBInformeAuditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('btnObs').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.VBInformeAuditoria.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('btnObs').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
            }
            return tb
        },
        tabsouth:[
            {
                url:'../../../sis_auditoria/vista/destinatario/VbDestinatario.php',
                title:':: Destinatario(s)',
                height:'45%',
                width: '40%',
                cls:'VbDestinatario'
            }
        ]

    };
</script>
