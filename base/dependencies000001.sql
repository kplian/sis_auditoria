/***********************************I-DEP-MCCH-SSOM-0-26/12/2019*****************************************/
--------------- SQL ---------------

ALTER TABLE ssom.tparametro
  ADD CONSTRAINT tparametro_fk FOREIGN KEY (id_tipo_parametro)
    REFERENCES ssom.ttipo_parametro(id_tipo_parametro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk FOREIGN KEY (id_tipo_auditoria)
    REFERENCES ssom.ttipo_auditoria(id_tipo_auditoria)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk1 FOREIGN KEY (id_uo)
    REFERENCES orga.tuo(id_uo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk2 FOREIGN KEY (id_gconsultivo)
    REFERENCES ssom.tgrupo_consultivo(id_gconsultivo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk3 FOREIGN KEY (id_funcionario)
    REFERENCES orga.tfuncionario(id_funcionario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk4 FOREIGN KEY (id_proceso_wf)
    REFERENCES wf.tproceso_wf(id_proceso_wf)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_oportunidad_mejora
  ADD CONSTRAINT tauditoria_oportunidad_mejora_fk5 FOREIGN KEY (id_estado_wf)
    REFERENCES wf.testado_wf(id_estado_wf)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tparametro_aom
  ADD CONSTRAINT tparametro_aom_fk FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tparametro_aom
  ADD CONSTRAINT tparametro_aom_fk1 FOREIGN KEY (id_parametro)
    REFERENCES ssom.tparametro(id_parametro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tdestinatario
  ADD CONSTRAINT tdestinatario_fk FOREIGN KEY (id_parametro)
    REFERENCES ssom.tparametro(id_parametro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tdestinatario
  ADD CONSTRAINT tdestinatario_fk1 FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tdestinatario
  ADD CONSTRAINT tdestinatario_fk2 FOREIGN KEY (id_funcionario)
    REFERENCES orga.tfuncionario(id_funcionario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tcronograma
  ADD CONSTRAINT tcronograma_fk FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tcronograma
  ADD CONSTRAINT tcronograma_fk1 FOREIGN KEY (id_actividad)
    REFERENCES ssom.tactividad(id_actividad)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE ssom.tequipo_responsable
  ADD CONSTRAINT tequipo_responsable_fk FOREIGN KEY (id_funcionario)
    REFERENCES orga.tfuncionario(id_funcionario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
--------------- SQL ---------------

ALTER TABLE ssom.tequipo_responsable
  ADD CONSTRAINT tequipo_responsable_fk1 FOREIGN KEY (id_parametro)
    REFERENCES ssom.tparametro(id_parametro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tequipo_responsable
  ADD CONSTRAINT tequipo_responsable_fk2 FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tcronograma_equipo_responsable
  ADD CONSTRAINT tcronograma_equipo_responsable_fk FOREIGN KEY (id_cronograma)
    REFERENCES ssom.tcronograma(id_cronograma)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tcronograma_equipo_responsable
  ADD CONSTRAINT tcronograma_equipo_responsable_fk1 FOREIGN KEY (id_equipo_responsable)
    REFERENCES ssom.tequipo_responsable(id_equipo_responsable)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_proceso
  ADD CONSTRAINT tauditoria_proceso_fk FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_proceso
  ADD CONSTRAINT tauditoria_proceso_fk1 FOREIGN KEY (id_proceso)
    REFERENCES ssom.tproceso(id_proceso)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tnorma
  ADD CONSTRAINT tnorma_fk FOREIGN KEY (id_parametro)
    REFERENCES ssom.tparametro(id_parametro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tpunto_norma
  ADD CONSTRAINT tpunto_norma_fk FOREIGN KEY (id_norma)
    REFERENCES ssom.tnorma(id_norma)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tpregunta
  ADD CONSTRAINT tpregunta_fk FOREIGN KEY (id_pn)
    REFERENCES ssom.tpunto_norma(id_pn)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_npn
  ADD CONSTRAINT tauditoria_npn_fk FOREIGN KEY (id_norma)
    REFERENCES ssom.tnorma(id_norma)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_npn
  ADD CONSTRAINT tauditoria_npn_fk1 FOREIGN KEY (id_pn)
    REFERENCES ssom.tpunto_norma(id_pn)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_npn
  ADD CONSTRAINT tauditoria_npn_fk2 FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_npnpg
  ADD CONSTRAINT tauditoria_npnpg_fk FOREIGN KEY (id_anpn)
    REFERENCES ssom.tauditoria_npn(id_anpn)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.tauditoria_npnpg
  ADD CONSTRAINT tauditoria_npnpg_fk1 FOREIGN KEY (id_pregunta)
    REFERENCES ssom.tpregunta(id_pregunta)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.triesgo_oportunidad
  ADD CONSTRAINT triesgo_oportunidad_fk FOREIGN KEY (id_tipo_ro)
    REFERENCES ssom.ttipo_ro(id_tipo_ro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.taom_riesgo_oportunidad
  ADD CONSTRAINT taom_riesgo_oportunidad_fk FOREIGN KEY (id_aom)
    REFERENCES ssom.tauditoria_oportunidad_mejora(id_aom)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- DEP ---------------

ALTER TABLE ssom.taom_riesgo_oportunidad
  ADD CONSTRAINT taom_riesgo_oportunidad_fk1 FOREIGN KEY (id_tipo_ro)
    REFERENCES ssom.ttipo_ro(id_tipo_ro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.taom_riesgo_oportunidad
  ADD CONSTRAINT taom_riesgo_oportunidad_fk2 FOREIGN KEY (id_ro)
    REFERENCES ssom.triesgo_oportunidad(id_ro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.taom_riesgo_oportunidad
  ADD CONSTRAINT taom_riesgo_oportunidad_fk3 FOREIGN KEY (id_probabilidad)
    REFERENCES ssom.tprobabilidad(id_probabilidad)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.taom_riesgo_oportunidad
  ADD CONSTRAINT taom_riesgo_oportunidad_fk4 FOREIGN KEY (id_impacto)
    REFERENCES ssom.timpacto(id_impacto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ssom.taccion_ro
  ADD CONSTRAINT taccion_ro_fk FOREIGN KEY (id_aom_ro)
    REFERENCES ssom.taom_riesgo_oportunidad(id_aom_ro)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


/***********************************F-DEP-MCCH-SSOM-0-26/12/2019*****************************************/

/***********************************I-DEP-MCCH-SSOM-2-30/12/2019*****************************************/

--------------- SQL ---------------

CREATE VIEW ssom.vestado_wf_aom (
                                 id_aom,
                                 nombre_aom1,
                                 id_tipo_estado,
                                 estado,
                                 codigo,
                                 nombre_estado)
AS
SELECT aom.id_aom,
       aom.nombre_aom1,
       te.id_tipo_estado,
       aom.estado_wf AS estado,
       te.codigo,
       te.nombre_estado
FROM ssom.tauditoria_oportunidad_mejora aom
       JOIN wf.testado_wf ewf ON aom.id_estado_wf = ewf.id_estado_wf
       JOIN wf.ttipo_estado te ON ewf.id_tipo_estado = te.id_tipo_estado
ORDER BY te.id_tipo_estado;

--------------- SQL ---------------

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

--------------- SQL ---------------

CREATE VIEW ssom.vparametro_tipo_om (
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
       JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro = tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'TIPO_OPORTUNIDAD_MEJORA'::text
ORDER BY par.id_parametro;

--------------- SQL ---------------

CREATE VIEW ssom.vparametro_tnorma (
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
       JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro = tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'TIPO_NORMA'::text
ORDER BY par.id_parametro;

--------------- SQL ---------------

CREATE VIEW ssom.vparametro_tobjeto (
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
       JOIN ssom.ttipo_parametro tpa ON par.id_tipo_parametro = tpa.id_tipo_parametro
WHERE tpa.tipo_parametro::text = 'OBJETO_AUDITORIA'::text
ORDER BY par.id_parametro;

--------------- SQL ---------------

CREATE OR REPLACE VIEW orga.vfuncionario_cargo_xtra(
  id_uo_funcionario,
  id_funcionario,
  id_persona,
  desc_funcionario1,
  desc_funcionario2,
  id_uo,
  nombre_cargo,
  fecha_asignacion,
  fecha_finalizacion,
  num_doc,
  ci,
  codigo,
  email_empresa,
  estado_reg_fun,
  estado_reg_asi,
  id_cargo,
  descripcion_cargo,
  cargo_codigo,
  nombre_unidad)
AS
SELECT uof.id_uo_funcionario,
       funcio.id_funcionario,
       funcio.id_persona,
       person.nombre_completo1 AS desc_funcionario1,
       person.nombre_completo2 AS desc_funcionario2,
       uo.id_uo,
       uo.nombre_cargo,
       uof.fecha_asignacion,
       uof.fecha_finalizacion,
       person.num_documento AS num_doc,
       person.ci,
       funcio.codigo,
       funcio.email_empresa,
       funcio.estado_reg AS estado_reg_fun,
       uof.estado_reg AS estado_reg_asi,
       car.id_cargo,
       car.nombre AS descripcion_cargo,
       car.codigo AS cargo_codigo,
       uo.nombre_unidad
FROM orga.tfuncionario funcio
       JOIN segu.vpersona person ON funcio.id_persona = person.id_persona
       JOIN orga.tuo_funcionario uof ON uof.id_funcionario =
                                        funcio.id_funcionario
       JOIN orga.tuo uo ON uo.id_uo = uof.id_uo
       JOIN orga.tcargo car ON car.id_cargo = uof.id_cargo
WHERE uof.estado_reg::text = 'activo'::text;

----------------------------------
--COPY LINES TO dependencies.sql FILE
---------------------------------

select pxp.f_insert_testructura_gui ('SSOM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('nor', 'cnor');
select pxp.f_insert_testructura_gui ('cges', 'SSOM');
select pxp.f_insert_testructura_gui ('config', 'SSOM');
select pxp.f_insert_testructura_gui ('GAUDI', 'SSOM');
select pxp.f_insert_testructura_gui ('PDAU', 'config');
select pxp.f_insert_testructura_gui ('PRM', 'PDAU');
select pxp.f_insert_testructura_gui ('TPR', 'PDAU');
select pxp.f_insert_testructura_gui ('CFADM', 'config');
select pxp.f_insert_testructura_gui ('GCT', 'CFADM');
select pxp.f_insert_testructura_gui ('PCS', 'CFADM');
select pxp.f_insert_testructura_gui ('TAU', 'CFADM');
select pxp.f_insert_testructura_gui ('SINT', 'CFADM');
select pxp.f_insert_testructura_gui ('PAUDI', 'AUDIN');
select pxp.f_insert_testructura_gui ('PAUD', 'AUDIN');
select pxp.f_insert_testructura_gui ('INFEA', 'AUDIN');
select pxp.f_insert_testructura_gui ('AUDIN', 'GAUDI');
select pxp.f_insert_testructura_gui ('INFOM', 'AUDIN');
select pxp.f_insert_testructura_gui ('VBAOM', 'GAUDI');
select pxp.f_insert_testructura_gui ('VBPLA', 'VBAOM');
select pxp.f_insert_testructura_gui ('VBINFA', 'VBAOM');
select pxp.f_insert_testructura_gui ('VBAUD', 'VBAOM');
select pxp.f_insert_testructura_gui ('RPTAUD', 'GAUDI');
select pxp.f_insert_testructura_gui ('RPTA', 'RPTAUD');
select pxp.f_insert_testructura_gui ('RPTOM', 'RPTAUD');
select pxp.f_insert_testructura_gui ('NCSEG', 'cges');
select pxp.f_insert_testructura_gui ('cnor', 'config');
select pxp.f_insert_testructura_gui ('ATV', 'CFADM');
select pxp.f_insert_testructura_gui ('ROP', 'config');
select pxp.f_insert_testructura_gui ('PROB', 'ROP');
select pxp.f_insert_testructura_gui ('IMP', 'ROP');
select pxp.f_insert_testructura_gui ('ARO', 'ROP');
select pxp.f_insert_testructura_gui ('RIOP', 'ROP');
select pxp.f_insert_testructura_gui ('TRO', 'ROP');

/***********************************F-DEP-MCCH-SSOM-2-30/12/2019*****************************************/

/***********************************I-DEP-MCCH-SSOM-3-31/12/2019*****************************************/
----------------------------------------------------
-- Dependencias de configuracion de Estados Worflow
----------------------------------------------------
select wf.f_import_ttipo_documento_estado ('insert','IN','AUDSE','vbplanificacion','AUDSE','crear','superior','');

/***********************************F-DEP-MCCH-SSOM-3-31/12/2019*****************************************/




