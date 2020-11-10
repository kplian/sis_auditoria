/***********************************I-SCP-MCCH-SSOM-0-26/12/2019*****************************************/
    CREATE TABLE ssom.taccion_propuesta (
    id_ap SERIAL,
    id_nc INTEGER,
    id_parametro INTEGER,
    descrip_causa_nc TEXT,
    descripcion_ap TEXT,
    efectividad_cumpl_ap TEXT,
    fecha_inicio_ap DATE,
    fecha_fin_ap DATE,
    id_funcionario INTEGER,
    obs_resp_area TEXT,
    obs_auditor_consultor TEXT,
    id_proceso_wf INTEGER,
    id_estado_wf INTEGER,
    nro_tramite VARCHAR(100),
    estado_wf VARCHAR(100),
    codigo_ap VARCHAR(100),
    revisar VARCHAR(5) DEFAULT 'no'::character varying,
    rechazar VARCHAR(5) DEFAULT 'no'::character varying,
    implementar VARCHAR(5) DEFAULT 'no'::character varying,
    observacion TEXT,
    CONSTRAINT taccion_propuesta_pkey PRIMARY KEY(id_ap)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    COMMENT ON COLUMN ssom.taccion_propuesta.id_funcionario
    IS 'Funcion que aprueba la accion propuesta';

    ALTER TABLE ssom.taccion_propuesta
    OWNER TO postgres;

    CREATE TABLE ssom.tactividad (
    id_actividad SERIAL,
    actividad VARCHAR(500) NOT NULL,
    codigo_actividad VARCHAR(50),
    obs_actividad TEXT,
    CONSTRAINT tactividad_pkey PRIMARY KEY(id_actividad)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tactividad
    OWNER TO postgres;

    CREATE TABLE ssom.tauditoria_npn (
    id_anpn SERIAL,
    id_norma INTEGER,
    id_pn INTEGER NOT NULL,
    id_aom INTEGER,
    obs_apn TEXT,
    CONSTRAINT tauditoria_npn_pkey PRIMARY KEY(id_anpn)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tauditoria_npn
    OWNER TO postgres;

    CREATE TABLE ssom.tauditoria_npnpg (
    id_anpnpg SERIAL,
    id_anpn INTEGER NOT NULL,
    id_pregunta INTEGER NOT NULL,
    pg_valoracion VARCHAR(20),
    obs_pg TEXT,
    id_aom INTEGER,
    CONSTRAINT tauditoria_npnpg_pkey PRIMARY KEY(id_anpnpg)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tauditoria_npnpg
    OWNER TO postgres;

    CREATE TABLE ssom.tauditoria_oportunidad_mejora (
      id_aom SERIAL,
      id_tipo_auditoria INTEGER,
      id_uo INTEGER,
      id_gconsultivo INTEGER,
      documento VARCHAR(150),
      codigo_aom VARCHAR(50),
      nombre_aom1 VARCHAR(300),
      descrip_aom1 TEXT,
      id_funcionario INTEGER,
      fecha_prog_inicio DATE,
      fecha_prog_fin DATE,
      lugar VARCHAR(300),
      fecha_prev_inicio DATE,
      fecha_prev_fin DATE,
      id_tnorma INTEGER,
      id_tobjeto INTEGER,
      resumen TEXT,
      recomendacion TEXT,
      fecha_eje_inicio DATE,
      fecha_eje_fin DATE,
      id_tipo_om INTEGER,
      formulario_ingreso TEXT,
      estado_form_ingreso INTEGER,
      id_proceso_wf INTEGER,
      id_estado_wf INTEGER,
      nro_tramite_wf VARCHAR(100),
      estado_wf VARCHAR(100),
      id_destinatario INTEGER,
      id_gestion INTEGER,
      nro_tramite VARCHAR(100),
      CONSTRAINT tauditoria_oportunidad_mejora_pkey PRIMARY KEY(id_aom)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tauditoria_oportunidad_mejora
      OWNER TO postgres;

    CREATE TABLE ssom.tauditoria_proceso (
      id_aproceso SERIAL,
      id_aom INTEGER NOT NULL,
      id_proceso INTEGER,
      ap_valoracion VARCHAR(20),
      obs_pcs TEXT,
      CONSTRAINT tauditoria_proceso_pkey PRIMARY KEY(id_aproceso)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tauditoria_proceso
      OWNER TO postgres;

      CREATE TABLE ssom.tcompetencia (
      id_competencia SERIAL,
      id_equipo_auditores INTEGER,
      id_norma INTEGER,
      nro_auditorias INTEGER DEFAULT 0,
      hras_formacion INTEGER DEFAULT 0,
      meses_actualizacion INTEGER DEFAULT 0,
      calificacion VARCHAR(50),
      CONSTRAINT tcompetencia_pkey PRIMARY KEY(id_competencia)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN id_competencia SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN id_equipo_auditores SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN id_norma SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN nro_auditorias SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN hras_formacion SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN meses_actualizacion SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      ALTER COLUMN calificacion SET STATISTICS 0;

    ALTER TABLE ssom.tcompetencia
      OWNER TO postgres;

      CREATE TABLE ssom.tcorrelativo (
      id_corre SERIAL,
      codigo_correlativo VARCHAR(50),
      id_gestion INTEGER,
      nro_actual NUMERIC,
      nro_siguiente NUMERIC,
      CONSTRAINT tcorrelativo_pkey PRIMARY KEY(id_corre)
    )
    WITH (oids = false);

    ALTER TABLE ssom.tcorrelativo
      OWNER TO postgres;

      CREATE TABLE ssom.tcronograma (
      id_cronograma SERIAL,
      id_aom INTEGER NOT NULL,
      id_actividad INTEGER NOT NULL,
      fecha_ini_activ DATE,
      fecha_fin_activ DATE,
      hora_ini_activ TIME WITHOUT TIME ZONE,
      hora_fin_activ TIME WITHOUT TIME ZONE,
      nueva_actividad VARCHAR(500),
      obs_actividad TEXT,
      CONSTRAINT tcronograma_pkey PRIMARY KEY(id_cronograma)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tcronograma
      OWNER TO postgres;

    CREATE TABLE ssom.tcronograma_equipo_responsable (
      id_cronog_eq_resp SERIAL,
      id_cronograma INTEGER NOT NULL,
      id_equipo_responsable INTEGER,
      v_participacion VARCHAR(20),
      obs_participacion TEXT,
      id_funcionario INTEGER,
      CONSTRAINT tcronograma_equipo_responsable_pkey PRIMARY KEY(id_cronog_eq_resp)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tcronograma_equipo_responsable
      OWNER TO postgres;

    CREATE TABLE ssom.tequipo_auditores (
      id_equipo_auditores SERIAL,
      id_funcionario INTEGER,
      id_tipo_participacion INTEGER,
      CONSTRAINT tequipo_auditores_pkey PRIMARY KEY(id_equipo_auditores)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tequipo_auditores
      ALTER COLUMN id_equipo_auditores SET STATISTICS 0;

    ALTER TABLE ssom.tequipo_auditores
      ALTER COLUMN id_funcionario SET STATISTICS 0;

    ALTER TABLE ssom.tequipo_auditores
      ALTER COLUMN id_tipo_participacion SET STATISTICS 0;

    COMMENT ON COLUMN ssom.tequipo_auditores.id_tipo_participacion
    IS 'id_tipo_participacion = id_tipo_parametro filtro TIPO_PARTICIPACION';

    ALTER TABLE ssom.tequipo_auditores
      OWNER TO postgres;

      CREATE TABLE ssom.tequipo_responsable (
      id_equipo_responsable SERIAL,
      id_aom INTEGER NOT NULL,
      id_funcionario INTEGER,
      exp_tec_externo VARCHAR(50),
      id_parametro INTEGER,
      obs_participante VARCHAR(100),
      CONSTRAINT tequipo_responsable_pkey PRIMARY KEY(id_equipo_responsable)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tequipo_responsable
      OWNER TO postgres;

    CREATE TABLE ssom.tgrupo_consultivo (
    id_gconsultivo SERIAL,
    id_empresa INTEGER NOT NULL,
    nombre_gconsultivo VARCHAR(100) NOT NULL,
    descrip_gconsultivo TEXT,
    requiere_programacion VARCHAR(10) NOT NULL,
    requiere_formulario VARCHAR(1) NOT NULL,
    nombre_programacion VARCHAR(80),
    nombre_formulario VARCHAR(80),
    CONSTRAINT tgrupo_consultivo_pkey PRIMARY KEY(id_gconsultivo)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tgrupo_consultivo
    OWNER TO postgres;

    CREATE TABLE ssom.timpacto (
    id_impacto SERIAL,
    nombre_imp VARCHAR(50) NOT NULL,
    desc_imp TEXT,
    CONSTRAINT timpacto_pkey PRIMARY KEY(id_impacto)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.timpacto
    OWNER TO postgres;

    CREATE TABLE ssom.tno_conformidad (
    id_nc SERIAL,
    id_aom INTEGER,
    id_parametro INTEGER NOT NULL,
    id_uo INTEGER,
    descrip_nc VARCHAR(10000),
    evidencia VARCHAR(500),
    obs_resp_area TEXT,
    obs_consultor TEXT,
    id_funcionario INTEGER,
    id_uo_adicional INTEGER,
    id_proceso_wf INTEGER,
    id_estado_wf INTEGER,
    nro_tramite VARCHAR(100),
    estado_wf VARCHAR(100),
    codigo_nc VARCHAR(100),
    id_funcionario_nc INTEGER,
    calidad BOOLEAN DEFAULT false,
    medio_ambiente BOOLEAN DEFAULT false,
    responsabilidad_social BOOLEAN DEFAULT false,
    seguridad BOOLEAN DEFAULT false,
    sistemas_integrados BOOLEAN DEFAULT false,
    revisar VARCHAR(5) DEFAULT 'no'::character varying,
    rechazar VARCHAR(5) DEFAULT 'no'::character varying,
    CONSTRAINT tno_conformidad_pkey PRIMARY KEY(id_nc)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tno_conformidad
    OWNER TO postgres;

    CREATE TABLE ssom.tnorma (
    id_norma SERIAL,
    id_parametro INTEGER NOT NULL,
    sigla_norma VARCHAR(250) NOT NULL,
    nombre_norma VARCHAR(500) NOT NULL,
    descrip_norma TEXT NOT NULL,
    CONSTRAINT tnorma_pkey PRIMARY KEY(id_norma)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tnorma
    OWNER TO postgres;

    CREATE TABLE ssom.tparametro (
    id_parametro SERIAL,
    id_tipo_parametro INTEGER NOT NULL,
    valor_parametro VARCHAR(50) NOT NULL,
    codigo_parametro VARCHAR(20),
    CONSTRAINT tparametro_codigo_parametro_key UNIQUE(codigo_parametro),
    CONSTRAINT tparametro_pkey PRIMARY KEY(id_parametro)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tparametro
    OWNER TO postgres;

    CREATE TABLE ssom.tparametro_aom (
    id_parametro_aom SERIAL,
    id_aom INTEGER NOT NULL,
    id_parametro INTEGER NOT NULL,
    obs_param_aom TEXT,
    CONSTRAINT tparametro_aom_pkey PRIMARY KEY(id_parametro_aom)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tparametro_aom
    OWNER TO postgres;

    CREATE TABLE ssom.tparametro_config_auditoria (
    id_param_config_aom SERIAL,
    param_gestion INTEGER NOT NULL,
    param_fecha_a DATE NOT NULL,
    param_fecha_b DATE NOT NULL,
    param_prefijo VARCHAR(20) NOT NULL,
    param_serie VARCHAR(20),
    param_estado_config VARCHAR(50),
    CONSTRAINT tparametro_config_auditoria_pkey PRIMARY KEY(id_param_config_aom)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tparametro_config_auditoria
    OWNER TO postgres;

    CREATE TABLE ssom.tpnorma_noconformidad (
    id_pnnc SERIAL,
    id_nc INTEGER NOT NULL,
    id_pn INTEGER NOT NULL,
    id_norma INTEGER,
    CONSTRAINT tpnorma_noconformidad_pkey PRIMARY KEY(id_pnnc)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tpnorma_noconformidad
    OWNER TO postgres;

    CREATE TABLE ssom.tpregunta (
    id_pregunta SERIAL,
    id_pn INTEGER NOT NULL,
    nro_pregunta INTEGER NOT NULL,
    descrip_pregunta TEXT NOT NULL,
    CONSTRAINT tpregunta_pkey PRIMARY KEY(id_pregunta)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tpregunta
    OWNER TO postgres;

    CREATE TABLE ssom.tprobabilidad (
    id_probabilidad SERIAL,
    nombre_prob VARCHAR(50) NOT NULL,
    desc_prob TEXT,
    CONSTRAINT tprobabilidad_pkey PRIMARY KEY(id_probabilidad)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tprobabilidad
    OWNER TO postgres;

    CREATE TABLE ssom.tproceso (
    id_proceso SERIAL,
    codigo_proceso VARCHAR(50),
    proceso VARCHAR(100) NOT NULL,
    acronimo VARCHAR(30),
    descrip_proceso TEXT,
    id_responsable INTEGER NOT NULL,
    vigencia VARCHAR(50) NOT NULL,
    CONSTRAINT tproceso_acronimo_key UNIQUE(acronimo),
    CONSTRAINT tproceso_pkey PRIMARY KEY(id_proceso)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tproceso
    OWNER TO postgres;

    CREATE TABLE ssom.tpunto_norma (
    id_pn SERIAL,
    id_norma INTEGER NOT NULL,
    codigo_pn VARCHAR(250) NOT NULL,
    nombre_pn VARCHAR(500) NOT NULL,
    descrip_pn TEXT,
    CONSTRAINT tpunto_norma_pkey PRIMARY KEY(id_pn)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tpunto_norma
    OWNER TO postgres;

    CREATE TABLE ssom.trepon_accion (
    id_repon_accion SERIAL,
    id_ap INTEGER NOT NULL,
    id_funcionario INTEGER NOT NULL,
    CONSTRAINT trepon_accion_pkey PRIMARY KEY(id_repon_accion)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.trepon_accion
    ALTER COLUMN id_repon_accion SET STATISTICS 0;

    ALTER TABLE ssom.trepon_accion
    ALTER COLUMN id_ap SET STATISTICS 0;

    ALTER TABLE ssom.trepon_accion
    ALTER COLUMN id_funcionario SET STATISTICS 0;

    ALTER TABLE ssom.trepon_accion
    OWNER TO postgres;

    CREATE TABLE ssom.tresp_acciones_prop (
    id_respap SERIAL,
    id_ap INTEGER,
    id_funcionario INTEGER,
    id_nc INTEGER,
    CONSTRAINT tresp_acciones_prop_pkey PRIMARY KEY(id_respap)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tresp_acciones_prop
    OWNER TO postgres;

    CREATE TABLE ssom.tresp_sist_integrados (
    id_respsi SERIAL,
    id_funcionario INTEGER,
    id_si INTEGER NOT NULL,
    CONSTRAINT tresp_sist_integrados_pkey PRIMARY KEY(id_respsi)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tresp_sist_integrados
    OWNER TO postgres;

    CREATE TABLE ssom.tresponsable_accion (
    id_responsable_acccion SERIAL,
    id_funcionario INTEGER,
    aprobo VARCHAR(20) DEFAULT 'no'::character varying,
    CONSTRAINT tresponsable_acccion_pkey PRIMARY KEY(id_responsable_acccion)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tresponsable_accion
    ALTER COLUMN id_responsable_acccion SET STATISTICS 0;

    ALTER TABLE ssom.tresponsable_accion
    ALTER COLUMN id_funcionario SET STATISTICS 0;

    ALTER TABLE ssom.tresponsable_accion
    ALTER COLUMN aprobo SET STATISTICS 0;

    ALTER TABLE ssom.tresponsable_accion
    OWNER TO postgres;

    CREATE TABLE ssom.triesgo_oportunidad (
    id_ro SERIAL,
    id_tipo_ro INTEGER NOT NULL,
    nombre_ro VARCHAR(150) NOT NULL,
    codigo_ro VARCHAR(50),
    CONSTRAINT triesgo_oportunidad_codigo_ro_key UNIQUE(codigo_ro),
    CONSTRAINT triesgo_oportunidad_pkey PRIMARY KEY(id_ro)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.triesgo_oportunidad
    OWNER TO postgres;

    CREATE TABLE ssom.tsi_noconformidad (
    id_sinc SERIAL,
    id_si INTEGER,
    id_nc INTEGER,
    CONSTRAINT tsi_noconformidad_pkey PRIMARY KEY(id_sinc)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tsi_noconformidad
    OWNER TO postgres;

    CREATE TABLE ssom.tsistema_integrado (
    id_si SERIAL,
    nombre_si VARCHAR(250),
    descrip_si VARCHAR(500),
    CONSTRAINT tsistema_integrado_pkey PRIMARY KEY(id_si)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.tsistema_integrado
    OWNER TO postgres;

    CREATE TABLE ssom.ttipo_auditoria (
    id_tipo_auditoria SERIAL,
    tipo_auditoria VARCHAR(100) NOT NULL,
    codigo_tpo_aom VARCHAR(20),
    descrip_tauditoria TEXT,
    CONSTRAINT ttipo_auditoria_codigo_tpo_aom_key UNIQUE(codigo_tpo_aom),
    CONSTRAINT ttipo_auditoria_pkey PRIMARY KEY(id_tipo_auditoria)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.ttipo_auditoria
    OWNER TO postgres;

    CREATE TABLE ssom.ttipo_parametro (
    id_tipo_parametro SERIAL,
    tipo_parametro VARCHAR(200) NOT NULL,
    descrip_parametro TEXT,
    CONSTRAINT ttipo_parametro_pkey PRIMARY KEY(id_tipo_parametro),
    CONSTRAINT ttipo_parametro_tipo_parametro_key UNIQUE(tipo_parametro)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.ttipo_parametro
    OWNER TO postgres;

    CREATE TABLE ssom.ttipo_ro (
    id_tipo_ro SERIAL,
    tipo_ro VARCHAR(60) NOT NULL,
    desc_tipo_ro TEXT,
    CONSTRAINT ttipo_ro_pkey PRIMARY KEY(id_tipo_ro),
    CONSTRAINT ttipo_ro_tipo_ro_key UNIQUE(tipo_ro)
    ) INHERITS (pxp.tbase)
    WITH (oids = false);

    ALTER TABLE ssom.ttipo_ro
    OWNER TO postgres;
/***********************************F-SCP-MCCH-SSOM-0-26/12/2019*****************************************/







