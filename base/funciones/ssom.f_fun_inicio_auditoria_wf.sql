CREATE OR REPLACE FUNCTION ssom.f_fun_inicio_auditoria_wf (
  p_id_aom integer,
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai varchar,
  p_id_estado_wf integer,
  p_id_proceso_wf integer,
  p_codigo_estado varchar,
  p_estado_anterior varchar = 'no'::character varying
)
RETURNS boolean AS
$body$
/**************************************************************************
 SISTEMA:       Sistema
 FUNCION:       pro.f_fun_inicio_auditoria_wf

 DESCRIPCION:   Actualiza los estados en proceso WF
 AUTOR:         MCCH
 FECHA:         18/09/2019
 COMENTARIOS:

 ***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/
DECLARE

    v_nombre_funcion        text;
    v_resp                  varchar;
    v_record                record;

BEGIN

    --Identificación del nombre de la función
    v_nombre_funcion = 'ssom.f_fun_inicio_auditoria_wf';

	 select aom.id_aom,
            aom.estado_wf,
            aom.id_estado_wf,
            ewf.id_funcionario,
            aom.lugar,
            aom.id_tnorma,
            aom.id_tobjeto
            into v_record
        from ssom.tauditoria_oportunidad_mejora aom
        inner join wf.testado_wf ewf on ewf.id_estado_wf =  aom.id_estado_wf
        where aom.id_proceso_wf = p_id_proceso_wf;

        if (p_codigo_estado = 'planificacion') then

         if (v_record.lugar is null or v_record.lugar = '') then
            raise exception 'Campo lugar no fue completado en formulario.';
          end if;

         if (v_record.id_tnorma is null) then
         	raise exception 'Falta asigna una norma a la auditoria';
         end if;

         if (v_record.id_tobjeto is null ) then
         	raise exception 'Falta asignar un objetivo a la auditoria';
         end if;

         update ssom.tauditoria_oportunidad_mejora set
          id_estado_wf = p_id_estado_wf,
          estado_wf = p_codigo_estado,
          id_usuario_mod = p_id_usuario,
          id_usuario_ai = p_id_usuario_ai,
          usuario_ai = p_usuario_ai,
          fecha_mod = now()
          where id_aom = v_record.id_aom;



        elsif (p_codigo_estado = 'vbplanificacion') then

            if not exists (select 1
                      from ssom.tauditoria_proceso
                      where id_aom = v_record.id_aom) then
                raise exception 'Necesario Asignar al menos un Proceso Auditable a la Auditoria.';
            end if;

            if not exists ( select 1
                            from ssom.tequipo_responsable er
                            inner join ssom.tparametro pa on pa.id_parametro = er.id_parametro
                            where er.id_aom = v_record.id_aom and pa.codigo_parametro <> 'RESP')then
                raise exception 'Es necesario Asignar un Auiditor Lider/Responsable y al menos mas un Auditor que no sea Responsable de la Auditoria.';
            end if;

            if not exists (select 1
                            from ssom.tauditoria_npn
                            where id_aom = v_record.id_aom)then
                raise exception 'Es necesario Asignar un Puntos de Norma a la Auditoria.';
            end if;

            if not exists (select 1
                           from ssom.tcronograma
                           where id_aom = v_record.id_aom)then
                raise exception 'Es necesario agregar actividad(es) a Cronograma para el proceso de la Auditoria.';
            end if;


         update ssom.tauditoria_oportunidad_mejora set
          id_estado_wf = p_id_estado_wf,
          estado_wf = p_codigo_estado,
          id_usuario_mod = p_id_usuario,
          id_usuario_ai = p_id_usuario_ai,
          usuario_ai = p_usuario_ai,
          fecha_mod = now()
          where id_aom = v_record.id_aom;

        else
 			   update ssom.tauditoria_oportunidad_mejora set
                id_estado_wf = p_id_estado_wf,
                estado_wf = p_codigo_estado,
                id_usuario_mod = p_id_usuario,
                id_usuario_ai = p_id_usuario_ai,
                usuario_ai = p_usuario_ai,
                fecha_mod = now()
                where id_aom = v_record.id_aom;
        end if;

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

ALTER FUNCTION ssom.f_fun_inicio_auditoria_wf (p_id_aom integer, p_id_usuario integer, p_id_usuario_ai integer, p_usuario_ai varchar, p_id_estado_wf integer, p_id_proceso_wf integer, p_codigo_estado varchar, p_estado_anterior varchar)
  OWNER TO postgres;