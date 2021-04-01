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
