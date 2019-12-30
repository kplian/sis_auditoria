--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.f_listar_funcionarios_x_depto (
  p_id_usuario integer,
  p_id_tipo_estado integer,
  p_fecha date = now(),
  p_id_estado_wf integer = NULL::integer,
  p_count boolean = false,
  p_limit integer = 1,
  p_start integer = 0,
  p_filtro varchar = '0=0'::character varying,
  p_id_depto integer = 0
)
RETURNS SETOF record AS'
/**************************************************************************
 SISTEMA: Sistema de Seguimiento de Oportunidades de Mejoras
***************************************************************************
 SCRIPT: 		ssom.f_listar_funcionarios_x_depto
 DESCRIPCIÓN:	Lista los fucionarios por Departamento seleccionado
 AUTOR: 		MCCH
 FECHA:			05/12/2019
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

    /*v_id_funcionario   	integer;
    v_record			record;
    v_id_uo				integer;*/

    /*v_id_estado_wf		integer;
    v_id_proceso_wf		integer;
    v_id_tipo_proceso	integer;
    v_id_proceso_macro	integer;
    v_id_subistema		integer;*/


BEGIN

    v_nombre_funcion =''ssom.f_listar_funcionarios_x_depto'';

    --Recuperamos id_subsistema a partir de id_estado_wf

    /*select
    	ewf.id_estado_wf
        ,ewf.id_proceso_wf
        ,tpwf.id_tipo_proceso
        ,pmwf.id_proceso_macro
        ,pmwf.id_subsistema
    into
    	v_id_estado_wf
        ,v_id_proceso_wf
        ,v_id_tipo_proceso
        ,v_id_proceso_macro
        ,v_id_subistema
    from wf.testado_wf ewf
    join wf.tproceso_wf pwf on ewf.id_proceso_wf = pwf.id_proceso_wf
    join wf.ttipo_proceso tpwf on pwf.id_tipo_proceso = tpwf.id_tipo_proceso
    join wf.tproceso_macro pmwf on tpwf.id_proceso_macro = pmwf.id_proceso_macro
    where ewf.id_estado_wf = p_id_estado_wf;*/  --458170

    --raise EXCEPTION ''holllllllllllllaaaaaaaaaaaaaaa %'', p_id_depto;

    if not p_count then
    	begin
        	v_consulta:=''select
            			vfcx.id_funcionario
                        ,vfcx.desc_funcionario1 as desc_funcionario
                        ,''''''''::text  as desc_funcionario_cargo
                        ,1 as prioridad
                        from param.tdepto d
                        join param.tdepto_usuario du on d.id_depto = du.id_depto
                        join segu.tusuario usu on du.id_usuario = usu.id_usuario
                        join orga.vfuncionario_cargo_xtra vfcx on usu.id_persona = vfcx.id_persona
                        where d.id_depto = ''||p_id_depto||'' and du.estado_reg = ''''activo'''' and (vfcx.fecha_asignacion is null or vfcx.fecha_finalizacion >= now()::date) and du.cargo = ''''auxiliar'''' and ''||p_filtro||''
                        limit ''|| p_limit::varchar||'' offset ''||p_start::varchar ;

            FOR g_registros in execute (v_consulta)LOOP
            	RETURN NEXT g_registros;
            END LOOP;

        end;

    else
    	v_consulta:=''select count(vfcx.id_funcionario)
                        from param.tdepto d
                        join param.tdepto_usuario du on d.id_depto = du.id_depto
                        join segu.tusuario usu on du.id_usuario = usu.id_usuario
                        join orga.vfuncionario_cargo_xtra vfcx on usu.id_persona = vfcx.id_persona
                        where d.id_depto = ''||p_id_depto||'' and du.estado_reg = ''''activo'''' and (vfcx.fecha_asignacion is null or vfcx.fecha_finalizacion >= now()::date) and du.cargo = ''''auxiliar'''' and ''||p_filtro||''
                        limit ''||p_limit::varchar||'' offset ''||p_start::varchar ;

        raise notice ''%'', v_consulta;

        FOR g_registros in execute (v_consulta)LOOP
        	RETURN NEXT g_registros;
        END LOOP;

    end if;


EXCEPTION

	WHEN OTHERS THEN
			v_resp='''';
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',SQLERRM);
			v_resp = pxp.f_agrega_clave(v_resp,''codigo_error'',SQLSTATE);
			v_resp = pxp.f_agrega_clave(v_resp,''procedimientos'',v_nombre_funcion);
			raise exception ''%'',v_resp;


END;
'LANGUAGE 'plpgsql'
 VOLATILE
 CALLED ON NULL INPUT
 SECURITY INVOKER
 COST 100 ROWS 1000;