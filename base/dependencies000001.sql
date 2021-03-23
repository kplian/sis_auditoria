/***********************************I-DEP-MMV-SSOM-6-4/9/2020*****************************************/
----------------------------------
--COPY LINES TO dependencies.sql FILE
---------------------------------
select pxp.f_insert_testructura_gui ('SSOM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('nor', 'cnor');
select pxp.f_delete_testructura_gui ('cges', 'SSOM');
select pxp.f_insert_testructura_gui ('config', 'SSOM');
select pxp.f_delete_testructura_gui ('GAUDI', 'SSOM');
select pxp.f_insert_testructura_gui ('PDAU', 'config');
select pxp.f_insert_testructura_gui ('PRM', 'PDAU');
select pxp.f_insert_testructura_gui ('TPR', 'PDAU');
select pxp.f_insert_testructura_gui ('CFADM', 'config');
select pxp.f_insert_testructura_gui ('GCT', 'CFADM');
select pxp.f_insert_testructura_gui ('PCS', 'CFADM');
select pxp.f_insert_testructura_gui ('TAU', 'CFADM');
select pxp.f_insert_testructura_gui ('SINT', 'CFADM');
select pxp.f_delete_testructura_gui ('PAUDI', 'AUDIN');
select pxp.f_delete_testructura_gui ('PAUD', 'AUDIN');
select pxp.f_delete_testructura_gui ('INFEA', 'AUDIN');
select pxp.f_delete_testructura_gui ('AUDIN', 'GAUDI');
select pxp.f_delete_testructura_gui ('INFOM', 'AUDIN');
select pxp.f_delete_testructura_gui ('VBAOM', 'GAUDI');
select pxp.f_delete_testructura_gui ('VBPLA', 'VBAOM');
select pxp.f_delete_testructura_gui ('VBINFA', 'VBAOM');
select pxp.f_delete_testructura_gui ('VBAUD', 'VBAOM');
select pxp.f_delete_testructura_gui ('RPTAUD', 'GAUDI');
select pxp.f_insert_testructura_gui ('RPTA', 'RPTAUD');
select pxp.f_insert_testructura_gui ('RPTOM', 'RPTAUD');
select pxp.f_delete_testructura_gui ('NCSEG', 'cges');
select pxp.f_insert_testructura_gui ('cnor', 'config');
select pxp.f_insert_testructura_gui ('ATV', 'CFADM');
select pxp.f_insert_testructura_gui ('ROP', 'config');
select pxp.f_insert_testructura_gui ('PROB', 'ROP');
select pxp.f_insert_testructura_gui ('IMP', 'ROP');
select pxp.f_insert_testructura_gui ('ARO', 'ROP');
select pxp.f_insert_testructura_gui ('RIOP', 'ROP');
select pxp.f_insert_testructura_gui ('TRO', 'ROP');
select pxp.f_delete_testructura_gui ('SER', 'GAUDI');
select pxp.f_delete_testructura_gui ('IFS', 'SER');
select pxp.f_delete_testructura_gui ('NSC', 'SER');
select pxp.f_insert_testructura_gui ('PAY', 'RPTAUD');
select pxp.f_delete_testructura_gui ('SAS', 'SER');
select pxp.f_delete_testructura_gui ('VBAUD', 'AUDIN');
select pxp.f_insert_testructura_gui ('AUD', 'SSOM');
select pxp.f_insert_testructura_gui ('PAUD', 'AUD');
select pxp.f_insert_testructura_gui ('PAUDI', 'AUD');
select pxp.f_insert_testructura_gui ('INFEA', 'AUD');
select pxp.f_insert_testructura_gui ('RPTAUD', 'SSOM');
select pxp.f_insert_testructura_gui ('ODM', 'SSOM');
select pxp.f_delete_testructura_gui ('SGUI', 'RPTAUD');
select pxp.f_insert_testructura_gui ('SGUI', 'SSOM');
select pxp.f_insert_testructura_gui ('NCP', 'AUD');
select pxp.f_insert_testructura_gui ('ION', 'SGUI');
select pxp.f_insert_testructura_gui ('OMP', 'ODM');
select pxp.f_insert_testructura_gui ('ODMS', 'ODM');
select pxp.f_insert_testructura_gui ('POMD', 'ODM');
select pxp.f_insert_testructura_gui ('NSC', 'SGUI');
select pxp.f_insert_testructura_gui ('APD', 'SGUI');
select pxp.f_insert_testructura_gui ('AID', 'SGUI');
/***********************************F-DEP-MMV-SSOM-6-4/9/2020*****************************************/
/***********************************I-DEP-MMV-SSOM-6-13/9/2020*****************************************/
select pxp.f_insert_testructura_gui ('AUDI', 'SGUI');
/***********************************F-DEP-MMV-SSOM-6-13/8/2020*****************************************/

/***********************************I-DEP-MMV-SSOM-11-23/3/2021*****************************************/
select pxp.f_insert_testructura_gui ('ER', 'PDAU');
/***********************************F-DEP-MMV-SSOM-11-23/3/2021*****************************************/

/***********************************I-DEP-MMV-SSOM-11-1-23/3/2021*****************************************/
select wf.f_import_ttipo_documento_estado ('insert','prueba','SAUDIT','vob_programado','SAUDIT','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','EVI','ACPRO','implementada','ACPRO','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','EVI','ACPRO','vbimplementada_responsable','ACPRO','exigir','superior','');
select wf.f_import_ttipo_documento_estado ('insert','EVIS','ACPRO','implementada','ACPRO','eliminar','superior','');
select wf.f_import_ttipo_documento_estado ('insert','EVIAP','NOCON','vbnoconformidad','NOCON','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','EVIAP','NOCON','propuesta','NOCON','insertar','superior','');
/***********************************F-DEP-MMV-SSOM-11-1-23/3/2021*****************************************/




