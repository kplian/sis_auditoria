<?php
/**
 *@package pXP
 *@file PlanificarAuditoria.php
 *@author  Maximilimiano Camacho
 *@date 24-07-2019
 *@description Archivo con la interfaz de usuario que permite
 *planificar Auditoria.
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PlanificarAuditoria = {

    require:'../../../sis_auditoria/vista/auditoria_oportunidad_mejora/AuditoriaOportunidadMejora.php',
    requireclase:'Phx.vista.AuditoriaOportunidadMejora',
    title: string = ' :: Formulario Planificacion de Auditoria',
    nombreVista: 'PlanificarAuditoria',
    bdel:false,
    bnew:false,
    bedit:true,
    constructor: function(config) {
        this.idContenedor = config.idContenedor;
        Phx.vista.PlanificarAuditoria.superclass.constructor.call(this,config);
        this.store.baseParams.interfaz = this.nombreVista;
        this.iniciarEvento();
        this.events();
        this.init();

        this.load({params:{start:0, limit:this.tam_pag}});
    },
    EnableSelect: function(){
        Phx.vista.PlanificarAuditoria.superclass.EnableSelect.call(this);
    },
    preparaMenu:function(n){
        var tb =this.tbar;
        Phx.vista.AuditoriaOportunidadMejora.superclass.preparaMenu.call(this,n);
        this.getBoton('sig_estado').enable();
        this.getBoton('btnChequeoDocumentosWf').enable();
        this.getBoton('btnObs').enable();
        this.getBoton('diagrama_gantt').enable();
        this.getBoton('ant_estado').enable();
        return tb
    },
    liberaMenu:function(){
        var tb = Phx.vista.AuditoriaOportunidadMejora.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('sig_estado').disable();
            this.getBoton('btnChequeoDocumentosWf').disable();
            this.getBoton('btnObs').disable();
            this.getBoton('diagrama_gantt').disable();
            this.getBoton('ant_estado').disable();
        }
        return tb
    },
    events:function () {
        this.Cmp.nombre_aom1.disable(true);
        this.Cmp.id_tipo_auditoria.disable(true);
        this.Cmp.fecha_prog_inicio.disable(true);
        this.Cmp.fecha_prog_fin.disable(true);
        this.Cmp.id_uo.disable(true);
        this.Cmp.id_funcionario.disable(true);
    },
    onButtonEdit:function(){
        Phx.vista.AuditoriaOportunidadMejora.superclass.onButtonEdit.call(this);
        this.mostrarComponente(this.Cmp.lugar);
        this.mostrarComponente(this.Cmp.id_tnorma);
        this.mostrarComponente(this.Cmp.id_tobjeto);
    },
    tabeast:[
        {
            url:'../../../sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php',
            title:'Procesos',
            width:'45%',
            cls:'AuditoriaProceso'
        },
        {
            url:'../../../sis_auditoria/vista/equipo_responsable/EquipoResponsable.php',
            title:'Responsables',
            width:'45%',
            cls:'EquipoResponsable'
        },
        {
            url:'../../../sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php',
            title:'Puntos de Norma',
            width:'45%',
            cls:'AuditoriaNpn'
        },
        {
            url:'../../../sis_auditoria/vista/cronograma/Cronograma.php',
            title:'Cronograma',
            width:'45%',
            cls:'Cronograma'
        },
        {
            url:'../../../sis_auditoria/vista/aom_riesgo_oportunidad/AomRiesgoOportunidad.php',
            title:'Riesgo Oportunidad',
            width:'45%',
            cls:'AomRiesgoOportunidad'
        }
    ]

};
</script>
