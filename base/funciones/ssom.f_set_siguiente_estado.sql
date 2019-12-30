CREATE OR REPLACE FUNCTION ssom.f_set_siguiente_estado (
  p_id_aom integer,
  p_id_funcionario integer,
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai integer
)
RETURNS void AS
$body$
DECLARE
  /**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.f_set_siguiente_estado
   DESCRIPCION:   Funcion que cambia a siguiente estado de la Auditoria, la consultas esta relacionada con la tabla 'ssom.tauditoria_oportunidad_mejora'
   AUTOR: 		 (max.camacho)
   FECHA:	        01-11-2019 14:31:07
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				01-11-2019 14:31:07								Funcion que cambia el estado de una Auditoria, la consulta esta relacionada con la tabla 'ssom.tauditoria_oportunidad_mejora'
   #
   ***************************************************************************/
  v_nombre_funcion   	 	text;
  v_resp    			 	varchar;
  v_mensaje 			 	varchar;

  v_parametros           	record;

  v_id_estado_actual  	integer;

  va_id_tipo_estado 		integer[];
  va_codigo_estado 		varchar[];
  va_disparador    		varchar[];
  va_regla         		varchar[];
  va_prioridad     		integer[];

  v_id_cobro_simple       varchar;


  p_id_usuario  			integer;
  p_id_usuario_ai 		integer;
  p_usuario_ai 			varchar;

  v_registros				record;

BEGIN

  v_nombre_funcion = 'ssom.f_set_siguiente_estado_aom';

  --v_parametros = pxp.f_get_record(p_tabla);
  v_resp	= 'exito';

  ---------****************

  select
    aom.id_aom,
    aom.id_proceso_wf,
    aom.id_estado_wf,
    aom.estado_wf
    INTO
      v_registros
  from ssom.tauditoria_oportunidad_mejora aom
  where aom.id_aom = p_id_aom ;


  SELECT
    *
    into
      va_id_tipo_estado,
      va_codigo_estado,
      va_disparador,
      va_regla,
      va_prioridad
  FROM wf.f_obtener_estado_wf(v_registros.id_proceso_wf, v_registros.id_estado_wf,NULL,'siguiente');


  --raise exception '--  % ,  % ,% ',v_id_proceso_wf,v_id_estado_wf,va_codigo_estado;


  IF va_codigo_estado[2] is not null THEN
    raise exception 'El proceso de WF esta mal parametrizado,  solo admite un estado siguiente para el estado: %', v_registros.estado_wf;
  END IF;

  IF va_codigo_estado[1] is  null THEN
    raise exception 'El proceso de WF esta mal parametrizado, no se encuentra el estado siguiente,  para el estado: %', v_registros.estado_wf;
  END IF;

  p_id_usuario=1;
  p_id_usuario_ai = 1;
  p_usuario_ai = null;

  --estado siguiente
  v_id_estado_actual =  wf.f_registra_estado_wf(va_id_tipo_estado[1],
    --NULL,
                                                p_id_funcionario,
                                                v_registros.id_estado_wf,
                                                v_registros.id_proceso_wf,
                                                p_id_usuario,
                                                p_id_usuario_ai, -- id_usuario_ai
                                                p_usuario_ai, -- usuario_ai
                                                null,
                                                'Auditoria Planificada');

  --Actualiza estado en la Auditoria


  update ssom.tauditoria_oportunidad_mejora set
                                              id_estado_wf =  v_id_estado_actual,
                                              estado_wf = va_codigo_estado[1],
                                              id_usuario_mod=p_id_usuario,
                                              fecha_mod=now(),
                                              id_usuario_ai = p_id_usuario_ai,
                                              usuario_ai = p_usuario_ai
  where id_aom  = v_registros.id_aom;


  --RETURN   v_resp;

  EXCEPTION

  WHEN OTHERS THEN
    v_resp='';
    v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
    v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
    v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
    raise exception '%',v_resp;
END;
$body$
  LANGUAGE 'plpgsql'
  VOLATILE
  CALLED ON NULL INPUT
  SECURITY INVOKER
  COST 100;