CREATE OR REPLACE FUNCTION ssom.f_cambiar_estado (
  p_id_proceso integer,
  p_id_estado integer,
  p_id_usuario integer
)
RETURNS boolean AS
$body$
/**************************************************************************
 SISTEMA:       Sistema
 FUNCION:       pro.f_fun_inicio_auditoria_wf

 DESCRIPCION:   Actualiza los estados en proceso WF
 AUTOR:         MMV
 FECHA:
 COMENTARIOS:

***************************************************************************
 HISTORIAL DE MODIFICACIONES:
 #ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 19:53:16								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tno_conformidad'
 #3				04-08-2020 19:53:16								Refactorización No Conformidad
 ***************************************************************************/
DECLARE

    v_nombre_funcion        text;
    v_resp                  varchar;
    v_registro_estado       record;
    v_resultado				boolean;

    va_id_tipo_estado 	  		integer [];
    va_codigo_estado 		  	varchar [];
    va_disparador 	     	 	varchar [];
    va_regla 				  	varchar [];
    va_prioridad 		      	integer [];

      v_acceso_directo        varchar;
      v_clase                 varchar;
      v_codigo_estados        varchar;
      v_parametros_ad         varchar;
      v_tipo_noti             varchar;
      v_titulo                varchar;

      v_id_estado_actual      integer;

BEGIN

    --Identificación del nombre de la función
    v_nombre_funcion = 'ssom.f_cambiar_estado';

    	select
            pw.id_proceso_wf,
            ew.id_estado_wf,
            te.codigo,
            pw.fecha_ini,
            te.id_tipo_estado,
            te.pedir_obs,
            pw.nro_tramite
          into
            v_registro_estado
          from wf.tproceso_wf pw
          inner join wf.testado_wf ew  on ew.id_proceso_wf = pw.id_proceso_wf and ew.estado_reg = 'activo'
          inner join wf.ttipo_estado te on ew.id_tipo_estado = te.id_tipo_estado
          where pw.id_proceso_wf = p_id_proceso;

          select ps_id_tipo_estado,
                 ps_codigo_estado,
                 ps_disparador,
                 ps_regla,
                 ps_prioridad
                 into
                    va_id_tipo_estado,
                    va_codigo_estado,
                    va_disparador,
                    va_regla,
                    va_prioridad
                from wf.f_obtener_estado_wf(
                v_registro_estado.id_proceso_wf,
                 null,
                 v_registro_estado.id_tipo_estado,
                 'siguiente',
                 p_id_usuario);

            v_acceso_directo = '';
            v_clase = '';
            v_parametros_ad = '';
            v_tipo_noti = 'notificacion';
            v_titulo  = 'Aprobado';

            v_id_estado_actual = wf.f_registra_estado_wf(  va_id_tipo_estado[1]::integer,
                                                            null,--v_parametros.id_funcionario_wf,
                                                            v_registro_estado.id_estado_wf,
                                                            v_registro_estado.id_proceso_wf,
                                                            p_id_usuario,
                                                            null,--v_parametros._id_usuario_ai,
                                                            null,--v_parametros._nombre_usuario_ai,
                                                            null,--v_id_depto,                       --depto del estado anterior
                                                            'Aprobado', --obt
                                                            v_acceso_directo,
                                                            v_clase,
                                                            v_parametros_ad,
                                                            v_tipo_noti,
                                                            v_titulo);


        update ssom.tauditoria_oportunidad_mejora set
        id_estado_wf =  v_id_estado_actual,
        estado_wf = va_codigo_estado[1],
        id_usuario_mod=p_id_usuario,
        fecha_mod=now()
        where id_proceso_wf  =  p_id_proceso;

    return true;
EXCEPTION

    WHEN OTHERS THEN

        v_resp = '';
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
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.f_cambiar_estado (p_id_proceso integer, p_id_estado integer, p_id_usuario integer)
  OWNER TO dbaamamani;