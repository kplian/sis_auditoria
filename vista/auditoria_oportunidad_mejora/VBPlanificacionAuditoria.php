<?php
/**
 *@package pXP
 *@file VBPlanificacionAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 18-09-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VBPlanificacionAuditoria = {
        require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
        requireclase:'Phx.vista.AuditoriaOportunidadMejora',
        title:' :: Formulario Registro de Auditoria - Oportunidad Mejora',
        nombreVista: 'VBPlanificacionAuditoria',
        bedit:false,
        bnew:false,
        bsave:false,
        bdel:false,

        constructor: function(config) {
            Phx.vista.VBPlanificacionAuditoria.superclass.constructor.call(this,config);
            this.store.baseParams.interfaz = this.nombreVista;

            this.init();
            this.load({params:{start:0, limit:this.tam_pag}});
        },
        preparaMenu:function(n){
            var tb =this.tbar;
            Phx.vista.VBPlanificacionAuditoria.superclass.preparaMenu.call(this,n);
            this.getBoton('sig_estado').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('btnObs').enable();
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('ant_estado').enable();
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.VBPlanificacionAuditoria.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('sig_estado').disable();
                this.getBoton('btnChequeoDocumentosWf').disable();
                this.getBoton('btnObs').disable();
                this.getBoton('diagrama_gantt').disable();
                this.getBoton('ant_estado').disable();
            }
            return tb
        },
        tabeast:[
            {
                url:'../../../sis_auditoria/vista/auditoria_proceso/VbAuditoriaProceso.php',
                title:'Procesos',
                width:'35%',
                cls:'VbAuditoriaProceso'
            },
            {
                url:'../../../sis_auditoria/vista/equipo_responsable/VbEquipoResponsable.php',
                title:'Responsables',
                width:'35%',
                cls:'VbEquipoResponsable'
            },
            {
                url:'../../../sis_auditoria/vista/auditoria_npn/VbAuditoriaNpn.php',
                title:'Puntos de Norma',
                width:'35%',
                cls:'VbAuditoriaNpn'
            },
            {
                url:'../../../sis_auditoria/vista/cronograma/VbCronograma.php',
                title:'Cronograma',
                width:'35%',
                cls:'VbCronograma'
            }
        ]
    };
</script>
