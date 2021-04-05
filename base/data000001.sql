/********************************************I-DAT-MCCH-SSOM-3-01/04/2021********************************************/
/* Data for the 'segu.tsubsistema' table  (Records 1 - 37) */

INSERT INTO segu.tsubsistema ("codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig", "codigo_git", "organizacion_git", "sw_importacion")
VALUES
(E'SSOM', E'Seguimiento de Oportunidades de Mejora', E'2020-04-13', E'SSOM', E'activo', E'auditoria', NULL, NULL, NULL, E'no');

/********************************************F-DAT-MCCH-SSOM-3-01/04/2021********************************************/



/********************************************I-DAT-MCCH-SSOM-0-30/12/2019********************************************/
------------------------------------------------------------------------
-- Creamos Tipos de Auditoria
------------------------------------------------------------------------
INSERT INTO ssom.ttipo_auditoria ("id_usuario_reg", "estado_reg", "tipo_auditoria", "codigo_tpo_aom", "descrip_tauditoria")
VALUES  (1, E'activo', E'AUDITORIA INTERNA', E'AETR', E''),
        (1, E'activo', E'OPORTUNIDAD MEJORA', E'OM', E'');
------------------------------------------------------------------------
-- Creamos Tipos de Parametros
------------------------------------------------------------------------
INSERT INTO ssom.ttipo_parametro ("id_usuario_reg", "estado_reg", "id_tipo_parametro", "tipo_parametro", "descrip_parametro")
VALUES
(1, E'activo', 6, E'OBJETO_AUDITORIA', E'Objeto Auditoria'),
(1, E'activo', 2, E'TIPO_OPORTUNIDAD_MEJORA', E'Tipo Oportunidad Mejora'),
(1, E'activo', 3, E'TIPO_NORMA', E'Tipo Norma'),
(1, E'activo', 4, E'TIPO_AREA', E'Tipo Area'),
(1, E'activo', 5, E'TIPO_NO_CONFORMIDAD', E'Tipo No Conformidad'),
(1, E'activo', 7, E'TIPO_PARTICIPACION', E'Tipo Participación'),
(1, E'activo', 1, E'TIPO_ACCION', E'Tipo Acción');

------------------------------------------------------------------------
-- Creamos Tipos de Parametros
------------------------------------------------------------------------
INSERT INTO ssom.tparametro ("id_usuario_reg", "estado_reg", "id_parametro", "id_tipo_parametro", "valor_parametro", "codigo_parametro")
VALUES
(1, E'activo', 26, 7, E'Responsable', E'RESP'),
(1, E'activo', 28, 7, E'Invitado', E'INV'),
(1, E'activo', 29, 7, E'Experto Tecnico Interno', E'ETI'),
(1, E'activo', 30, 7, E'Experto Tecnico Externo', E'ETE'),
(1, E'activo', 2, 1, E'Accion Preventiva', E'PREVENTIVE_ACTION'),
(1, E'activo', 33, 7, E'Otros', E'OTHERS'),
(1, E'activo', 34, 3, E'INTEGRADA', E'INTEG'),
(1, E'activo', 8, 2, E'Oportunidades de Mejora', E'TOM'),
(1, E'activo', 27, 7, E'Equipo Auditor', E'MEQ'),
(1, E'activo', 11, 3, E'Seguridad', E'SEG'),
(1, E'activo', 3, 1, E'Disposiccion', E'DIS'),
(1, E'activo', 4, 2, E'Inspeccion', E'INS'),
(1, E'activo', 5, 2, E'Revision', E'REV'),
(1, E'activo', 6, 2, E'Auditoria Externa', E'AE'),
(1, E'activo', 9, 3, E'Calidad', E'CAL'),
(1, E'activo', 10, 3, E'Medio Ambiente', E'MA'),
(1, E'activo', 12, 3, E'Responsabilidad Social', E'RS'),
(1, E'activo', 13, 4, E'Empresa', E'EMP'),
(1, E'activo', 14, 4, E'Directorio', E'DIR'),
(1, E'activo', 15, 4, E'Vicepresidencia', E'VCP'),
(1, E'activo', 16, 4, E'Apoyo', E'APO'),
(1, E'activo', 17, 4, E'Staf', E'STF'),
(1, E'activo', 18, 4, E'Unidad', E'UNI'),
(1, E'activo', 19, 4, E'Gerencia', E'GER'),
(1, E'activo', 20, 4, E'Asistencia', E'ASI'),
(1, E'activo', 21, 5, E'Mayor', E'MYR'),
(1, E'activo', 22, 5, E'Menor', E'MNR'),
(1, E'activo', 23, 5, E'Observacion', E'OBS'),
(1, E'activo', 24, 6, E'Seguimiento', E'SGM'),
(1, E'activo', 25, 6, E'Mejora Continua', E'MC'),
(1, E'activo', 7, 2, E'Grupo de Analisis de Fallas', E'GAF'),
(1, E'activo', 1, 1, E'Accion Correctiva', E'CORRECTIVE_ACTION');

------------------------------------------------------------------------
-- Creamos Grupo consultivo
------------------------------------------------------------------------

INSERT INTO ssom.tgrupo_consultivo ("id_usuario_reg", "estado_reg", "id_gconsultivo", "id_empresa", "nombre_gconsultivo", "descrip_gconsultivo", "requiere_programacion", "requiere_formulario", "nombre_programacion", "nombre_formulario")
VALUES
(1, E'activo', 4, 0, E'Gerencia General (ex VE)', E'', E'0', E'0', E'', E''),
(1, E'activo', 1, 0, E'Seguridad y Salud Ocupacional', E'', E'0', E'0', E'', E''),
(1, E'activo', 5, 0, E'Medio Ambiente', E'', E'0', E'0', E'', E''),
(1, E'activo', 6, 0, E'Representante de la Direccion SYSO', E'', E'0', E'0', E'', E''),
(1, E'activo', 7, 0, E'Representante de la Direccion SGA', E'', E'0', E'0', E'', E''),
(1, E'activo', 8, 0, E'Representante de la Direccion SGC', E'', E'0', E'0', E'', E''),
(1, E'activo', 9, 0, E'Representante de la Direccion SGRSI', E'', E'0', E'0', E'', E''),
(1, E'activo', 3, 0, E'Comite Mixto Sede Central y Almacén La Maica\t', E'', E'1', E'1', E'Cronograma de Inspeccion de Seguridad', E'Acta de Reunion del Comite'),
(1, E'activo', 13, 0, E'Comité Mixto Regional Oruro', E'', E'1', E'1', E'Cronograma de Inspección de Seguridad', E'Acta de Reunión del Comité'),
(1, E'activo', 11, 0, E'Comite Mixto Regional Santa Cruz', E'', E'1', E'1', E'Cronograma de Inspeccion de Seguridad', E'Acta de Reunion del Comite'),
(1, E'activo', 12, 0, E'Comité Mixto de Regional Potosí', E'', E'1', E'1', E'Cronograma de Inspección de Seguridad', E'Acta de Reunión del Comité'),
(1, E'activo', 14, 0, E'Gerencia Técnica', E'', E'0', E'0', E'', E''),
(1, E'activo', 15, 0, E'Gerencia de Operaciones y Mantenimiento', E'', E'0', E'0', E'', E''),
(1, E'activo', 16, 0, E'Gerencia de Planificación (ex GMO)', E'', E'0', E'0', E'', E''),
(1, E'activo', 17, 0, E'Gerencia de Administración y Finanzas', E'', E'0', E'0', E'', E''),
(1, E'activo', 19, 0, E'Gerencia General', E'', E'0', E'0', E'', E''),
(1, E'activo', 20, 0, E'Comité Mixto Regional La Paz', E'', E'1', E'1', E'Cronograma de Inspecciones', E'Acta de Reunión del Comité'),
(1, E'activo', 21, 0, E'Comité Mixto Regional Tarija', E'', E'1', E'1', E'Cronograma de Inspecciones', E'Acta de Reunión del Comité'),
(1, E'activo', 22, 0, E'Gerencia de Planificación', E'', E'0', E'0', E'', E''),
(1, E'activo', 18, 0, E'Comité Mixto Proyectos', E'', E'1', E'1', E'Cronograma de Inspeccion de Seguridad', E'Acta de Reunión del Comité'),
(1, E'activo', 10, 0, E'Comite Mixto Regional Cochabamba', E'', E'1', E'1', E'Cronograma de Inspeccion de Seguridad', E'Acta de Reunion del Comite'),
(1, E'activo', 2, 0, E'Grupo de Análisis de Fallas', E'', E'0', E'1', E'', E'Informe Tecnico Interno del GAF');

------------------------------------------------------------------------
-- Creamos Normas
------------------------------------------------------------------------

INSERT INTO ssom.tnorma ("id_usuario_reg", "estado_reg", "id_norma", "id_parametro", "sigla_norma", "nombre_norma", "descrip_norma")
VALUES
(1, E'activo', 4, 9, E'ISO 9001:2015', E'Sistema de Gestion de Calidad', E'Protocolos de Calidad'),
(1, E'activo', 5, 9, E'ISO 9001:2008', E'Sistema de Gestion de la Calidad', E'protocolos de calidad'),
(1, E'activo', 2, 10, E'ISO 14001:2015', E'Sistema de Gestion Ambiental', E'Protocolos ambientales'),
(1, E'activo', 3, 10, E'ISO 14001:2004', E'Sistema de Gestion Ambiental', E'Protocolos ambientales'),
(1, E'activo', 1, 12, E'IQNET SR10:2015', E'Sistema de Gestion de Responsabilidad Social', E'protocolos de responsabilidad social'),
(1, E'activo', 7, 12, E'RS-010:2011', E'Sistema de Gestion de la Responsabilidad Social', E'Sistema de Gestion de la Responsabilidad Social'),
(1, E'activo', 8, 12, E'RS-010:2009', E'Responsabilidad Social de las Empresas', E'Responsabilidad Social de las Empresas'),
(1, E'activo', 9, 12, E'SA 8000:2008', E'Responsabilidad Social', E'Responsabilidad Social'),
(1, E'activo', 6, 11, E'OHSAS 18001:2007', E'Gestion de Seguridad Industrial y Laboral', E'Gestion de Seguridad Industrial y Laboral');

------------------------------------------------------------------------
-- Creamos Puntos de Normas
------------------------------------------------------------------------
INSERT INTO ssom.tpunto_norma ("id_usuario_reg", "estado_reg", "id_pn", "id_norma", "codigo_pn", "nombre_pn", "descrip_pn")
VALUES
(1, E'activo', 1, 1, E'10', E'Mejora', E'Establece mejoras'),
(1, E'activo', 33, 4, E'4', E'Contexto de Organizacion', E'Contexto de Organización'),
(1, E'activo', 2, 1, E'10', E'No conformidades y acciones correctivas', E'No conformidades y acciones correctivas'),
(1, E'activo', 3, 1, E'12', E'Mejora continua', E'Mejora continua'),
(1, E'activo', 7, 1, E'14', E'Contexto de organización', E'Contexto de organización'),
(1, E'activo', 10, 1, E'4.1', E'Conocimiento organización y contexto', E'Conocimiento organización y contexto'),
(1, E'activo', 11, 1, E'4.2', E'Compresión necesidades y expectativas de GGII', E'Compresión necesidades y expectativas de GGII'),
(1, E'activo', 12, 1, E'4.3', E'Determinación alcance del SGRS', E'Determinación alcance del SGRS'),
(1, E'activo', 13, 1, E'4.4', E'Sistema de gestión de responsabilidad social', E'Sistema de gestión de responsabilidad social'),
(1, E'activo', 14, 1, E'5', E'Liderazgo', E'Liderazgo'),
(1, E'activo', 15, 1, E'5.1', E'Liderazgo y compromiso', E'Liderazgo y compromiso'),
(1, E'activo', 16, 1, E'5.2', E'Política', E'Política'),
(1, E'activo', 17, 1, E'5.3', E'Roles, responsabilidad y autoridad de la organización', E'Roles, responsabilidad y autoridad de la organización'),
(1, E'activo', 18, 1, E'5.4', E'Código de conducta', E'Código de conducta'),
(1, E'activo', 8, 2, E'10', E'Mejora', E'mejora'),
(1, E'activo', 9, 2, E'10.1', E'Generalidades mejora', E'Generalidades mejora'),
(1, E'activo', 19, 2, E'10.2', E'No conformidad y acción correctiva', E'No conformidad y acción correctiva'),
(1, E'activo', 20, 2, E'10.3', E'Mejora continua', E'Mejora continua'),
(1, E'activo', 21, 2, E'4', E'Contexto de la organización ', E'Contexto de la organización '),
(1, E'activo', 22, 2, E'4.1', E'Comprensión de la Organización y su contexto ', E'Comprensión de la Organización y su contexto '),
(1, E'activo', 23, 2, E'4.2', E'Comprensión de necesidad y expectativas partes interesadas', E'Comprensión de necesidad y expectativas partes interesadas'),
(1, E'activo', 24, 2, E'4.3', E'Determinación alcance SGA', E'Determinación alcance SGA'),
(1, E'activo', 25, 2, E'4.4', E'Sistema de gestión ambiental', E'Sistema de gestión ambiental'),
(1, E'activo', 26, 4, E'10', E'Mejora', E'Mejora'),
(1, E'activo', 27, 4, E'10.1', E'Generalidades mejora', E'Generalidades mejora'),
(1, E'activo', 28, 4, E'10.2', E'No conformidad y acción correctiva', E'No conformidad y acción correctiva'),
(1, E'activo', 29, 4, E'10.2.1', E'No conformidad y acción correctiva - Descripción', E'No conformidad y acción correctiva - Descripción'),
(1, E'activo', 30, 4, E'10.2.2', E'Información documentada - Auditoria interna', E'Información documentada - Auditoria interna'),
(1, E'activo', 31, 4, E'10.3', E'Mejora continua', E'Mejora continua'),
(1, E'activo', 34, 4, E'4.1', E'Comprensión de la Org. y su Contexto', E'Comprensión de la Org. y su Contexto'),
(1, E'activo', 35, 4, E'4.2', E'Comprensión de necesid. y expect. partes interesadas', E'Comprensión de necesid. y expect. partes interesadas'),
(1, E'activo', 36, 4, E'4.3', E'Determinación alcance SGC', E'Determinación alcance SGC'),
(1, E'activo', 37, 4, E'4.4', E'Sist. de Gestión de Calidad y sus procesos', E'Sist. de Gestión de Calidad y sus procesos'),
(1, E'activo', 38, 4, E'4.4.1', E'Gestión de Procesos', E'Gestión de Procesos'),
(1, E'activo', 39, 4, E'4.4.2', E'Información documentada de los procesos', E'Información documentada de los procesos'),
(1, E'activo', 40, 4, E'5', E'Liderazgo', E'Liderazgo'),
(1, E'activo', 41, 4, E'5.1', E'Liderazgo y Compromiso', E'Liderazgo y Compromiso'),
(1, E'activo', 42, 4, E'5.1.1', E'Generalidades', E'Generalidades'),
(1, E'activo', 43, 4, E'5.1.2', E'Enfoque al cliente', E'Enfoque al cliente'),
(1, E'activo', 44, 4, E'5.2', E'Política', E'Política'),
(1, E'activo', 45, 4, E'5.2.1', E'Establecimiento Política Calidad', E'Establecimiento Política Calidad'),
(1, E'activo', 46, 4, E'5.2.2', E'Comunicación Política Calidad', E'Comunicación Política Calidad'),
(1, E'activo', 47, 4, E'5.3', E'Roles, resp. y autoridades en la org.', E'Roles, resp. y autoridades en la org.'),
(1, E'activo', 48, 4, E'5.3', E'Roles, resp. y autoridades en la org.', E'Roles, resp. y autoridades en la org.'),
(1, E'activo', 49, 4, E'6', E'Planificación', E'Planificación'),
(1, E'activo', 4, 5, E'4.1', E'REQUISITOS GENERALES', E'REQUISITOS GENERALES'),
(1, E'activo', 5, 5, E'4.2', E'REQUISITOS DE LA DOCUMENTACIÓN', E'REQUISITOS DE LA DOCUMENTACIÓN'),
(1, E'activo', 50, 5, E'4.2.1', E'GENERALIDADES', E'GENERALIDADES'),
(1, E'activo', 51, 5, E'4.2.2', E'MANUAL DE LA CALIDAD', E'MANUAL DE LA CALIDAD'),
(1, E'activo', 52, 5, E'4.2.3', E'CONTROL DE DOCUMENTOS', E'CONTROL DE DOCUMENTOS'),
(1, E'activo', 53, 5, E'4.2.4', E'CONTROL DE LOS REGISTROS DE LA CALIDAD', E'CONTROL DE LOS REGISTROS DE LA CALIDAD'),
(1, E'activo', 54, 5, E'5', E'RESPONSABILIDAD DE LA DIRECCIÓN', E'RESPONSABILIDAD DE LA DIRECCIÓN'),
(1, E'activo', 55, 5, E'5.1', E'COMPROMISO DE LA DIRECCIÓN', E'COMPROMISO DE LA DIRECCIÓN'),
(1, E'activo', 56, 5, E'5.2', E'ENFOQUE AL CLIENTE', E'ENFOQUE AL CLIENTE'),
(1, E'activo', 57, 5, E'5.3', E'POLITICA DE LA CALIDAD', E'POLITICA DE LA CALIDAD'),
(1, E'activo', 58, 5, E'5.4', E'PLANIFICACIÓN', E'PLANIFICACIÓN'),
(1, E'activo', 59, 5, E'5.4.1', E'OBJETIVOS DE LA CALIDAD', E'OBJETIVOS DE LA CALIDAD'),
(1, E'activo', 60, 5, E'5.4.2', E'PLANIFICACIÓN DEL SISTEMA DE GESTIÓN DE LA CALIDAD', E'PLANIFICACIÓN DEL SISTEMA DE GESTIÓN DE LA CALIDAD'),
(1, E'activo', 61, 5, E'5.5', E'RESPONSABILIDAD, AUTORIDAD Y COMUNICACIÓN', E'RESPONSABILIDAD, AUTORIDAD Y COMUNICACIÓN'),
(1, E'activo', 62, 5, E'5.5.1', E'RESPONSABILIDAD Y AUTORIDAD', E'RESPONSABILIDAD Y AUTORIDAD'),
(1, E'activo', 63, 5, E'5.5.2', E'REPRESENTANTE DE LA DIRECCIÓN', E'REPRESENTANTE DE LA DIRECCIÓN'),
(1, E'activo', 64, 5, E'5.5.3', E'COMUNIACIÓN INTERNA', E'COMUNIACIÓN INTERNA'),
(1, E'activo', 65, 5, E'5.6', E'REVISIÓN POR LA DIRECCIÓN', E'REVISIÓN POR LA DIRECCIÓN'),
(1, E'activo', 66, 5, E'5.6.1', E'GENERALIDADES', E'GENERALIDADES'),
(1, E'activo', 67, 5, E'5.6.2', E'INFORMACIÓN PARA LA REVISIÓN', E'INFORMACIÓN PARA LA REVISIÓN'),
(1, E'activo', 68, 5, E'5.6.3', E'RESULTADOS DE LA REVISIÓN', E'RESULTADOS DE LA REVISIÓN'),
(1, E'activo', 6, 3, E'4.1', E'REQUISITOS GENERALES', E'REQUISITOS GENERALES'),
(1, E'activo', 69, 3, E'4.2', E'POLÍTICA AMBIENTAL', E'POLÍTICA AMBIENTAL'),
(1, E'activo', 70, 3, E'4.3', E'PLANIFICACIÓN', E'PLANIFICACIÓN'),
(1, E'activo', 71, 3, E'4.3.1', E'ASPECTOS AMBIENTALES', E'ASPECTOS AMBIENTALES'),
(1, E'activo', 72, 3, E'4.3.2', E'REQUISITOS LEGALES Y OTROS REQUISITOS', E'REQUISITOS LEGALES Y OTROS REQUISITOS'),
(1, E'activo', 73, 3, E'4.3.3', E'OBJETIVOS, METAS Y PROGRAMAS', E'OBJETIVOS, METAS Y PROGRAMAS'),
(1, E'activo', 74, 3, E'4.4', E'IMPLEMENTACIÓN Y OPERACIÓN', E'IMPLEMENTACIÓN Y OPERACIÓN'),
(1, E'activo', 75, 3, E'4.4.1', E'RECURSOS, FUNCIONES, RESPONSABILIDADES Y AUTORIDAD', E'RECURSOS, FUNCIONES, RESPONSABILIDADES Y AUTORIDAD'),
(1, E'activo', 76, 3, E'4.4.2', E'COMPETENCIA, FORMACIÓN Y TOMA DE CONCIENCIA', E'COMPETENCIA, FORMACIÓN Y TOMA DE CONCIENCIA'),
(1, E'activo', 77, 3, E'4.4.3', E'COMUNICACIÓN', E'COMUNICACIÓN'),
(1, E'activo', 78, 3, E'4.4.4', E'DOCUMENTACIÓN', E'DOCUMENTACIÓN'),
(1, E'activo', 79, 3, E'4.4.5', E'CONTROL DE DOCUMENTOS', E'CONTROL DE DOCUMENTOS'),
(1, E'activo', 80, 3, E'4.4.6', E'CONTROL OPERACIONAL', E'CONTROL OPERACIONAL'),
(1, E'activo', 81, 3, E'4.4.7', E'PREPARACIÓN Y RESPUESTA ANTE EMERGENCIAS', E'PREPARACIÓN Y RESPUESTA ANTE EMERGENCIAS'),
(1, E'activo', 82, 3, E'4.5', E'VERIFICACIÓN', E'VERIFICACIÓN'),
(1, E'activo', 83, 3, E'4.5.1', E'SEGUIMIENTO Y MEDICIÓN', E'SEGUIMIENTO Y MEDICIÓN'),
(1, E'activo', 84, 3, E'4.5.2', E'EVALUACIÓN DEL CUMPLIMIENTO LEGAL', E'EVALUACIÓN DEL CUMPLIMIENTO LEGAL'),
(1, E'activo', 85, 3, E'4.5.3', E'NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA\t', E'NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA\t'),
(1, E'activo', 86, 3, E'4.5.4', E'CONTROL DE LOS REGISTROS', E'CONTROL DE LOS REGISTROS'),
(1, E'activo', 87, 3, E'4.5.5', E'AUDITORIA INTERNA', E'AUDITORIA INTERNA'),
(1, E'activo', 88, 3, E'4.6', E'REVISIÓN POR LA DIRECCIÓN', E'REVISIÓN POR LA DIRECCIÓN'),
(1, E'activo', 89, 1, E'6', E'Planificación', E'Planificación'),
(1, E'activo', 90, 1, E'6.1', E'Acciones para abordar los riesgos y oportunidades', E'Acciones para abordar los riesgos y oportunidades'),
(1, E'activo', 91, 1, E'6.2', E'Identificación y evaluación de asuntos', E'Identificación y evaluación de asuntos'),
(1, E'activo', 92, 1, E'6.3', E'Objetivos y planificación para lograrlos', E'Objetivos y planificación para lograrlos'),
(1, E'activo', 93, 1, E'6.4', E'Requisitos legales y otros requisitos', E'Requisitos legales y otros requisitos'),
(1, E'activo', 94, 7, E'4', E'Sistema de gestión de la responsabilidad social', E'Sistema de gestión de la responsabilidad social'),
(1, E'activo', 95, 7, E'4.1', E'Requisitos generales', E'Requisitos generales'),
(1, E'activo', 96, 7, E'4.2', E'Requisitos de documentación', E'Requisitos de documentación'),
(1, E'activo', 97, 7, E'4.2.1', E'Generalidades', E'Generalidades'),
(1, E'activo', 98, 7, E'4.2.2', E'Manual de responsabilidad social', E'Manual de responsabilidad social'),
(1, E'activo', 99, 7, E'4.2.3', E'Control de los documentos', E'Control de los documentos'),
(1, E'activo', 100, 7, E'4.2.4', E'Control de los registros', E'Control de los registros'),
(1, E'activo', 101, 7, E'5', E'Responsabilidad de la dirección', E'Responsabilidad de la dirección'),
(1, E'activo', 102, 7, E'5.1', E'Compromiso de la dirección', E'Compromiso de la dirección'),
(1, E'activo', 103, 7, E'5.2', E'Política de Responsabilidad Social', E'Política de Responsabilidad Social'),
(1, E'activo', 104, 7, E'5.3', E'Planificación SGRS', E'Planificación SGRS'),
(1, E'activo', 105, 7, E'5.3.1', E'Objetivos, metas y programas', E'Objetivos, metas y programas'),
(1, E'activo', 106, 7, E'5.3.2', E'Planificación del SGRS', E'Planificación del SGRS'),
(1, E'activo', 107, 7, E'5.4', E'Responsabilidad,autoridad y comunicacion', E'Responsabilidad,autoridad y comunicacion'),
(1, E'activo', 108, 7, E'5.4.1', E'Responsabilidad y autoridad', E'Responsabilidad y autoridad'),
(1, E'activo', 109, 7, E'5.4.2', E'Representante de la dirección', E'Representante de la dirección'),
(1, E'activo', 110, 7, E'5.4.3', E'Comunicación', E'Comunicación'),
(1, E'activo', 111, 7, E'5.5', E'Requisitos legales y otros requisitos', E'Requisitos legales y otros requisitos'),
(1, E'activo', 112, 7, E'5.6', E'Revisión del sistema por la dirección', E'Revisión del sistema por la dirección'),
(1, E'activo', 113, 7, E'5.6.1', E'Información de entrada para la revisión', E'Información de entrada para la revisión'),
(1, E'activo', 114, 7, E'5.6.2', E'Resultados de la revisión', E'Resultados de la revisión'),
(1, E'activo', 115, 8, E'5', E'RECOMENDACIONES PARA LAS RSE', E'RECOMENDACIONES PARA LAS RSE'),
(1, E'activo', 116, 8, E'5.1', E'Generalidades', E'Generalidades'),
(1, E'activo', 117, 8, E'5.2', E'Comportamiento ante los propietarios, accionistas,inversores y socios', E'Comportamiento ante los propietarios, accionistas,inversores y socios'),
(1, E'activo', 118, 8, E'5.3', E'Comportamiento ante los empleados', E'Comportamiento ante los empleados'),
(1, E'activo', 119, 8, E'5.4', E'Comportamiento ante los clientes, usuarios y consumidores', E'Comportamiento ante los clientes, usuarios y consumidores'),
(1, E'activo', 120, 8, E'5.5', E'Comportamiento ante proveedores de productos y servicios', E'Comportamiento ante proveedores de productos y servicios'),
(1, E'activo', 121, 8, E'5.6', E'Comportamiento en alianzas o colaboraciones', E'Comportamiento en alianzas o colaboraciones'),
(1, E'activo', 122, 8, E'5.7', E'Comportamiento ante los competidores', E'Comportamiento ante los competidores'),
(1, E'activo', 123, 8, E'5.8', E'Comportamiento ante la Administración', E'Comportamiento ante la Administración'),
(1, E'activo', 124, 8, E'5.9', E'Comportamiento ante la comunidad/sociedad', E'Comportamiento ante la comunidad/sociedad'),
(1, E'activo', 125, 8, E'5.10', E'Comportamiento ante el medio ambiente', E'Comportamiento ante el medio ambiente'),
(1, E'activo', 126, 8, E'6', E'RECOMENDACIONES PARA EL SISTEMA DE GESTIÓN DE RSE', E'RECOMENDACIONES PARA EL SISTEMA DE GESTIÓN DE RSE'),
(1, E'activo', 127, 8, E'6.1', E'Generalidades1', E'Generalidades1'),
(1, E'activo', 128, 8, E'6.2', E'Compromiso y definición estratégica', E'Compromiso y definición estratégica'),
(1, E'activo', 129, 8, E'6.3', E'Diagnóstico inicial', E'Diagnóstico inicial'),
(1, E'activo', 130, 8, E'6.4', E'Planificación', E'Planificación'),
(1, E'activo', 131, 8, E'6.5', E'Implantación', E'Implantación'),
(1, E'activo', 132, 8, E'6.5.1', E'Documentos', E'Documentos'),
(1, E'activo', 133, 8, E'6.5.2', E'Gestión de los recursos', E'Gestión de los recursos'),
(1, E'activo', 134, 8, E'6.5.3', E'Gestión de las operaciones', E'Gestión de las operaciones'),
(1, E'activo', 135, 8, E'6.6', E'Medición, análisis y mejora', E'Medición, análisis y mejora'),
(1, E'activo', 136, 8, E'6.6.1', E'Seguimiento del desempeño', E'Seguimiento del desempeño'),
(1, E'activo', 137, 8, E'6.6.2', E'Deficiencias y capacidad de respuesta', E'Deficiencias y capacidad de respuesta'),
(1, E'activo', 138, 8, E'6.6.3', E'Mejora', E'Mejora'),
(1, E'activo', 139, 8, E'6.7', E'Revisión por la dirección', E'Revisión por la dirección'),
(1, E'activo', 140, 8, E'6.8', E'Comunicación, información e implicación con los grupos de interés', E'Comunicación, información e implicación con los grupos de interés'),
(1, E'activo', 141, 9, E'0.1', E'(Anterior Versión) Seguridad y Salud - Higiene', E'(Anterior Versión) Seguridad y Salud - Higiene'),
(1, E'activo', 142, 9, E'0.2', E'(Anterior Versión) Identificación de no conformidades y acciones correctivas - Acciones correctivas y remediales', E'(Anterior Versión) Identificación de no conformidades y acciones correctivas - Acciones correctivas y remediales'),
(1, E'activo', 143, 9, E'0.3', E'(Anterior Versión)Comunicación Externa', E'(Anterior Versión)Comunicación Externa'),
(1, E'activo', 144, 9, E'0.4', E'(Anterior Versión) Acceso para verificación', E'(Anterior Versión) Acceso para verificación'),
(1, E'activo', 145, 9, E'0.5', E'(Anterior Versión) Horario de Trabajo - Contrato Colectivo', E'(Anterior Versión) Horario de Trabajo - Contrato Colectivo'),
(1, E'activo', 146, 9, E'1', E'Propósito y ámbito de aplicación', E'Propósito y ámbito de aplicación'),
(1, E'activo', 147, 9, E'2', E'Elementos normativos y su interpretación', E'Elementos normativos y su interpretación'),
(1, E'activo', 148, 9, E'3', E'Definiciones', E'Definiciones'),
(1, E'activo', 149, 9, E'4.1.1', E'Trabajo Infantil - No apoyo', E'Trabajo Infantil - No apoyo'),
(1, E'activo', 150, 9, E'4.1.2', E'Trabajo Infantil - Acciones Remediales', E'Trabajo Infantil - Acciones Remediales'),
(1, E'activo', 151, 9, E'4.1.3', E'Trabajo Infantil - Trabajador Joven', E'Trabajo Infantil - Trabajador Joven'),
(1, E'activo', 152, 9, E'4.1.4', E'Trabajo Infantil - Exposición a situaciones peligrosas, insalubres o inseguras', E'Trabajo Infantil - Exposición a situaciones peligrosas, insalubres o inseguras'),
(1, E'activo', 153, 9, E'4.2.1', E'Trabajos Forzoso- No apoyo', E'Trabajos Forzoso- No apoyo'),
(1, E'activo', 154, 9, E'4.2.2', E'Trabajo forzoso-No se acepta ningun tipo de retención', E'Trabajo forzoso-No se acepta ningun tipo de retención'),
(1, E'activo', 155, 9, E'4.2.3', E'Trabajo Forzoso- Derecho a salir terminando la jornada y terminar relación laboral', E'Trabajo Forzoso- Derecho a salir terminando la jornada y terminar relación laboral'),
(1, E'activo', 156, 9, E'4.2.4', E'Trabajo Forzoso- No apoya ni practica el tráfico de seres humanos', E'Trabajo Forzoso- No apoya ni practica el tráfico de seres humanos'),
(1, E'activo', 157, 9, E'4.3.1', E'Seguridad y Salud - Entorno Laboral', E'Seguridad y Salud - Entorno Laboral'),
(1, E'activo', 158, 9, E'4.3.2', E'Seguridad y Salud - Representante de la Alta Administración en temas de SYSO', E'Seguridad y Salud - Representante de la Alta Administración en temas de SYSO'),
(1, E'activo', 159, 9, E'4.3.3', E'Seguridad y Salud - Instrucción sobre salud y seguridad laboral', E'Seguridad y Salud - Instrucción sobre salud y seguridad laboral'),
(1, E'activo', 160, 9, E'4.3.4', E'Seguridad y Salud - Detección, prevención y actuación contra amenazas', E'Seguridad y Salud - Detección, prevención y actuación contra amenazas'),
(1, E'activo', 161, 9, E'4.3.5', E'Seguridad y Salud -Dotación de EPIS', E'Seguridad y Salud -Dotación de EPIS'),
(1, E'activo', 162, 9, E'4.3.6', E'Seguridad y Salud - Evaluación de riesgos para nuevas madres y madres gestantes', E'Seguridad y Salud - Evaluación de riesgos para nuevas madres y madres gestantes'),
(1, E'activo', 163, 9, E'4.3.7', E'Seguridad y Salud- Acceso a servicios higienicos', E'Seguridad y Salud- Acceso a servicios higienicos'),
(1, E'activo', 164, 9, E'4.3.8', E'Seguridad y Salud- Provee de dormitorios limpios y seguros', E'Seguridad y Salud- Provee de dormitorios limpios y seguros'),
(1, E'activo', 165, 9, E'4.3.9', E'Seguridad y Salud- Derecho a mantenerse lejos de peligros inminentes serios', E'Seguridad y Salud- Derecho a mantenerse lejos de peligros inminentes serios'),
(1, E'activo', 166, 9, E'4.4.1', E'Libertad de Asociación y Derecho a la negociación colectiva - Derecho a agremiación', E'Libertad de Asociación y Derecho a la negociación colectiva - Derecho a agremiación'),
(1, E'activo', 167, 9, E'4.4.2', E'Libertad de Asociación y Derecho a la Negociación Colectiva - Inst. paralelos de asociación', E'Libertad de Asociación y Derecho a la Negociación Colectiva - Inst. paralelos de asociación'),
(1, E'activo', 168, 9, E'4.4.3', E'Libertad de asociación y derecho a la negociación colectiva - Sin Discriminación', E'Libertad de asociación y derecho a la negociación colectiva - Sin Discriminación'),
(1, E'activo', 32, 6, E'4.1', E'REQUISITOS GENERALES', E'REQUISITOS GENERALES'),
(1, E'activo', 169, 6, E'4.2', E'POLÍTICA DE SEGURIDAD Y SALUD OCUPACIONAL', E'POLÍTICA DE SEGURIDAD Y SALUD OCUPACIONAL'),
(1, E'activo', 170, 6, E'4.3', E'PLANIFICACIÓN', E'PLANIFICACIÓN'),
(1, E'activo', 171, 6, E'4.3.1', E'IDENTIFICACIÓN DE PELIGROS, EVALUACIÓN DE RIESGOS Y DETERMINACIÓN DE CONTROLES', E'IDENTIFICACIÓN DE PELIGROS, EVALUACIÓN DE RIESGOS Y DETERMINACIÓN DE CONTROLES'),
(1, E'activo', 172, 6, E'4.3.2', E'REQUISITOS LEGALES Y DE OTROS REQUISITOS', E'REQUISITOS LEGALES Y DE OTROS REQUISITOS'),
(1, E'activo', 173, 6, E'4.3.3', E'OBJETIVOS Y PROGRAMA(S)', E'OBJETIVOS Y PROGRAMA(S)'),
(1, E'activo', 174, 6, E'4.3.4', E'PROGRAMA(S) DE GESTIÓN DE LA SYSO', E'PROGRAMA(S) DE GESTIÓN DE LA SYSO'),
(1, E'activo', 175, 6, E'4.4', E'IMPLEMENTACIÓN Y OPERACIÓN', E'IMPLEMENTACIÓN Y OPERACIÓN'),
(1, E'activo', 176, 6, E'4.4.1', E'RECURSOS, FUNCIONES, RESPONSABILIDAD, OBLIGACIÓN DE RENDIR CUENTAS Y AUTORIDAD', E'RECURSOS, FUNCIONES, RESPONSABILIDAD, OBLIGACIÓN DE RENDIR CUENTAS Y AUTORIDAD'),
(1, E'activo', 177, 6, E'4.4.2', E'COMPETENCIA, FORMACIÓN Y TOMA DE CONCIENCIA', E'COMPETENCIA, FORMACIÓN Y TOMA DE CONCIENCIA'),
(1, E'activo', 178, 6, E'4.4.3', E'COMUNICACIÓN, PARTICIPACIÓN Y CONSULTA', E'COMUNICACIÓN, PARTICIPACIÓN Y CONSULTA'),
(1, E'activo', 179, 6, E'4.4.3.1', E'COMUNICACIÓN', E'COMUNICACIÓN'),
(1, E'activo', 180, 6, E'4.4.3.2', E'PARTICIPACIÓN Y CONSULTA', E'PARTICIPACIÓN Y CONSULTA'),
(1, E'activo', 181, 6, E'4.4.4', E'DOCUMENTACIÓN', E'DOCUMENTACIÓN'),
(1, E'activo', 182, 6, E'4.4.5', E'CONTROL DE DOCUMENTOS', E'CONTROL DE DOCUMENTOS'),
(1, E'activo', 183, 6, E'4.4.6', E'CONTROL OPERACIONAL', E'CONTROL OPERACIONAL'),
(1, E'activo', 184, 6, E'4.4.7', E'PREPARACIÓN Y RESPUESTA ANTE EMERGENCIAS', E'PREPARACIÓN Y RESPUESTA ANTE EMERGENCIAS'),
(1, E'activo', 185, 6, E'4.5', E'VERIFICACIÓN', E'VERIFICACIÓN'),
(1, E'activo', 186, 6, E'4.5.1', E'MEDICIÓN Y SEGUIMIENTO DEL DESEMPEÑO', E'MEDICIÓN Y SEGUIMIENTO DEL DESEMPEÑO'),
(1, E'activo', 187, 6, E'4.5.2', E'EVALUACIÓN DEL CUMPLIMIENTO', E'EVALUACIÓN DEL CUMPLIMIENTO'),
(1, E'activo', 188, 6, E'4.5.2.1', E'Evaluación del cumplimiento (1)', E'Evaluación del cumplimiento (1)'),
(1, E'activo', 189, 6, E'4.5.2.2', E'Evaluación del cumplimiento (2)', E'Evaluación del cumplimiento (2)'),
(1, E'activo', 190, 6, E'4.5.3', E'INVESTIGACIÓN DE INCIDENTES, NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA', E'INVESTIGACIÓN DE INCIDENTES, NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA'),
(1, E'activo', 191, 6, E'4.5.3.1', E'NVESTIGACIÓN DE INCIDENTES', E'NVESTIGACIÓN DE INCIDENTES'),
(1, E'activo', 192, 6, E'4.5.3.2', E'NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA', E'NO CONFORMIDAD, ACCIÓN CORRECTIVA Y ACCIÓN PREVENTIVA'),
(1, E'activo', 193, 6, E'4.5.4', E'CONTROL DE LOS REGISTROS', E'CONTROL DE LOS REGISTROS'),
(1, E'activo', 194, 6, E'4.5.5', E'AUDITORIA INTERNA', E'AUDITORIA INTERNA'),
(1, E'activo', 195, 6, E'4.6', E'REVISIÓN POR LA DIRECCIÓN', E'REVISIÓN POR LA DIRECCIÓN');

------------------------------------------------------------------------
-- Creamos Actividades
------------------------------------------------------------------------

INSERT INTO ssom.tactividad ("id_usuario_reg", "estado_reg", "id_actividad", "actividad", "codigo_actividad", "obs_actividad")
VALUES
(1, E'activo', 1, E'Reunion Apertura', E'', NULL),
(1, E'activo', 3, E'Almuerzo', E'', NULL),
(1, E'activo', 4, E'Reunión de cierre', E'', NULL),
(1, E'activo', 5, E'Revisión Documental', E'', NULL),
(1, E'activo', 7, E'Entrevistas al personal', E'', NULL),
(1, E'activo', 8, E'Entrevistas al Contratista', E'', NULL),
(1, E'activo', 2, E'Auditoría en sitio', E'', E''),
(1, E'activo', 6, E'Inspección de Instalaciones', E'', E'Ninguna'),
(1, E'activo', 9, E'Otros (actividad)', E'OTHER_ACTIVITY', E'');

/********************************************F-DAT-MCCH-SSOM-0-30/12/2019********************************************/
/********************************************I-DAT-MCCH-SSOM-2-31/12/2019********************************************/
-----------------------------------------------------------
-- Datos de parametros de configuracion de auditoria
-----------------------------------------------------------
INSERT INTO ssom.tparametro_config_auditoria ("id_usuario_reg", "estado_reg", "param_gestion", "param_fecha_a", "param_fecha_b", "param_prefijo", "param_serie")
VALUES
(1, E'activo', 2019, E'2019-01-01', E'2019-12-31', E'EAOM', E'00000');

/********************************************F-DAT-MCCH-SSOM-2-31/12/2019********************************************/


/********************************************I-DAT-MMV-SSOM-01/04/2021********************************************/
select pxp.f_insert_tgui ('<i class="fa fa-check-square-o" style="font-size:30px;" ></i>SEGUIMIENTO A OPORTUNIDADES DE MEJORA', '', 'SSOM', 'si', 1, '', 1, '', '', 'SSOM');
select pxp.f_insert_tgui ('Tipo Auditoria', 'Tipo Auditoria', 'TAU', 'si', 1, 'sis_auditoria/vista/tipo_auditoria/TipoAuditoria.php', 2, '', 'TipoAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Grupo Consultivo', 'Grupo Consultivo', 'GCT', 'si', 4, 'sis_auditoria/vista/grupo_consultivo/GrupoConsultivo.php', 2, '', 'GrupoConsultivo', 'SSOM');
select pxp.f_insert_tgui ('Proceso Auditable', 'Procesos Auditables', 'PCS', 'si', 2, 'sis_auditoria/vista/proceso/Proceso.php', 2, '', 'Proceso', 'SSOM');
select pxp.f_insert_tgui ('Gestion de Normas', 'Administra la gestión de normas', 'nor', 'si', 1, 'sis_auditoria/vista/norma/Norma.php', 2, '', 'Norma', 'SSOM');
select pxp.f_insert_tgui ('Normas', 'Contiene gestion de normas', 'cnor', 'si', 5, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Tipo Parametro', 'Tipos de Parametro', 'TPR', 'si', 2, 'sis_auditoria/vista/tipo_parametro/TipoParametro.php', 2, '', 'TipoParametro', 'SSOM');
select pxp.f_insert_tgui ('Parametro', 'Parametro', 'PRM', 'si', 3, 'sis_auditoria/vista/parametro/Parametro.php', 2, '', 'Parametro', 'SSOM');
select pxp.f_insert_tgui ('Actividad', 'Actividad', 'ATV', 'si', 5, 'sis_auditoria/vista/actividad/Actividad.php', 2, '', 'Actividad', 'SSOM');
select pxp.f_insert_tgui ('Tipo Estado', 'Tipo Estado Auditoria - OM', 'TET', 'si', 1, 'sis_auditoria/vista/tipo_estado/TipoEstado.php', 2, '', 'TipoEstado', 'SSOM');
select pxp.f_insert_tgui ('Estado', 'Estado AOM', 'EAOM', 'si', 2, 'sis_auditoria/vista/estado/Estado.php', 2, '', 'Estado', 'SSOM');
select pxp.f_insert_tgui ('Configuracion', 'carpeta de configuracion', 'config', 'si', 1, '', 3, '', '', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Proceso', 'Auditoria Proceso', 'AUPC', 'si', 1, 'sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php', 2, '', 'AuditoriaProceso', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Norma', 'Auditoria Norma', 'AUN', 'si', 3, 'sis_auditoria/vista/auditoria_norma/AuditoriaNorma.php', 2, '', 'AuditoriaNorma', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Puntos Norma', 'Auditoria Punto Norma', 'ANPN', 'si', 4, 'sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php', 2, '', 'AuditoriaNpn', 'SSOM');
select pxp.f_insert_tgui ('Auditoria PuntoNormaPregunta', 'Auditoria Puntos Norma Pregunta', 'APNP', 'si', 5, 'sis_auditoria/vista/auditoria_npnpg/AuditoriaNpnpg.php', 2, '', 'AuditoriaNpnpg', 'SSOM');
select pxp.f_insert_tgui ('Asignacion', 'algo', 'QWER', 'si', 3, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Planificación de Auditorias ', 'Gestor de Planificacion de Auditoria', 'PAUDI', 'si', 2, 'sis_auditoria/vista/auditoria_oportunidad_mejora/PlanificarAuditoria.php', 2, '', 'PlanificarAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Equipo Responsable', 'Equipo Responsable de Ejecucion de Auditoria', 'EQRE', 'si', 2, 'sis_auditoria/vista/equipo_responsable/EquipoResponsable.php', 2, '', 'EquipoResponsable', 'SSOM');
select pxp.f_insert_tgui ('Informes de  Auditoria Ejecutados', 'Informes de  Auditoria Ejecutados', 'INFEA', 'si', 3, 'sis_auditoria/vista/auditoria_oportunidad_mejora/InformeAuditoria.php', 2, '', 'InformeAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Actividad Equipo-Responsable', 'Actividad Equipo Responsable', 'AER', 'si', 7, 'sis_auditoria/vista/cronograma_equipo_responsable/CronogramaEquipoResponsable.php', 2, '', 'ActividadEquipoResponsable', 'SSOM');
select pxp.f_insert_tgui ('Programación de auditorias ', 'Gestion de Programacion de Auditorias', 'PAUD', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/ProgramarAuditoria.php', 2, '', 'ProgramarAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Sistemas Integrados para No Conformidad', 'Asignar SI a NC', 'ASINC', 'si', 0, 'sis_auditoria/vista/pnorma_noconformidad/PnormaNoConformidadSi.php', 2, '', 'PnormaNoConformidadSi', 'SSOM');
select pxp.f_insert_tgui ('Parametros', 'Parametros de Auditoria', 'PDAU', 'si', 1, '', 4, '', '', 'SSOM');
select pxp.f_insert_tgui ('Oportunidad Mejora', 'Oportunidad Mejora', 'OPME', 'si', 0, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejora.php', 2, '', 'OportunidadMejora', 'SSOM');
select pxp.f_insert_tgui ('Administracion', 'Configuraciones Administrativas', 'CFADM', 'si', 2, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Destinatario', 'Destinatario AOM', 'DEST', 'si', 8, 'sis_auditoria/vista/destinatario/Destinatario.php', 2, '', 'Destinatario', 'SSOM');
select pxp.f_insert_tgui ('Auditoria', 'Visto Bueno Auditoria', 'VBAUD', 'si', 5, 'sis_auditoria/vista/form_auditoria/FormAuditoria.php', 2, '', 'FormAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Reportes', 'Reporte de Auditorias', 'RPTAUD', 'si', 5, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Tipo Riesgo Oportunidad', 'Tipo Riesgo Oportunidad', 'TRO', 'si', 1, 'sis_auditoria/vista/tipo_ro/TipoRo.php', 5, '', 'TipoRo', 'SSOM');
select pxp.f_insert_tgui ('Riesgo Oportunidad', 'Riesgo Oportunidad', 'RIOP', 'si', 2, 'sis_auditoria/vista/riesgo_oportunidad/RiesgoOportunidad.php', 3, '', 'RiesgoOportunidad', 'SSOM');
select pxp.f_insert_tgui ('Riesgo Oportunidad', 'Riesgo Oportunidad', 'ROP', 'si', 1, '', 4, '', '', 'SSOM');
select pxp.f_insert_tgui ('Probabilidad', 'Probabilidad', 'PROB', 'si', 4, 'sis_auditoria/vista/probabilidad/Probabilidad.php', 5, '', 'Probabilidad', 'SSOM');
select pxp.f_insert_tgui ('Impacto', 'Impacto', 'IMP', 'si', 5, 'sis_auditoria/vista/impacto/Impacto.php', 5, '', 'Impacto', 'SSOM');
select pxp.f_insert_tgui ('Accion - RO', 'Accion Riesgo Oportunidad', 'ARO', 'si', 6, 'sis_auditoria/vista/accion_ro/AccionRo.php', 5, '', 'AccionRo', 'SSOM');
select pxp.f_insert_tgui ('No Conformidad', 'No Conformidad', 'NSC', 'si', 2, 'sis_auditoria/vista/no_conformidad/NoConformidadAdmin.php', 4, '', 'NoConformidadAdmin', 'SSOM');
select pxp.f_insert_tgui ('Programa Anual Auditoria', 'Programa Anual Auditoria', 'PAY', 'si', 1, 'sis_auditoria/vista/form_reporte/FormProgramaAnual.php', 3, '', 'FormProgramaAnual', 'SSOM');
select pxp.f_insert_tgui ('Auditorias', 'Auditorias', 'AUD', 'si', 3, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora', 'Oportunidades de Mejora', 'ODM', 'si', 4, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('No Conformidad Propuestas (Consultor)', 'No Conformidad Propuestas Consultor', 'NCP', 'si', 2, 'sis_auditoria/vista/no_conformidad/NoConformidadSuper.php', 3, '', 'NoConformidadSuper', 'SSOM');
select pxp.f_insert_tgui ('AETR/OM Responsable Área (Pendientes) ', 'Responsable Área', 'ION', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/InformesAuditoriaNotificados.php', 4, '', 'InformesAuditoriaNotificados', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora Programadas', 'Oportunidades de Mejora Programadas', 'OMP', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejora.php', 3, '', 'OportunidadMejora', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora', 'Oportunidades de Mejora', 'ODMS', 'si', 2, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejoraInforme.php', 3, '', 'OportunidadMejoraInforme', 'SSOM');
select pxp.f_insert_tgui ('Equipo Responsable', 'Equipo Responsable', 'ER', 'si', 3, 'sis_auditoria/vista/equipo_auditores/EquipoAuditores.php', 5, '', 'EquipoAuditores', 'SSOM');
select pxp.f_insert_tgui ('No Conformidad sin Acciones Propuestas', 'No conformidades sin propuestas de acciones', 'NCA', 'si', 3, 'sis_auditoria/vista/no_conformidad/NoConformidadSinAcciones.php', 3, '', 'NoConformidadSinAcciones', 'SSOM');
select pxp.f_insert_tgui ('Propuesta de acciones Pendientes Implementar', 'Propuesta de acciones Pendientes de Implementar', 'ICS', 'si', 5, 'sis_auditoria/vista/accion_propuesta/AccionesPropuestaImplementadas.php', 3, '', 'AccionesPropuestaImplementadas', 'SSOM');
select pxp.f_insert_tgui ('Propuesta de acciones Pendientes de Aprobar', 'Propuesta de acciones pendientes de ser Aprobadas', 'AIP', 'si', 4, 'sis_auditoria/vista/accion_propuesta/AccionesProImplementaVoBo.php', 3, '', 'AccionesProImplementaVoBo', 'SSOM');
select pxp.f_insert_tgui ('Propuesta de acciones Pendientes Verificar', 'Propuesta de acciones Pendientes Verificar', 'APA', 'si', 6, 'sis_auditoria/vista/accion_propuesta/AccionesPropuestaAuditor.php', 3, '', 'AccionesPropuestaAuditor', 'SSOM');
select pxp.f_insert_tgui ('Principal', 'Principal', 'PRL', 'si', 2, '', 2, '', '', 'SSOM');
/********************************************F-DAT-MMV-SSOM-01/04/2021********************************************/


/********************************************I-DAT-MMV-SSOM-2-01/04/2021********************************************/

--- Auditoria
select wf.f_import_tproceso_macro ('insert','AUD', 'SSOM', 'Auditoria','si');
select wf.f_import_tcategoria_documento ('insert','legales', 'Legales');
select wf.f_import_tcategoria_documento ('insert','proceso', 'Proceso');
select wf.f_import_ttipo_proceso ('insert','AUDSE',NULL,NULL,'AUD','Seguimiento de Auditoria','ssom.tauditoria_oportunidad_mejora','id_aom','si','','','','AUDSE',NULL);
select wf.f_import_ttipo_estado ('insert','programada','AUDSE','Programada','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Programada','','',NULL,'no',NULL,NULL,NULL);
select wf.f_import_ttipo_estado ('insert','aprobado_responsable','AUDSE','Aprobada por el Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Aprobada Responsable Área','','',NULL,'no',NULL,NULL,NULL);
select wf.f_import_ttipo_estado ('insert','planificacion','AUDSE','Planificada','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Planificada','','',NULL,'no',NULL,NULL,NULL);
select wf.f_import_ttipo_estado ('insert','ejecutada','AUDSE','Ejecutada','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Ejecutada','','',NULL,'no',NULL,NULL,NULL);
select wf.f_import_ttipo_estado ('insert','notificar','AUDSE','Notificada Responsable  Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Notificada Responsable  Área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','curso','AUDSE','En curso','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','En curso','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','aceptado_resp','AUDSE','Aceptado Responsable Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Aceptado Responsable Área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','cerrado','AUDSE','Cerrado','no','no','si','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Cerrado','','',NULL,'no',NULL,'','');
select wf.f_import_testructura_estado ('insert','programada','aprobado_responsable','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','aprobado_responsable','planificacion','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','planificacion','ejecutada','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','ejecutada','notificar','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','notificar','curso','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','curso','aceptado_resp','AUDSE',1,'','no');
select wf.f_import_testructura_estado ('insert','aceptado_resp','cerrado','AUDSE',1,'','no');

--- No conformidad

select wf.f_import_tproceso_macro ('insert','SNOC', 'SSOM', 'No Conformidad','si');
select wf.f_import_tcategoria_documento ('insert','legales', 'Legales');
select wf.f_import_tcategoria_documento ('insert','proceso', 'Proceso');
select wf.f_import_ttipo_proceso ('insert','NOCS',NULL,NULL,'SNOC','No Conformidad','','','si','','','','NOCS',NULL);
select wf.f_import_ttipo_estado ('insert','propuesta','NOCS','Propuesta','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Propuesta','','',NULL,'no',NULL,NULL,NULL);
select wf.f_import_ttipo_estado ('insert','aceptada_resp','NOCS','Aceptado responsable área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Aceptado responsable área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','rechazado_resp','NOCS','Rechazado responsable área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Rechazado responsable área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','acciones','NOCS','Acciones Propuesta Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuesta Responsable','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','acciones_aprobadas','NOCS','Acciones Aprobadas','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Aprobadas','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','acciones_aprobadas_auditor','NOCS','Acciones Aprobadas Auditor','no','no','si','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Aprobadas por Auditor','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_documento ('insert','DOCE','NOCS','Evidencia','Evidencia','','escaneado',1.00,'{}','no','',NULL,'');
select wf.f_import_ttipo_documento ('insert','NOCOF','NOCS','Lista de No Conformidad','Lista de No Conformidad','sis_auditoria/control/NoConformidad/reporteNoConforPDF/','generado',1.00,'{}','si','',NULL,'');
select wf.f_import_testructura_estado ('insert','propuesta','aceptada_resp','NOCS',1,'','no');
select wf.f_import_testructura_estado ('insert','propuesta','rechazado_resp','NOCS',1,'','no');
select wf.f_import_testructura_estado ('insert','aceptada_resp','acciones','NOCS',1,'','no');
select wf.f_import_testructura_estado ('insert','rechazado_resp','propuesta','NOCS',1,'','si');
select wf.f_import_testructura_estado ('insert','acciones','acciones_aprobadas','NOCS',1,'','no');
select wf.f_import_testructura_estado ('insert','acciones_aprobadas','acciones_aprobadas_auditor','NOCS',1,'','no');

-- Acciones

select wf.f_import_tproceso_macro ('insert','ACCN', 'SSOM', 'Acciones','si');
select wf.f_import_tcategoria_documento ('insert','legales', 'Legales');
select wf.f_import_tcategoria_documento ('insert','proceso', 'Proceso');
select wf.f_import_ttipo_proceso ('insert','ACCI',NULL,NULL,'ACCN','Acciones Propuestas','','','si','','','','ACCI',NULL);
select wf.f_import_ttipo_estado ('insert','propuesto','ACCI','Acciones Propuestas Responsable','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Responsable','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','aceptado_resp','ACCI','Acciones Propuestas Aprobadas Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Aprobadas Responsable','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','rechazado_resp','ACCI','Acciones Propuestas  Rechazadas Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas  Rechazadas Responsable','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','aceptado_auditor','ACCI','Acciones Propuestas Aprobadas Auditor','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Aprobadas Auditor','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','rechazado_auditor','ACCI','Acciones Propuestas Rechazadas Auditor','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Acciones Propuestas Rechazadas Auditor','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','implementadas','ACCI','Implementadas','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Implementadas','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','implementado_aceptado_resp','ACCI','Implementadas Aprobadas Responsable  Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Implementadas Aprobadas Responsable  Área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','implementado_rechazado_resp','ACCI','Implementadas Rechazadas Responsable Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Implementadas Rechazadas Responsable Área','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','verificadas','ACCI','Verificadas','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Verificadas','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','rechazado','ACCI','Rechazado por Auditor','no','no','si','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','Rechazado por Auditor','','',NULL,'no',NULL,'','');
select wf.f_import_testructura_estado ('insert','propuesto','aceptado_resp','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','propuesto','rechazado_resp','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','rechazado_resp','propuesto','ACCI',1,'','si');
select wf.f_import_testructura_estado ('insert','aceptado_resp','implementadas','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','propuesto','aceptado_auditor','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','propuesto','rechazado_auditor','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','aceptado_auditor','implementadas','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','rechazado_auditor','propuesto','ACCI',1,'','si');
select wf.f_import_testructura_estado ('insert','implementadas','implementado_aceptado_resp','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','implementadas','implementado_rechazado_resp','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','implementado_rechazado_resp','implementadas','ACCI',1,'','si');
select wf.f_import_testructura_estado ('insert','implementado_aceptado_resp','verificadas','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','verificadas','rechazado','ACCI',1,'','no');
select wf.f_import_testructura_estado ('insert','implementado_aceptado_resp','rechazado','ACCI',1,'','no');

/********************************************F-DAT-MMV-SSOM-2-01/04/2021********************************************/

/********************************************I-DAT-MMV-SSOM-1-05/04/2021********************************************/
select pxp.f_insert_tfuncion ('ssom.ft_norma_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_registra_proceso_disparado_wf', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_aom_riesgo_oportunidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_cronograma_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_repon_accion_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_accion_propuesta_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_npn_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_punto_norma_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_npn_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_procesar_estado_noconformidad', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_resp_sist_integrados_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_proceso_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_parametro_config_auditoria_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_oportunidad_mejora_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_riesgo_oportunidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_actividad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_inicia_tramite', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_actividad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_accion_ro_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_resp_sist_integrados_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_list_process_wf_audit_rfe', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_ro_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_riesgo_oportunidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_id_estado_sigue', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_destinatario_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_cambiar_estado_no_conformidad', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_accion_ro_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_proceso_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_npnpg_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_listar_funcionarios_x_depto', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_fun_inicio_auditoria_wf', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_repon_accion_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_proceso_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_equipo_responsable_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_fun_regreso_auditoria_wf', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_cronograma_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_oportunidad_mejora_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_list_funcionarios_responsables', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_pnorma_noconformidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_get_funcionario_responsable', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_listar_auditor_ap', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_cronograma_equipo_responsable_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_proceso_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_parametro_config_auditoria_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_sistema_integrado_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_auditoria_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_ro_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_parametro_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_parametro_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_probabilidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_destinatario_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_listar_funcionarios_x_uo', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_no_conformidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_grupo_consultivo_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_set_siguiente_estado', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_cronograma_equipo_responsable_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_get_funcionarios_x_uoi', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_accion_propuesta_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_grupo_consultivo_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_sistema_integrado_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_aom_riesgo_oportunidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_competencia_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_no_conformidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_resp_acciones_prop_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_cambiar_estado', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_impacto_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_pnorma_noconformidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_equipo_responsable_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_competencia_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_pregunta_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_equipo_auditores_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_listar_gerente_uo_ap', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_punto_norma_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_si_noconformidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_listar_gerente_uo', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_si_noconformidad_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_probabilidad_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_norma_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_auditoria_npnpg_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_lista_funcionario_gerente_cd_wf_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_procesar_estado', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_equipo_auditores_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_pregunta_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_parametro_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.f_generar_correlativo', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_impacto_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_parametro_ime', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_tipo_auditoria_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tfuncion ('ssom.ft_resp_acciones_prop_sel', 'Funcion para tabla     ', 'SSOM');
select pxp.f_insert_tprocedimiento ('SSOM_NOR_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_norma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOR_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_norma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AURO_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_aom_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AURO_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_aom_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AURO_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_aom_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CRONOG_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_cronograma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_CRONOG_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_cronograma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RAN_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_repon_accion_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RAN_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_repon_accion_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RAN_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_repon_accion_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ACCPRO_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ACCPRO_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ACCPRO_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SIG_IME', 'Cambiar de estado', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANT_IME', 'Estado Anterior', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_APACE_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_IMES_IME', 'Cambiar estado', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ACCNO_IME', 'Cambiar estado', 'si', '', '', 'ssom.ft_accion_propuesta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANPN_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_auditoria_npn_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANPN_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_auditoria_npn_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANPN_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_npn_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNIN_INS', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_npn_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PTONOR_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_punto_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PTONOR_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_punto_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PTONOR_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_punto_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANPN_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_auditoria_npn_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ANPN_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_auditoria_npn_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESSI_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_resp_sist_integrados_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RESSI_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_resp_sist_integrados_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RESSI_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_resp_sist_integrados_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCS_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_proceso_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PCS_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_proceso_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PCAOM_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_parametro_config_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCAOM_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_parametro_config_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCAOM_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_parametro_config_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AOM_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOM_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESU_SEL', 'Resumen', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOMX2_SEL', 'Consult lista funcionario activos', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOMX2_CONT', 'Count funcionarios', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ADPTO_SEL', 'Consult lista funcionario activos', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ADPTO_CONT', 'Count funcionarios', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPA_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPP_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPE_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPN_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPC_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_REPAA_SEL', 'Reporte general Auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOMX1_SEL', 'Consult area list', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOMX1_CONT', 'Count area list', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOES_SEL', 'Consult area list', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AOES_CONT', 'Count area list', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_VANC_SEL', 'Verificacion de accion', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_FUN_SEL', 'Lista Funcionarios vigentes', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_FUN_CONT', 'Lista Funcionarios vigentes', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RIOP_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_riesgo_oportunidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RIOP_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_riesgo_oportunidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ATV_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_actividad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ATV_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_actividad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ATV_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_actividad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ATV_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_actividad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ATV_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_actividad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ARO_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_accion_ro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ARO_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_accion_ro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESSI_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_resp_sist_integrados_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESSI_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_resp_sist_integrados_sel');
select pxp.f_insert_tprocedimiento ('SSOM_USUSI_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_resp_sist_integrados_sel');
select pxp.f_insert_tprocedimiento ('SSOM_USUSI_CONT', 'Cuenta los registros', 'si', '', '', 'ssom.ft_resp_sist_integrados_sel');
select pxp.f_insert_tprocedimiento ('SSOM_TRO_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_tipo_ro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_TRO_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_tipo_ro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RIOP_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RIOP_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RIOP_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_riesgo_oportunidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_DEST_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_destinatario_sel');
select pxp.f_insert_tprocedimiento ('SSOM_DEST_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_destinatario_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ARO_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_accion_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ARO_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_accion_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ARO_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_accion_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AUPC_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_auditoria_proceso_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AUPC_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_auditoria_proceso_sel');
select pxp.f_insert_tprocedimiento ('SSOM_APNP_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_auditoria_npnpg_ime');
select pxp.f_insert_tprocedimiento ('SSOM_APNP_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_auditoria_npnpg_ime');
select pxp.f_insert_tprocedimiento ('SSOM_APNP_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_npnpg_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RAN_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_repon_accion_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RAN_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_repon_accion_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PCS_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCS_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCS_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EQRE_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_EQRE_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_MEQRE_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_MEQRE_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_CRONOG_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_cronograma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CRONOG_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_cronograma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CRONOG_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_cronograma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CROIN_INS', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_cronograma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AOM_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AOM_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AOMSR_MOD', 'Modificacion de resumen de auditoria', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AOM_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_WFAPRO_IME', 'Retrocede el estado proyectos', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_WFBACK_IME', 'Retrocede el estado proyectos', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_WFNEXT_INS', 'Controla el cambio al siguiente estado', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PLA_IME', 'Modificacion de registros', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_GETPRO_IME', 'Recuperar datos proceso', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CORREL_IME', 'Generara correlativo', 'si', '', '', 'ssom.ft_auditoria_oportunidad_mejora_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNNC_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_pnorma_noconformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PNNC_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_pnorma_noconformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_CRER_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_cronograma_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CRER_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_cronograma_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_CRER_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_cronograma_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AUPC_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_auditoria_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AUPC_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_auditoria_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_AUPC_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_INSE_INS', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_auditoria_proceso_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PCAOM_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_parametro_config_auditoria_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PCAOM_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_parametro_config_auditoria_sel');
select pxp.f_insert_tprocedimiento ('SSOM_SISINT_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_sistema_integrado_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SISINT_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_sistema_integrado_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SISINT_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_sistema_integrado_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TAU_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_tipo_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TAU_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_tipo_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TAU_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_tipo_auditoria_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TRO_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_tipo_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TRO_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_tipo_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TRO_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_tipo_ro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRM_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRM_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRM_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TPR_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_tipo_parametro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_TPR_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_tipo_parametro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PROB_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_probabilidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PROB_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_probabilidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PROB_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_probabilidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_DEST_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_destinatario_ime');
select pxp.f_insert_tprocedimiento ('SSOM_DEST_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_destinatario_ime');
select pxp.f_insert_tprocedimiento ('SSOM_DEST_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_destinatario_ime');
select pxp.f_insert_tprocedimiento ('SSOM_DCH_INS', 'check', 'si', '', '', 'ssom.ft_destinatario_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOCONF_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOCONF_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_USU_SEL', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_USU_CONT', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RPT_NOCONF', 'reporte de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_FUO_SEL', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_FUO_CONT', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOCF_SEL', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOCF_CONT', 'sel de registros', 'si', '', '', 'ssom.ft_no_conformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_GCT_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_grupo_consultivo_sel');
select pxp.f_insert_tprocedimiento ('SSOM_GCT_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_grupo_consultivo_sel');
select pxp.f_insert_tprocedimiento ('SSOM_CRER_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_cronograma_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_CRER_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_cronograma_equipo_responsable_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ACCPRO_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_accion_propuesta_sel');
select pxp.f_insert_tprocedimiento ('SSOM_ACCPRO_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_accion_propuesta_sel');
select pxp.f_insert_tprocedimiento ('SSOM_GCT_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_grupo_consultivo_ime');
select pxp.f_insert_tprocedimiento ('SSOM_GCT_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_grupo_consultivo_ime');
select pxp.f_insert_tprocedimiento ('SSOM_GCT_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_grupo_consultivo_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SISINT_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_sistema_integrado_sel');
select pxp.f_insert_tprocedimiento ('SSOM_SISINT_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_sistema_integrado_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AURO_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_aom_riesgo_oportunidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_AURO_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_aom_riesgo_oportunidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_COA_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_competencia_sel');
select pxp.f_insert_tprocedimiento ('SSOM_COA_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_competencia_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOCONF_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOCONF_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOCONF_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SIGA_IME', 'Cambiar de estado', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ANTE_IME', 'Estado Anterior', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_REUO_IME', 'Obtener responsable uo', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RNCUO_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SIAG_IME', 'Cambiar de estado en grupo por estado propuesto', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_INTE_INS', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOGET_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RNACE_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOTOD_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NGET_IME', 'Obtener responsable no conformidad', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_ACES_IME', 'Cambiar estado', 'si', '', '', 'ssom.ft_no_conformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RESAP_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_resp_acciones_prop_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RESAP_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_resp_acciones_prop_ime');
select pxp.f_insert_tprocedimiento ('SSOM_RESAP_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_resp_acciones_prop_ime');
select pxp.f_insert_tprocedimiento ('SSOM_REAF_INS', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_resp_acciones_prop_ime');
select pxp.f_insert_tprocedimiento ('SSOM_IMP_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_impacto_ime');
select pxp.f_insert_tprocedimiento ('SSOM_IMP_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_impacto_ime');
select pxp.f_insert_tprocedimiento ('SSOM_IMP_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_impacto_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNNC_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_pnorma_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNNC_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_pnorma_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNNC_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_pnorma_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PNPN_INS', 'Modificacion de registros', 'si', '', '', 'ssom.ft_pnorma_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EQRE_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EQRE_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EQRE_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EQIS_INS', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_equipo_responsable_ime');
select pxp.f_insert_tprocedimiento ('SSOM_COA_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_competencia_ime');
select pxp.f_insert_tprocedimiento ('SSOM_COA_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_competencia_ime');
select pxp.f_insert_tprocedimiento ('SSOM_COA_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_competencia_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRPTNOR_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_pregunta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRPTNOR_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_pregunta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PRPTNOR_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_pregunta_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EUS_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_equipo_auditores_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EUS_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_equipo_auditores_ime');
select pxp.f_insert_tprocedimiento ('SSOM_EUS_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_equipo_auditores_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PTONOR_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_punto_norma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PTONOR_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_punto_norma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PTOM_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_punto_norma_sel');
select pxp.f_insert_tprocedimiento ('SSOM_SINOCONF_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_si_noconformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_SINOCONF_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_si_noconformidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_SINOCONF_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_si_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SINOCONF_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_si_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_SINOCONF_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_si_noconformidad_ime');
select pxp.f_insert_tprocedimiento ('SSOM_PROB_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_probabilidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PROB_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_probabilidad_sel');
select pxp.f_insert_tprocedimiento ('SSOM_NOR_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOR_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_NOR_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_norma_ime');
select pxp.f_insert_tprocedimiento ('SSOM_APNP_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_auditoria_npnpg_sel');
select pxp.f_insert_tprocedimiento ('SSOM_APNP_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_auditoria_npnpg_sel');
select pxp.f_insert_tprocedimiento ('SSOM_EUS_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_equipo_auditores_sel');
select pxp.f_insert_tprocedimiento ('SSOM_EUS_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_equipo_auditores_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PRPTNOR_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_pregunta_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PRPTNOR_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_pregunta_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PRM_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_parametro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_PRM_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_parametro_sel');
select pxp.f_insert_tprocedimiento ('SSOM_IMP_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_impacto_sel');
select pxp.f_insert_tprocedimiento ('SSOM_IMP_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_impacto_sel');
select pxp.f_insert_tprocedimiento ('SSOM_TPR_INS', 'Insercion de registros', 'si', '', '', 'ssom.ft_tipo_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TPR_MOD', 'Modificacion de registros', 'si', '', '', 'ssom.ft_tipo_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TPR_ELI', 'Eliminacion de registros', 'si', '', '', 'ssom.ft_tipo_parametro_ime');
select pxp.f_insert_tprocedimiento ('SSOM_TAU_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_tipo_auditoria_sel');
select pxp.f_insert_tprocedimiento ('SSOM_TAU_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_tipo_auditoria_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESAP_SEL', 'Consulta de datos', 'si', '', '', 'ssom.ft_resp_acciones_prop_sel');
select pxp.f_insert_tprocedimiento ('SSOM_RESAP_CONT', 'Conteo de registros', 'si', '', '', 'ssom.ft_resp_acciones_prop_sel');
select pxp.f_insert_trol ('', 'SSOM - Admin', 'SSOM');
/********************************************F-DAT-MMV-SSOM-1-05/04/2021********************************************/
