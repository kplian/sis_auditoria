CREATE OR REPLACE FUNCTION ssom.f_listar_gerente_uo_ap (
  p_id_usuario integer,
  p_id_tipo_estado integer,
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
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
***************************************************************************
 SCRIPT: 		ssom.f_listar_funcionarios_x_uo_ap
 DESCRIPCIÓN:	Lista los fucionarios jefes superiores del funcionario
 AUTOR: 		SAZP
 FECHA:			04/12/2019
 COMENTARIOS:
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/

-------------------------
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
  p_filtro varchar = '0=0'::character varying
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
  
    v_nombre_funcion ='ssom.f_listar_gerente_uo_ap';

	select no.id_uo , no.id_uo_adicional into v_record
    from ssom.taccion_propuesta ac 
    inner join ssom.tno_conformidad  no on no.id_nc = ac.id_nc
    where ac.id_estado_wf = p_id_estado_wf;

	/*select nc.id_uo, nc.id_uo_adicional into v_record
    from ssom.tno_conformidad nc
    where nc.id_estado_wf =  p_id_estado_wf;
*/
	--VERIFICAMOS SI HAY O NO UNA UO ADICIONAL
	if v_record.id_uo_adicional is null then
	   v_id_uo = v_record.id_uo;
     else
        v_id_uo = v_record.id_uo_adicional;
     end if;
    
    IF not p_count then
                 v_consulta:='select   fu.id_funcionario,
                                       fu.desc_funcionario1 as desc_funcionario,
                                       ''''::text  as desc_funcionario_cargo,
                                       1 as prioridad
                              from orga.tuo ou
                              inner join orga.tuo_funcionario fuo on fuo.id_uo = ou.id_uo
                              inner join orga.vfuncionario fu on fu.id_funcionario = fuo.id_funcionario
                              where ou.gerencia = ''si''and fuo.id_uo = orga.f_get_uo_gerencia ('||v_id_uo||',null,null) and '||p_filtro||'
                              limit '|| p_limit::varchar||' offset '||p_start::varchar;

                 FOR g_registros in execute (v_consulta)LOOP
                         RETURN NEXT g_registros;
                 END LOOP;

    ELSE
                  v_consulta='select  count( fu.id_funcionario)
                                      from orga.tuo ou
                                      inner join orga.tuo_funcionario fuo on fuo.id_uo = ou.id_uo
                                      inner join orga.vfuncionario fu on fu.id_funcionario = fuo.id_funcionario
                                      where ou.gerencia = ''si''and fuo.id_uo = orga.f_get_uo_gerencia ('||v_id_uo||',null,null) and  '||p_filtro;
					
                    raise notice '%', v_consulta;
                    
                    
                   FOR g_registros in execute (v_consulta)LOOP
                     RETURN NEXT g_registros;
                   END LOOP;


    END IF;



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