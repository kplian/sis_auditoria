/********************************************I-DEP-MMV-SSOM-01/04/2021********************************************/
select pxp.f_insert_testructura_gui ('SSOM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('nor', 'cnor');
select pxp.f_insert_testructura_gui ('config', 'SSOM');
select pxp.f_insert_testructura_gui ('PDAU', 'config');
select pxp.f_insert_testructura_gui ('PRM', 'PDAU');
select pxp.f_insert_testructura_gui ('TPR', 'PDAU');
select pxp.f_insert_testructura_gui ('CFADM', 'config');
select pxp.f_insert_testructura_gui ('GCT', 'CFADM');
select pxp.f_insert_testructura_gui ('PCS', 'CFADM');
select pxp.f_insert_testructura_gui ('TAU', 'CFADM');
select pxp.f_insert_testructura_gui ('cnor', 'config');
select pxp.f_insert_testructura_gui ('ATV', 'CFADM');
select pxp.f_insert_testructura_gui ('ROP', 'config');
select pxp.f_insert_testructura_gui ('PROB', 'ROP');
select pxp.f_insert_testructura_gui ('IMP', 'ROP');
select pxp.f_insert_testructura_gui ('ARO', 'ROP');
select pxp.f_insert_testructura_gui ('RIOP', 'ROP');
select pxp.f_insert_testructura_gui ('TRO', 'ROP');
select pxp.f_insert_testructura_gui ('PAY', 'RPTAUD');
select pxp.f_insert_testructura_gui ('AUD', 'SSOM');
select pxp.f_insert_testructura_gui ('RPTAUD', 'SSOM');
select pxp.f_insert_testructura_gui ('ODM', 'SSOM');
select pxp.f_insert_testructura_gui ('ODMS', 'ODM');
select pxp.f_insert_testructura_gui ('ER', 'PDAU');
select pxp.f_insert_testructura_gui ('PAUD', 'AUD');
select pxp.f_insert_testructura_gui ('PAUDI', 'AUD');
select pxp.f_insert_testructura_gui ('INFEA', 'AUD');
select pxp.f_insert_testructura_gui ('OMP', 'ODM');
select pxp.f_insert_testructura_gui ('PRL', 'SSOM');
select pxp.f_insert_testructura_gui ('ION', 'PRL');
select pxp.f_insert_testructura_gui ('NCP', 'PRL');
select pxp.f_insert_testructura_gui ('NCA', 'PRL');
select pxp.f_insert_testructura_gui ('AIP', 'PRL');
select pxp.f_insert_testructura_gui ('ICS', 'PRL');
select pxp.f_insert_testructura_gui ('APA', 'PRL');
/********************************************F-DEP-MMV-SSOM-01/04/2021********************************************/


/********************************************I-DEP-MMV-SSOM-2-01/04/2021********************************************/

--- No conformidad

select wf.f_import_ttipo_documento_estado ('insert','DOCE','NOCS','propuesta','NOCS','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','DOCE','NOCS','propuesta','NOCS','insertar','superior','');
select wf.f_import_ttipo_documento_estado ('insert','DOCE','NOCS','propuesta','NOCS','eliminar','superior','');
select wf.f_import_ttipo_documento_estado ('insert','NOCOF','NOCS','aceptada_resp','NOCS','insertar','superior','');
select wf.f_import_ttipo_documento_estado ('insert','DOCE','NOCS','aceptada_resp','NOCS','eliminar','superior','');

/********************************************F-DEP-MMV-SSOM-2-01/04/2021********************************************/


/********************************************I-DEP-MMV-SSOM-3-01/04/2021********************************************/
CREATE VIEW ssom.vparametro_aom (
                                 id_parametro_aom,
                                 id_aom,
                                 codigo_aom,
                                 nombre_aom1,
                                 id_parametro,
                                 id_tipo_parametro,
                                 tipo_parametro,
                                 valor_parametro)
AS
SELECT paom.id_parametro_aom,
       aom.id_aom,
       aom.codigo_aom,
       aom.nombre_aom1,
       par.id_parametro,
       tpa.id_tipo_parametro,
       tpa.tipo_parametro,
       par.valor_parametro
FROM ssom.tparametro par
         JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro = tpa.id_tipo_parametro
         JOIN ssom.tparametro_aom paom ON par.id_parametro = paom.id_parametro
         JOIN ssom.tauditoria_oportunidad_mejora aom ON paom.id_aom = aom.id_aom
ORDER BY paom.id_parametro_aom;

ALTER VIEW ssom.vparametro_aom
    OWNER TO postgres;

CREATE OR REPLACE VIEW ssom.vparametro_tipo_om(
                                               id_parametro_tom,
                                               id_tipo_parametro_tom,
                                               tipo_parametro_tom,
                                               valor_parametro_tom,
                                               codigo_parametro)
AS
SELECT par.id_parametro AS id_parametro_tom,
       tpa.id_tipo_parametro AS id_tipo_parametro_tom,
       tpa.tipo_parametro AS tipo_parametro_tom,
       par.valor_parametro AS valor_parametro_tom,
       par.codigo_parametro
FROM ssom.tparametro par
         JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro =
                                          tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'TIPO_OPORTUNIDAD_MEJORA'::text
ORDER BY par.id_parametro;

CREATE OR REPLACE VIEW ssom.vparametro_tnorma(
                                              id_parametro_tn,
                                              id_tipo_parametro_tn,
                                              tipo_parametro_tn,
                                              valor_parametro_tn,
                                              codigo_parametro)
AS
SELECT par.id_parametro AS id_parametro_tn,
       tpa.id_tipo_parametro AS id_tipo_parametro_tn,
       tpa.tipo_parametro AS tipo_parametro_tn,
       par.valor_parametro AS valor_parametro_tn,
       par.codigo_parametro
FROM ssom.tparametro par
         JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro =
                                          tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'TIPO_NORMA'::text
ORDER BY par.id_parametro;

CREATE OR REPLACE VIEW ssom.vparametro_tobjeto(
                                               id_parametro_to,
                                               id_tipo_parametro_to,
                                               tipo_parametro_to,
                                               valor_parametro_to,
                                               codigo_parametro)
AS
SELECT par.id_parametro AS id_parametro_to,
       tpa.id_tipo_parametro AS id_tipo_parametro_to,
       tpa.tipo_parametro AS tipo_parametro_to,
       par.valor_parametro AS valor_parametro_to,
       par.codigo_parametro
FROM ssom.tparametro par
         JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro =
                                          tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'OBJETO_AUDITORIA'::text
ORDER BY par.id_parametro;
/********************************************F-DEP-MMV-SSOM-3-01/04/2021********************************************/

/********************************************I-DEP-MMV-SSOM-1-05/04/2021********************************************/
select pxp.f_insert_tgui_rol ('SSOM', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('SISTEMA', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PRL', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('APA', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ICS', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('AIP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('NCA', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('NCP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ION', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ODM', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('OMP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ODMS', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('RPTAUD', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PAY', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('AUD', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('INFEA', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PAUDI', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PAUD', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('config', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ROP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PROB', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('TRO', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('RIOP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ARO', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('IMP', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('cnor', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('nor', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('CFADM', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ATV', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('TAU', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PCS', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('GCT', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PDAU', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('ER', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('TPR', 'SSOM - Admin');
select pxp.f_insert_tgui_rol ('PRM', 'SSOM - Admin');
/********************************************F-DEP-MMV-SSOM-1-05/04/2021********************************************/
