--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.f_get_funcionarios_x_uoi (
  p_id_usuario integer,
  p_id_tipo_estado integer,
  p_fecha date = now(),
  p_id_estado_wf integer = NULL::integer,
  p_count boolean = false,
  p_limit integer = 1,
  p_start integer = 0,
  p_filtro varchar = '0=0'::character varying
)
  RETURNS SETOF record AS'
/**************************************************************************
 SISTEMA
***************************************************************************
 SCRIPT: 		ssom.f_get_funcionario_x_uoi
 DESCRIPCIÓN:	Lista los fucionarios jefes superiores del funcionario
 AUTOR: 		MCCH
 FECHA:			09/12/2019
 COMENTARIOS:
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS PROPIOS DE UNA FUNCION PARA wf
/*
  p_id_usuario integer,                                identificador del actual usuario de sistema
  p_id_tipo_estado integer,                            idnetificador del tipo estado del que se quiere obtener el listado de funcionario  (se correponde con tipo_estado que le sigue a id_estado_wf proporcionado)
  p_fecha date = now(),                                fecha  --para verificar asginacion de cargo con organigrama
  p_id_estado_wf integer = NULL::integer,              identificador de estado_wf actual en el proceso_wf
  p_count boolean = false,                             si queremos obtener numero de funcionario = true por defecto false
  p_limit integer = 1,                                 los siguiente son parametros para filtrar en la consulta
  p_start integer = 0,
  p_filtro varchar = ''0=0''::character varying

*/

DECLARE

	g_registros  		record;
    v_consulta 			varchar;
    v_nombre_funcion 	varchar;
    v_resp 				varchar;
    v_id_funcionario   	integer;
    v_record			record;
    v_id_uo				integer;

BEGIN

    v_nombre_funcion =''ssom.f_get_funcionarios_x_uoi'';

    --recuperamos la la obligacion de pago a partir del id_estado_wf en el proceso caja

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

	--raise exception ''%'',p_count;

    IF not p_count then
    	begin
           v_consulta:=''WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                                 SELECT
                                    euo.id_uo_hijo,	--id
                                    id_uo_padre		---padre
                                 FROM orga.testructura_uo euo
                                 WHERE euo.id_uo_hijo = ''||v_record.id_uo||'' and euo.estado_reg = ''''activo''''
                                 UNION
                                    SELECT
                                       e.id_uo_hijo,
                                       e.id_uo_padre
                                    FROM
                                       orga.testructura_uo e
                                    INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''''activo''''
                              )
                              SELECT
                                  vfc.id_funcionario,
                                  vfc.desc_funcionario1 as desc_funcionario,
                                  ''''''''::text  as desc_funcionario_cargo,
                                  1 as prioridad
                              FROM uo_mas_subordinados ss
                              inner join orga.vfuncionario_cargo vfc on ss.id_uo_hijo = vfc.id_uo
                              where( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date) and ''||p_filtro||''
                              limit ''|| p_limit::varchar||'' offset ''||p_start::varchar;

           FOR g_registros in execute (v_consulta)LOOP
                   RETURN NEXT g_registros;
           END LOOP;

    	end;

    ELSE
       v_consulta=''WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                         SELECT
                            euo.id_uo_hijo,--id
                            id_uo_padre---padre
                         FROM orga.testructura_uo euo
                         WHERE euo.id_uo_hijo = ''||v_record.id_uo||'' and euo.estado_reg = ''''activo''''
                         UNION
                            SELECT
                               e.id_uo_hijo,
                               e.id_uo_padre
                            FROM
                               orga.testructura_uo e
                            INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''''activo''''
                      )
                      SELECT   count(vfc.id_funcionario)
                      FROM uo_mas_subordinados ss
                      inner join orga.vfuncionario_cargo vfc on ss.id_uo_hijo = vfc.id_uo
                    where( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date) and  ''||p_filtro;

          raise notice ''%'', v_consulta;


         FOR g_registros in execute (v_consulta)LOOP
           RETURN NEXT g_registros;
         END LOOP;


    END IF;



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