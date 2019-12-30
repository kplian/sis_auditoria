--------------- SQL ---------------

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

    v_nombre_funcion                text;
    v_resp                          varchar;
    --v_mensaje                       varchar;
    --v_registros                     record;
    v_rec                           record;

BEGIN

    --Identificación del nombre de la función
    v_nombre_funcion = 'ssom.f_fun_inicio_auditoria_wf';

    --raise exception ''entra'';
    ----------------------------------------------
    --Obtención de datos de la cuenta documentada
    ----------------------------------------------
    select
        aom.id_aom,
        aom.estado_wf,
        aom.id_estado_wf,
        ewf.id_funcionario
        into v_rec
    from ssom.tauditoria_oportunidad_mejora aom
    inner join wf.testado_wf ewf on ewf.id_estado_wf =  aom.id_estado_wf
    where aom.id_aom = p_id_aom;

    --Actualización del estado de la solicitud
    update ssom.tauditoria_oportunidad_mejora set
    id_estado_wf    = p_id_estado_wf,
    estado_wf          = p_codigo_estado,
    id_usuario_mod  = p_id_usuario,
    id_usuario_ai   = p_id_usuario_ai,
    usuario_ai      = p_usuario_ai,
    fecha_mod       = now()
    where id_aom = p_id_aom;

    --Respuesta
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
COST 100;