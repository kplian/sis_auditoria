--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.f_get_funcionario_responsable (
  p_id_usuario integer,
  p_id_estado integer,
  p_fecha date = now(),
  p_id_estado_wf integer = NULL::integer,
  p_count boolean = false,
  p_limit integer = 1,
  p_start integer = 0,
  p_filtro varchar = '0=0'::character varying
)
RETURNS SETOF record AS
$body$
  /**************************************************************************
   SISTEMA: Sistema de Seguimiento de Oportunidades de Mejoras
  ***************************************************************************
   SCRIPT: 		ssom.f_get_funcionario_responsable
   DESCRIPCIÓN:	Lista los fucionarios por Departamento seleccionado
   AUTOR: 		MCCH
   FECHA:			09/12/2019
   COMENTARIOS:
  ***************************************************************************
   HISTORIA DE MODIFICACIONES:

   DESCRIPCIÓN:
   AUTOR:
   FECHA:

  ***************************************************************************/


DECLARE

  g_registros  		record;
  v_consulta 			varchar;
  v_nombre_funcion 	varchar;
  v_resp 				varchar;

  v_record			record;

  /*v_id_funcionario   	integer;
  v_record			record;
  v_id_uo				integer;*/

  /* v_id_estado_wf		integer;
   v_id_proceso_wf		integer;
   v_id_tipo_proceso	integer;
   v_id_proceso_macro	integer;
   v_id_subistema		integer;*/


BEGIN

  v_nombre_funcion ='ssom.f_get_funcionario_responsable';

  --Recuperamos id_subsistema a partir de id_estado_wf

  select
    aom.id_aom,
    aom.id_uo,
    aom.id_funcionario
    into
      v_record
  from ssom.tauditoria_oportunidad_mejora aom
  where aom.id_estado_wf =  p_id_estado_wf;

  --VERIFICAMOS SI HAY O NO UNA UO ADICIONAL
  /*if v_record.id_uo_adicional is null then
      v_id_uo = v_record.id_uo;
     else
        v_id_uo = v_record.id_uo_adicional;
     end if;*/


  --raise EXCEPTION 'holllllllllllllaaaaaaaaaaaaaaa %', p_id_estado_wf;

  if not p_count then
    begin
      --raise exception 'hollllllllllll % %',v_record.id_aom,v_record.id_funcionario;
      v_consulta:='select
                        vfcx.id_funcionario
                        ,vfcx.desc_funcionario1 as desc_funcionario
                        ,''''::text  as desc_funcionario_cargo
                        ,1 as prioridad
                        from ssom.tauditoria_oportunidad_mejora aom
                        join orga.vfuncionario_cargo_xtra vfcx on aom.id_funcionario = vfcx.id_funcionario
                        where aom.id_aom = '||v_record.id_aom||' and aom.estado_reg = ''activo'' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and '||p_filtro||'
                        limit '|| p_limit::varchar||' offset '||p_start::varchar ;

      FOR g_registros in execute (v_consulta)LOOP
        RETURN NEXT g_registros;
      END LOOP;

    end;

  else
    v_consulta:='select count(vfcx.id_funcionario)
                        from ssom.tauditoria_oportunidad_mejora aom
                        join orga.vfuncionario_cargo_xtra vfcx on aom.id_funcionario = vfcx.id_funcionario
                        where aom.id_aom = '||v_record.id_aom||' and aom.estado_reg = ''activo'' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and '||p_filtro||'
                        limit '|| p_limit::varchar||' offset '||p_start::varchar ;

    raise notice '%', v_consulta;

    FOR g_registros in execute (v_consulta)LOOP
      RETURN NEXT g_registros;
    END LOOP;

  end if;


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
  COST 100 ROWS 1000;