<?php
/**
 *@package pXP
 *@file    ItemEntRec.php
 *@author  admin
 *@date    13/09/2016
 *@description Reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormProgramaAnual= Ext.extend(Phx.frmInterfaz, {
        Atributos : [
            {
                config:{
                    name: 'fecha_inicio',
                    fieldLabel: 'Desde',
                    allowBlank: false,
                    emptyText: 'Fecha Inicio...',
                    width: 200,
                    format: 'd/m/Y',
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                },
                type:'DateField',
                id_grupo:0,
                grid:true
            },
            {
                config:{
                    name: 'fecha_fin',
                    fieldLabel: 'Hasta',
                    allowBlank: false,
                    emptyText: 'Fecha fin...',
                    width: 200,
                    format: 'd/m/Y',
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                },
                type:'DateField',
                id_grupo:0,
                form:true
            },
            {
                config:{
                    name:'id_uo',
                    hiddenName: 'id_uo',
                    origen:'UO',
                    fieldLabel:'UO',
                    gdisplayField:'desc_uo',//mapea al store del grid
                    width: 300,
                    emptyText:'Dejar blanco para toda la empresa...',
                    baseParams: {nivel: 'si'},
                    allowBlank:true
                },
                type:'ComboRec',
                id_grupo : 0,
                form:true
            }
        ],
        title : 'Generar Reporte',
        ActSave : '../../sis_auditoria/control/AuditoriaOportunidadMejora/reporteAuditoriaAnual',
        topBar : true,
        botones : false,
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Generar Excel</b>',
        constructor : function(config) {
            Phx.vista.FormProgramaAnual.superclass.constructor.call(this, config);
            this.init();
        },
        tipo : 'reporte',
        clsSubmit : 'bprint',
        agregarArgsExtraSubmit: function() {
            this.argumentExtraSubmit.uo = this.Cmp.id_uo.getRawValue();
        }
    })
</script>
