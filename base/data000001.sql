/********************************************I-DAT-MCCH-SSOM-0-30/12/2019********************************************/
------------------------------------------------------------------------
-- Creamos Tipos de Auditoria
------------------------------------------------------------------------
INSERT INTO ssom.ttipo_auditoria ("id_usuario_reg", "estado_reg", "tipo_auditoria", "codigo_tpo_aom", "descrip_tauditoria")
VALUES  (1, E'activo', E'AUDITORIA INTERNA', E'AI', E''),
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

------------------------------------------------------------------------
-- Creamos Proceso de Auditoria
------------------------------------------------------------------------

INSERT INTO ssom.tproceso ("id_usuario_reg", "estado_reg", "id_proceso", "codigo_proceso", "proceso", "acronimo", "descrip_proceso", "id_responsable", "vigencia")
VALUES
(1, E'activo', 32, E'', E'X-Planificación y Programación Operativa y Presupuestaria', E'X-PPOP', E'', 255, E'Si'),
(1, E'activo', 33, E'', E'Gestión Legal', E'GL', E'', 266, E'Si'),
(1, E'activo', 34, E'', E'X-Asesoría Legal', E'X-AL', E'', 266, E'Si'),
(1, E'activo', 2, E'', E'Expansión de la Red', E'ER', E'', 408, E'Si'),
(1, E'activo', 1, E'', E'Auditoria Externa Fatal', E'AEF', E'', 521, E'Si'),
(1, E'activo', 3, E'', E'Servicios de Ingeniería, Construcción y Montaje', E'SICM', E'', 408, E'Si'),
(1, E'activo', 8, E'', E'Gestón de Contablilidad', E'GC', E'', 259, E'Si'),
(1, E'activo', 9, E'', E'X-Control y Seguimiento de Inmovilizados Materiales', E'X-CSIM', E'', 259, E'Si'),
(1, E'activo', 10, E'', E'X-Control de Deudas', E'X-CD', E'', 259, E'Si'),
(1, E'activo', 11, E'', E'X-Análisis de Oportunidades de Negocio', E'X-AON', E'', 259, E'Si'),
(1, E'activo', 12, E'', E'Gestión de Finanzas', E'GF', E'', 271, E'Si'),
(1, E'activo', 13, E'', E'Gestión de Negocio Complementario', E'GNC', E'', 359, E'Si'),
(1, E'activo', 14, E'', E'Operación de la Red', E'OR', E'', 256, E'Si'),
(1, E'activo', 15, E'', E'Análisis de Fallas en la Operación', E'AFO', E'', 256, E'Si'),
(1, E'activo', 16, E'', E'Gestión de Recursos Humanos', E'GRRHH', E'', 261, E'Si'),
(1, E'activo', 17, E'', E'Comunicación y Acción Exterior', E'CAE', E'', 285, E'Si'),
(1, E'activo', 18, E'', E'X-Comunicación Corporativa Externa', E'X-CCE', E'', 285, E'Si'),
(1, E'activo', 19, E'', E'Mejora de la Confiabilidad', E'MC', E'', 254, E'Si'),
(1, E'activo', 20, E'', E'Gestión de Operación y Mantenimiento', E'GOM', E'', 254, E'Si'),
(1, E'activo', 21, E'', E'Gestión de Adquisiciones de Bienes y Servicios', E'GABS', E'', 284, E'Si'),
(1, E'activo', 22, E'', E'X-Desarrollo de la Estrategia', E'X-DE', E'', 291, E'Si'),
(1, E'activo', 23, E'', E'Sistemas Integrados de Gestión', E'SIG', E'', 291, E'Si'),
(1, E'activo', 24, E'', E'X-Desarrollo de Sistemas de Gestión', E'X-DSG', E'', 291, E'Si'),
(1, E'activo', 25, E'', E'X-Coordinación y Control de Gestión', E'X-CCG', E'', 291, E'Si'),
(1, E'activo', 26, E'', E'X-Gestión Estratégica', E'X-GE', E'', 291, E'Si'),
(1, E'activo', 27, E'', E'Gestión Regulatoria', E'GR', E'', 251, E'Si'),
(1, E'activo', 28, E'', E'Gestión de Planificación', E'GPL', E'', 251, E'Si'),
(1, E'activo', 29, E'', E'X-Gestion de Comunicación', E'X-GC', E'', 255, E'Si'),
(1, E'activo', 30, E'', E'X-Evaluación y Mejora de la Gestión', E'X-EMG', E'', 255, E'Si'),
(1, E'activo', 31, E'', E'X-Gestión de Personas', E'X-GPER', E'', 255, E'Si');

/********************************************F-DAT-MCCH-SSOM-0-30/12/2019********************************************/

/********************************************I-DAT-MMV-SSOM-5-4/9/2020********************************************/
------------------------------------------------------------------------------------------------------------------------
--COPY LINES TO SUBSYSTEM data.sql FILE
--Datos de Configuracion: Proceso Macro, Tipo Proceso, Tipo Estado y Estructura de Estados de worflow del Sistema SSOM
------------------------------------------------------------------------------------------------------------------------
select wf.f_import_tcategoria_documento ('insert','legales', 'Legales');
select wf.f_import_tcategoria_documento ('insert','proceso', 'Proceso');
select wf.f_import_ttipo_proceso ('insert','AUDSE',NULL,NULL,'AUD','Seguimiento de Auditoria','ssom.tauditoria_oportunidad_mejora','id_aom','si','','','','AUDSE',NULL);
select wf.f_import_ttipo_proceso ('insert','AUNC',NULL,NULL,'AUD','No Conformidad','','','no','','','','AUNC',NULL);
select wf.f_import_ttipo_proceso ('insert','ACCP',NULL,NULL,'AUD','Acciones Propuestas','','','','','','','ACCP',NULL);
select wf.f_import_ttipo_estado ('insert','propuesta','AUNC','Propuesta de No Conformidad','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','programada','AUDSE','Programada','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','propuesta','ACCP','Accion propuesta','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','aprobado_responsable','AUDSE','Aprobada por el Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','planificacion','AUDSE','Planificada','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','ejecutada','AUDSE','Ejecutada','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','notificar','AUDSE','Notificar','no','no','no','ninguno','','ninguno','','','si','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','notificar_responsable','AUDSE','Notificar responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','aceptada_responsable_area','AUNC','Aceptada por el Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','rechazada_responsable_area','AUNC','Rechazada por el Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','acciones_propuestas_responsable','AUNC','Acciones Propuestas a Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','correccion','AUNC','Correccion de la No Conformidad','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','accion_aprobada_responsable','ACCP','Acción Aprobada por Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','accion_rechazada_responsable','ACCP','Acción Rechazada por Responsable','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','accion_aprobada_auditor','ACCP','Acción Aprobada por Auditor','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','accion_rechazada_auditor','ACCP','Acción Rechazada por Auditor','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','implementadas','ACCP','Implementadas','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','implementadas_aprobadas_resp','ACCP','Implementadas Aprobadas por Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','implementadas_rechazadas_resp','ACCP','Implementadas Rechazadas por el Responsable de Área','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','rechazado','ACCP','Rechazado','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','verificado','ACCP','Verificado','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','acciones_propuestas','AUDSE','Acciones Propuestas','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','en_curso','AUDSE','En Curso','no','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL);
select wf.f_import_ttipo_estado ('insert','cerrado','AUDSE','Cerrado','no','no','si','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','si','','','','','','','',NULL);
select wf.f_import_ttipo_documento ('insert','AREV','AUNC','Archivos Evidencia','Archivos Evidencia','','escaneado',1.00,'{}');
select wf.f_import_testructura_estado ('insert','programada','aprobado_responsable','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','aprobado_responsable','planificacion','AUDSE',1,'"{$tabla.id_tipo_auditoria}"=1');
select wf.f_import_testructura_estado ('insert','planificacion','ejecutada','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','ejecutada','notificar_responsable','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','notificar_responsable','notificar','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','aprobado_responsable','ejecutada','AUDSE',1,'"{$tabla.id_tipo_auditoria}"=2');
select wf.f_import_testructura_estado ('insert','propuesta','aceptada_responsable_area','AUNC',1,'');
select wf.f_import_testructura_estado ('insert','propuesta','rechazada_responsable_area','AUNC',1,'');
select wf.f_import_testructura_estado ('insert','aceptada_responsable_area','acciones_propuestas_responsable','AUNC',1,'');
select wf.f_import_testructura_estado ('insert','acciones_propuestas_responsable','correccion','AUNC',1,'');
select wf.f_import_testructura_estado ('insert','rechazada_responsable_area','propuesta','AUNC',1,'');
select wf.f_import_testructura_estado ('insert','propuesta','accion_aprobada_responsable','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','propuesta','accion_rechazada_responsable','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_aprobada_responsable','accion_aprobada_auditor','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_aprobada_responsable','accion_rechazada_auditor','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_rechazada_responsable','propuesta','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_aprobada_auditor','accion_rechazada_auditor','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_aprobada_auditor','implementadas','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','accion_rechazada_auditor','propuesta','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','implementadas','implementadas_aprobadas_resp','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','implementadas','implementadas_rechazadas_resp','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','implementadas_aprobadas_resp','verificado','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','implementadas_aprobadas_resp','rechazado','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','implementadas_rechazadas_resp','propuesta','ACCP',1,'');
select wf.f_import_testructura_estado ('insert','notificar','acciones_propuestas','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','acciones_propuestas','en_curso','AUDSE',1,'');
select wf.f_import_testructura_estado ('insert','en_curso','cerrado','AUDSE',1,'');
/********************************************F-DAT-MMV-SSOM-5-4/9/2020********************************************/

/********************************************I-DAT-MCCH-SSOM-2-31/12/2019********************************************/
-----------------------------------------------------------
-- Datos de parametros de configuracion de auditoria
-----------------------------------------------------------
INSERT INTO ssom.tparametro_config_auditoria ("id_usuario_reg", "estado_reg", "param_gestion", "param_fecha_a", "param_fecha_b", "param_prefijo", "param_serie")
VALUES
(1, E'activo', 2019, E'2019-01-01', E'2019-12-31', E'EAOM', E'00000');

/********************************************F-DAT-MCCH-SSOM-2-31/12/2019********************************************/
/********************************************I-DAT-MMV-SSOM-6-4/9/2020********************************************/
select pxp.f_insert_tgui ('<i class="fa fa-check-square-o" style="font-size:30px;" ></i>SEGUIMIENTO A OPORTUNIDADES DE MEJORA', '', 'SSOM', 'si', 1, '', 1, '', '', 'SSOM');
select pxp.f_insert_tgui ('Tipo Auditoria', 'Tipo Auditoria', 'TAU', 'si', 1, 'sis_auditoria/vista/tipo_auditoria/TipoAuditoria.php', 2, '', 'TipoAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Grupo Consultivo', 'Grupo Consultivo', 'GCT', 'si', 4, 'sis_auditoria/vista/grupo_consultivo/GrupoConsultivo.php', 2, '', 'GrupoConsultivo', 'SSOM');
select pxp.f_insert_tgui ('Proceso Auditable', 'Procesos Auditables', 'PCS', 'si', 2, 'sis_auditoria/vista/proceso/Proceso.php', 2, '', 'Proceso', 'SSOM');
select pxp.f_insert_tgui ('Gestion de Normas', 'Administra la gestión de normas', 'nor', 'si', 1, 'sis_auditoria/vista/norma/Norma.php', 2, '', 'Norma', 'SSOM');
select pxp.f_insert_tgui ('Normas', 'Contiene gestion de normas', 'cnor', 'si', 5, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Tipo Parametro', 'Tipos de Parametro', 'TPR', 'si', 2, 'sis_auditoria/vista/tipo_parametro/TipoParametro.php', 2, '', 'TipoParametro', 'SSOM');
select pxp.f_insert_tgui ('Parametro', 'Parametro', 'PRM', 'si', 3, 'sis_auditoria/vista/parametro/Parametro.php', 2, '', 'Parametro', 'SSOM');
select pxp.f_insert_tgui ('Actividad', 'Actividad', 'ATV', 'si', 5, 'sis_auditoria/vista/actividad/Actividad.php', 2, '', 'Actividad', 'SSOM');
select pxp.f_delete_tgui ('cges');
select pxp.f_insert_tgui ('Tipo Estado', 'Tipo Estado Auditoria - OM', 'TET', 'si', 1, 'sis_auditoria/vista/tipo_estado/TipoEstado.php', 2, '', 'TipoEstado', 'SSOM');
select pxp.f_insert_tgui ('Estado', 'Estado AOM', 'EAOM', 'si', 2, 'sis_auditoria/vista/estado/Estado.php', 2, '', 'Estado', 'SSOM');
select pxp.f_insert_tgui ('Configuracion', 'carpeta de configuracion', 'config', 'si', 1, '', 3, '', '', 'SSOM');
select pxp.f_insert_tgui ('Sistemas Integrados', 'Gestion sistemas integrados', 'SINT', 'si', 3, 'sis_auditoria/vista/sistema_integrado/SistemaIntegrado.php', 4, '', 'SistemaIntegrado', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Proceso', 'Auditoria Proceso', 'AUPC', 'si', 1, 'sis_auditoria/vista/auditoria_proceso/AuditoriaProceso.php', 2, '', 'AuditoriaProceso', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Norma', 'Auditoria Norma', 'AUN', 'si', 3, 'sis_auditoria/vista/auditoria_norma/AuditoriaNorma.php', 2, '', 'AuditoriaNorma', 'SSOM');
select pxp.f_insert_tgui ('Auditoria Puntos Norma', 'Auditoria Punto Norma', 'ANPN', 'si', 4, 'sis_auditoria/vista/auditoria_npn/AuditoriaNpn.php', 2, '', 'AuditoriaNpn', 'SSOM');
select pxp.f_insert_tgui ('Auditoria PuntoNormaPregunta', 'Auditoria Puntos Norma Pregunta', 'APNP', 'si', 5, 'sis_auditoria/vista/auditoria_npnpg/AuditoriaNpnpg.php', 2, '', 'AuditoriaNpnpg', 'SSOM');
select pxp.f_insert_tgui ('Asignacion', 'algo', 'QWER', 'si', 3, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Planificar Auditoria', 'Gestor de Planificacion de Auditoria', 'PAUDI', 'si', 2, 'sis_auditoria/vista/auditoria_oportunidad_mejora/PlanificarAuditoria.php', 2, '', 'PlanificarAuditoria', 'SSOM');
select pxp.f_delete_tgui ('GAUDI');
select pxp.f_insert_tgui ('Equipo Responsable', 'Equipo Responsable de Ejecucion de Auditoria', 'EQRE', 'si', 2, 'sis_auditoria/vista/equipo_responsable/EquipoResponsable.php', 2, '', 'EquipoResponsable', 'SSOM');
select pxp.f_insert_tgui ('Informe Auditoria', 'Informe Auditoria y Registro de No Conformidades', 'INFEA', 'si', 3, 'sis_auditoria/vista/auditoria_oportunidad_mejora/InformeAuditoria.php', 2, '', 'InformeAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Actividad Equipo-Responsable', 'Actividad Equipo Responsable', 'AER', 'si', 7, 'sis_auditoria/vista/cronograma_equipo_responsable/CronogramaEquipoResponsable.php', 2, '', 'ActividadEquipoResponsable', 'SSOM');
select pxp.f_insert_tgui ('Programar Auditoria', 'Gestion de Programacion de Auditorias', 'PAUD', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/ProgramarAuditoria.php', 2, '', 'ProgramarAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Sistemas Integrados para No Conformidad', 'Asignar SI a NC', 'ASINC', 'si', 0, 'sis_auditoria/vista/pnorma_noconformidad/PnormaNoConformidadSi.php', 2, '', 'PnormaNoConformidadSi', 'SSOM');
select pxp.f_insert_tgui ('Parametros', 'Parametros de Auditoria', 'PDAU', 'si', 1, '', 4, '', '', 'SSOM');
select pxp.f_delete_tgui ('AUDIN');
select pxp.f_insert_tgui ('Oportunidad Mejora', 'Oportunidad Mejora', 'OPME', 'si', 0, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejora.php', 2, '', 'OportunidadMejora', 'SSOM');
select pxp.f_insert_tgui ('Administracion', 'Configuraciones Administrativas', 'CFADM', 'si', 2, '', 2, '', '', 'SSOM');
select pxp.f_delete_tgui ('INFOM');
select pxp.f_insert_tgui ('Destinatario', 'Destinatario AOM', 'DEST', 'si', 8, 'sis_auditoria/vista/destinatario/Destinatario.php', 2, '', 'Destinatario', 'SSOM');
select pxp.f_delete_tgui ('VBPLA');
select pxp.f_delete_tgui ('VBINFA');
select pxp.f_insert_tgui ('Auditoria', 'Visto Bueno Auditoria', 'VBAUD', 'si', 5, 'sis_auditoria/vista/form_auditoria/FormAuditoria.php', 2, '', 'FormAuditoria', 'SSOM');
select pxp.f_delete_tgui ('VBAOM');
select pxp.f_insert_tgui ('Reportes', 'Reporte de Auditorias', 'RPTAUD', 'si', 5, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Reporte de Auditorias', 'Reporte de Auditorias', 'RPTA', 'no', 1, 'sis_auditoria/vista/reportes/FormFiltroAuditoria.php', 2, '', 'FormFiltroAuditoria', 'SSOM');
select pxp.f_insert_tgui ('Reporte de OM', 'Reportes de Oportunidades de Mejora', 'RPTOM', 'no', 2, 'sis_auditoria/vista/reportes/FormFiltroOportunidadMejora.php', 3, '', 'FormFiltroOportunidadMejora', 'SSOM');
select pxp.f_delete_tgui ('NCSEG');
select pxp.f_insert_tgui ('Tipo Riesgo Oportunidad', 'Tipo Riesgo Oportunidad', 'TRO', 'si', 1, 'sis_auditoria/vista/tipo_ro/TipoRo.php', 5, '', 'TipoRo', 'SSOM');
select pxp.f_insert_tgui ('Riesgo Oportunidad', 'Riesgo Oportunidad', 'RIOP', 'si', 2, 'sis_auditoria/vista/riesgo_oportunidad/RiesgoOportunidad.php', 3, '', 'RiesgoOportunidad', 'SSOM');
select pxp.f_insert_tgui ('Riesgo Oportunidad', 'Riesgo Oportunidad', 'ROP', 'si', 1, '', 4, '', '', 'SSOM');
select pxp.f_insert_tgui ('Probabilidad', 'Probabilidad', 'PROB', 'si', 4, 'sis_auditoria/vista/probabilidad/Probabilidad.php', 5, '', 'Probabilidad', 'SSOM');
select pxp.f_insert_tgui ('Impacto', 'Impacto', 'IMP', 'si', 5, 'sis_auditoria/vista/impacto/Impacto.php', 5, '', 'Impacto', 'SSOM');
select pxp.f_insert_tgui ('Accion - RO', 'Accion Riesgo Oportunidad', 'ARO', 'si', 6, 'sis_auditoria/vista/accion_ro/AccionRo.php', 5, '', 'AccionRo', 'SSOM');
select pxp.f_delete_tgui ('SER');
select pxp.f_delete_tgui ('IFS');
select pxp.f_insert_tgui ('No Conformidad', 'No Conformidad', 'NSC', 'si', 2, 'sis_auditoria/vista/no_conformidad/NoConformidadAdmin.php', 4, '', 'NoConformidadAdmin', 'SSOM');
select pxp.f_insert_tgui ('Programa Anual Auditoria', 'Programa Anual Auditoria', 'PAY', 'si', 1, 'sis_auditoria/vista/form_reporte/FormProgramaAnual.php', 3, '', 'FormProgramaAnual', 'SSOM');
select pxp.f_delete_tgui ('SAS');
select pxp.f_insert_tgui ('Auditorias', 'Auditorias', 'AUD', 'si', 2, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora', 'Oportunidades de Mejora', 'ODM', 'si', 4, '', 2, '', '', 'SSOM');
select pxp.f_insert_tgui ('Seguimiento', 'Seguimiento', 'SGUI', 'si', 4, '', 3, '', '', 'SSOM');
select pxp.f_insert_tgui ('Propuestas/Aceptadas/Rechazadas', 'No Conformidades Propuestas/Aceptadas/Rechazadas', 'NCP', 'si', 4, 'sis_auditoria/vista/auditoria_oportunidad_mejora/AuditorioAportunidadAcepRech.php', 3, '', 'AuditorioAportunidadAcepRech', 'SSOM');
select pxp.f_insert_tgui ('Informes de Auditoria y OM Notificados', 'Informes de Auditoria y OM Notificados', 'ION', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/InformesAuditoriaNotificados.php', 4, '', 'InformesAuditoriaNotificados', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora Programadas', 'Oportunidades de Mejora Programadas', 'OMP', 'si', 1, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejora.php', 3, '', 'OportunidadMejora', 'SSOM');
select pxp.f_insert_tgui ('Oportunidades de Mejora', 'Oportunidades de Mejora', 'ODMS', 'si', 2, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejoraInforme.php', 3, '', 'OportunidadMejoraInforme', 'SSOM');
select pxp.f_insert_tgui ('Propuestas/Aceptadas/Rechazadas', 'Propuestas/Aceptadas/Rechazadas', 'POMD', 'si', 3, 'sis_auditoria/vista/auditoria_oportunidad_mejora/OportunidadMejoraAcepRech.php', 3, '', 'OportunidadMejoraAcepRech', 'SSOM');
select pxp.f_insert_tgui ('Acciones Pendientes', 'Acciones Pendientes', 'APD', 'si', 3, 'sis_auditoria/vista/no_conformidad/NoConformidadAccion.php', 4, '', 'NoConformidadAccion', 'SSOM');
select pxp.f_insert_tgui ('Acciones Implementadas', 'Acciones Implementadas', 'AID', 'si', 4, 'sis_auditoria/vista/no_conformidad/NoConformidadImplementar.php', 4, '', 'NoConformidadImplementar', 'SSOM');
/********************************************F-DAT-MMV-SSOM-6-4/9/2020********************************************/
