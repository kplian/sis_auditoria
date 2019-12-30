CREATE OR REPLACE FUNCTION ssom.f_procesar_estado (
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai varchar,
  p_id_estado_wf integer,
  p_id_proceso_wf integer,
  p_codigo_estado varchar
)
RETURNS boolean AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.f_procesar_estados_solicitud
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.taccion_propuesta'
 AUTOR: 		SAZP
 FECHA:	        13-09-2019 13:52:11
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION

 ***************************************************************************/
DECLARE
  	v_nombre_funcion   	 			text;
    v_resp    			 			varchar;
    v_mensaje 			 			varchar;
    v_registo						record;
	v_record						record;
    v_id_tipo_aplicacion			integer;
    v_id_mes_trabajo_normal			integer;
    v_id_mes_trabajo_nocturno		integer;
    v_id_mes_trabajo_extra			integer;
    v_sumar_normar					numeric;
    v_ultimo_normal					numeric;
    v_sumar_nocturno				numeric;
    v_ultimo_nocturno				numeric;
    v_sumar_extra					numeric;
    v_ultimo_extra				    numeric;
    v_count							integer; --#4

BEGIN
  v_nombre_funcion = 'ssom.f_procesar_estados_solicitud';
/*
	select 	ap.id_mes_trabajo,
    		ap.id_funcionario,
    		ap.id_periodo
            into
            v_registo
    from ssom.taccion_propuesta ap
    where me.id_proceso_wf = p_id_proceso_wf;*/

  	if p_codigo_estado = 'propuesta' then
		
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'vbpropuesta_responsable' then
    	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'vbpropuesta_auditor' then
    	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'implementada' then    
	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'vbimplementada_responsable' then    
	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'vbimplementada_auditor' then    
    	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
    elsif p_codigo_estado = 'finalizado' then             	
	
		update ssom.taccion_propuesta  set
        id_estado_wf =  p_id_estado_wf,
        estado_wf = p_codigo_estado,
        id_usuario_mod=p_id_usuario,
        id_usuario_ai = p_id_usuario_ai,
        usuario_ai = p_usuario_ai,
        fecha_mod=now()
        where id_proceso_wf = p_id_proceso_wf;
	
   	end if;
   
   
   
   
  return true;
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