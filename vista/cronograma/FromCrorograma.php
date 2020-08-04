<?php
/**
 *@package pXP
 *@file    FormFrumla.php
 *@author  MMV
 *@date    21/12/2016
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FromCrorograma=Ext.extend(Phx.frmInterfaz,{

        ActSave:'../../sis_auditoria/control/Cronograma/insertarCronogramaRecord',
        tam_pag: 10,
        layout: 'fit',
        autoScroll: false,
        breset: false,
        constructor:function(config) {
            this.idContenedor = config.idContenedor;
            this.maestro = config;

            this.addEvents('beforesave');
            this.addEvents('successsave');
            this.buildComponentesDetalle();
            this.buildDetailGrid();
            this.buildGrupos();
            Phx.vista.FromCrorograma.superclass.constructor.call(this,config);
            this.init();
            console.log('master',this.maestro);

        },
        buildComponentesDetalle: function () {
            this.detCmp = {
                'id_actividad': new Ext.form.ComboBox({
                    fieldLabel: 'Actividad',
                    allowBlank: false,
                    emptyText: 'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_auditoria/control/Actividad/listarActividad',
                        id: 'id_actividad',
                        root: 'datos',
                        sortInfo: {
                            field: 'actividad',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_actividad', 'actividad','codigo_actividad'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'atv.actividad'}
                    }),
                    valueField: 'id_actividad',
                    displayField: 'actividad',
                    gdisplayField: 'actividad',
                    hiddenName: 'id_actividad',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '80%',
                    gwidth: 150,
                    minChars: 2,
                }),
                'nueva_actividad': new Ext.form.TextField({
                    name: 'nueva_actividad',
                    msgTarget: 'title',
                    fieldLabel: 'Otra Actividad',
                    allowBlank: false,
                }),
                'fecha_ini_activ': new Ext.form.DateField({
                    name: 'fecha_ini_activ',
                    msgTarget: 'title',
                    fieldLabel: 'Fecha Inicio',
                    allowBlank: false,
                    format: 'd/m/Y'
                }),
                'fecha_fin_activ': new Ext.form.DateField({
                    name: 'fecha_fin_activ',
                    msgTarget: 'title',
                    fieldLabel: 'Fecha Fin',
                    allowBlank: false,
                    format: 'd/m/Y'
                }),
                'hora_ini_activ': new Ext.form.TimeField({
                    name: 'hora_ini_activ',
                    msgTarget: 'title',
                    fieldLabel: 'Hora Inicio',
                    allowBlank: false,
                    format: 'H:i',
                }),
                'hora_fin_activ': new Ext.form.TimeField({
                    name: 'hora_fin_activ',
                    msgTarget: 'title',
                    fieldLabel: 'Hora Fin',
                    allowBlank: false,
                    format: 'H:i',
                })
                }
        },
        evaluaRequistos: function(){
            var i = 0;
            sw = true;
            while( i < this.Componentes.length) {
                console.log('componetes ',this.Componentes[i].isValid());
                if(!this.Componentes[i].isValid()){
                    sw = false;
                }
                i++;
            }
            return sw
        },
        onInitAdd: function(){

        },
        onCancelAdd: function(re,save){
            if(this.sw_init_add){
                this.mestore.remove(this.mestore.getAt(0));
            }
            this.sw_init_add = false;
        },
        onUpdateRegister: function(){
            this.sw_init_add = false;
        },

        onAfterEdit:function(re, o, rec, num){
            var cmb_rec = this.detCmp['id_actividad'].store.getById(rec.get('id_actividad'));
            if(cmb_rec) {
                rec.set('actividad', cmb_rec.get('actividad'));
            }
        },
        buildDetailGrid:function () {
            var Items = Ext.data.Record.create([{name:'id_aom', type:'int'}]);
            this.mestore = new Ext.data.JsonStore({
                url: '../../sis_auditoria/control/Cronograma/listarCronograma',
                id: 'id_cronograma',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_aom','id_actividad','nueva_actividad','fecha_ini_activ','fecha_fin_activ','hora_ini_activ','hora_fin_activ'],remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_cronograma',limit:'100',start:'0'}
            });

            this.editorDetaille = new Ext.ux.grid.RowEditor({saveText: 'Aceptar', name: 'btn_editor'});

            // al iniciar la edicion
            this.editorDetaille.on('beforeedit', this.onInitAdd , this);
            //al cancelar la edicion
            this.editorDetaille.on('canceledit', this.onCancelAdd , this);
            //al cancelar la edicion
            this.editorDetaille.on('validateedit', this.onUpdateRegister, this);

            this.editorDetaille.on('afteredit', this.onAfterEdit, this);
            this.megrid = new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.mestore,
                region: 'center',
                split: true,
                border: false,
                plain: true,
                plugins: [ this.editorDetaille],
                stripeRows: true,
                tbar: [{
                    text: '<i class="fa fa-plus-circle fa-lg"></i> Agregar ',
                    scope: this,
                    width: '100',
                    handler: function(){
                            var e = new Items({id_aom:this.maestro.id_aom});
                            this.editorDetaille.stopEditing();
                            this.mestore.insert(0, e);
                            this.megrid.getView().refresh();
                            this.megrid.getSelectionModel().selectRow(0);
                            this.editorDetaille.startEditing(0);
                            this.sw_init_add = true;
                    }
                },{
                    ref: '../removeBtn',
                    text: '<i class="fa fa-trash fa-lg"></i> Eliminar',
                    scope:this,
                    handler: function(){
                        this.editorDetaille.stopEditing();
                        var s = this.megrid.getSelectionModel().getSelections();
                        for(var i = 0, r; r = s[i]; i++){
                            this.mestore.remove(r);
                        }
                    }
                }],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Actividad',
                        dataIndex: 'id_actividad',
                        align: 'center',
                        width: 200,
                        renderer:function(value, p, record){return String.format('{0}', record.data['actividad']);},
                        editor: this.detCmp.id_actividad
                    },
                    {
                        header: 'Otra Actividad',
                        dataIndex: 'nueva_actividad',
                        align: 'center',
                        width: 210,
                        editor: this.detCmp.nueva_actividad
                    },
                    {
                        header: 'Fecha Inicio',
                        dataIndex: 'fecha_ini_activ',
                        align: 'center',
                        width: 110,
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''},
                        editor: this.detCmp.fecha_ini_activ
                    },
                    {
                        header: 'Fecha Fin',
                        dataIndex: 'fecha_fin_activ',
                        align: 'center',
                        width: 110,
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''},
                        editor: this.detCmp.fecha_fin_activ
                    },
                    {
                        header: 'Hora Inicio',
                        dataIndex: 'hora_ini_activ',
                        align: 'center',
                        width: 110,
                        editor: this.detCmp.hora_ini_activ
                    },
                    {
                        header: 'Hora Fin',
                        dataIndex: 'hora_fin_activ',
                        align: 'center',
                        width: 110,
                        editor: this.detCmp.hora_fin_activ
                    }
                ]
            });

        },
        buildGrupos: function(){
            this.Grupos = [{
                layout: 'border',
                border: true,
                frame:false,
                items:[this.megrid]
            }];
        },
        successSave:function(resp) {
            Phx.CP.loadingHide();
            Phx.CP.getPagina(this.idContenedorPadre).reload();
            this.panel.close();
        },
        Atributos:[],
        onSubmit: function(o) {
            var arra = [], k, me = this;
            for (k = 0; k < me.megrid.store.getCount(); k++) {
                record = me.megrid.store.getAt(k);
                console.log(record.data);
                arra[k] = record.data;
            }
            me.argumentExtraSubmit = { 'json_new_records': JSON.stringify(arra, function replacer(key, value) {
                    return value;
            }) };
            if( k > 0 &&  !this.editorDetaille.isVisible()){
                Phx.vista.FromCrorograma.superclass.onSubmit.call(this,o,undefined, true);
            }
        }
    })
</script>
