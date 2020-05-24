CREATE OR REPLACE FUNCTION ssom.f_list_process_wf_audit_rfe (
  p_fecha_inicio date,
  p_fecha_fin date,
  p_estado varchar,
  p_gestion integer
)
  RETURNS TABLE (
                  fill_id_proceso_wf integer,
                  fill_fecha_reg date,
                  fill_estado_reg varchar,
                  fill_id_estado_wf integer,
                  fill_id_estado_anterior integer,
                  fill_id_tipo_estado integer,
                  fill_id_funcionario integer,
                  fill_id_depto integer,
                  fill_obs varchar,
                  fill_codigo varchar,
                  fill_nombre_estado varchar
                ) AS
$body$
DECLARE
  /**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.f_list_process_wf_audit_rfe
   DESCRIPCION:   Funcion que devuelve una tabla de estados de una Auditoria, la consultas esta relacionada con las tablas 'wf.tproceso_macro,wf.ttipo_proceso,wf.testado_wf,wf.tproceso_wf'
   AUTOR: 		 (max.camacho)
   FECHA:	        05-10-2019 14:31:07
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				05-10-2019 14:31:07								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'wf.tproceso_macro'
   #
   ***************************************************************************/
  v_nombre_funcion   				text;
  v_resp							varchar;
  v_record						record;
  v_record_aux					record;

  v_id_proceso_macro 				integer;
  v_codigo_pm 					varchar;
  v_nombre_pm 					varchar;
  v_id_tipo_proceso 				integer;
  v_codigo_tp 					varchar;
  v_nombre_tp 					varchar;

  v_bandera						boolean = false;
  v_id_ai							integer;
  v_id_proceso_wf					integer;

BEGIN

  --ewf.id_proceso_wf,ewf.fecha_reg ,ewf.fecha_mod, ewf.estado_reg, ewf.id_estado_wf, ewf.id_estado_anterior, ewf.id_tipo_estado, ewf.id_funcionario, ewf.id_depto,ewf.tipo_cambio ,ewf.obs, te.codigo, te.nombre_estado
  CREATE TEMPORARY TABLE tmp_estado_auditoria (
                                                id_proceso_wf_aux integer
    ,fecha_reg_aux date
    ,estado_reg_aux	varchar
    ,id_estado_wf_aux integer
    ,id_estado_anterior_aux integer
    ,id_tipo_estado_aux integer
    ,id_funcionario_aux integer
    ,id_depto_aux integer
    ,obs_aux varchar
    ,codigo_aux varchar
    ,nombre_estado_aux varchar )ON COMMIT DROP;

  select
    pm.id_proceso_macro
       ,pm.codigo
       ,pm.nombre
       ,tp.id_tipo_proceso
       ,tp.codigo
       ,tp.nombre
    into
      v_id_proceso_macro
      ,v_codigo_pm
      ,v_nombre_pm
      ,v_id_tipo_proceso
      ,v_codigo_tp
      ,v_nombre_tp
  from wf.tproceso_macro pm
         join wf.ttipo_proceso tp on pm.id_proceso_macro = tp.id_proceso_macro
  where pm.codigo = 'SAOM' and pm.estado_reg = 'activo' and pm.inicio = 'si' ;
  --raise exception 'entra';

  /*select te.id_tipo_estado, te.id_tipo_proceso, te.codigo, te.nombre_estado
  from wf.ttipo_estado te
  where te.id_tipo_proceso = v_id_tipo_proceso and te.estado_reg = 'activo'
  order by te.id_tipo_estado asc*/

  /*select ge.id_gestion into v_id_gestion
    from param.tgestion ge
    where ge.gestion = p_gestion;*/


  for v_record in (select ewf.id_proceso_wf
                        ,ewf.fecha_reg
                        ,ewf.estado_reg
                        ,ewf.id_estado_wf
                        ,ewf.id_estado_anterior
                        ,ewf.id_tipo_estado
                        ,ewf.id_funcionario
                        ,ewf.id_depto
                        ,ewf.obs
                        ,ter.codigo
                        ,ter.nombre_estado
                   from wf.testado_wf ewf
                          join wf.tproceso_wf pwf on ewf.id_proceso_wf = pwf.id_proceso_wf
                          join (select te.id_tipo_estado as id_tipo_estado, te.id_tipo_proceso, te.codigo, te.nombre_estado
                                from wf.ttipo_estado te
                                where te.id_tipo_proceso = v_id_tipo_proceso and te.estado_reg = 'activo'
                                order by te.id_tipo_estado asc) as ter on ewf.id_tipo_estado = ter.id_tipo_estado
                   where ter.codigo = p_estado and (ewf.fecha_reg between p_fecha_inicio and p_fecha_fin)
                     --where ter.codigo = 'programado' and (ewf.fecha_reg between p_fecha_inicio and p_fecha_fin)
                     --group by ewf.id_proceso_wf, ewf.id_tipo_estado
                   order by ewf.fecha_reg asc) loop

    if (v_bandera is false ) then

      begin
        insert into tmp_estado_auditoria(
                                         id_proceso_wf_aux
                                        ,fecha_reg_aux
                                        ,estado_reg_aux
                                        ,id_estado_wf_aux
                                        ,id_estado_anterior_aux
                                        ,id_tipo_estado_aux
                                        ,id_funcionario_aux
                                        ,id_depto_aux
                                        ,obs_aux
                                        ,codigo_aux
                                        ,nombre_estado_aux
        )values(
                 v_record.id_proceso_wf
               ,v_record.fecha_reg
               ,v_record.estado_reg
               ,v_record.id_estado_wf
               ,v_record.id_estado_anterior
               ,v_record.id_tipo_estado
               ,v_record.id_funcionario
               ,v_record.id_depto
               ,v_record.obs
               ,v_record.codigo
               ,v_record.nombre_estado
               );
        v_id_proceso_wf = v_record.id_proceso_wf;
        v_bandera = true;

      end;

    elsif( v_bandera is true ) then

      begin
        v_id_ai =  (select id_proceso_wf_aux from tmp_estado_auditoria where id_proceso_wf_aux = v_record.id_proceso_wf);
        --raise EXCEPTION 'mmmmmmm %', v_id_ai;

        if ( v_record.id_proceso_wf <> v_id_proceso_wf and v_id_ai is NULL ) then
          --raise notice 'holas id_proceso % %',v_id_tipo_proceso, v_record.id_proceso_wf;
          insert into tmp_estado_auditoria(
                                           id_proceso_wf_aux
                                          ,fecha_reg_aux
                                          ,estado_reg_aux
                                          ,id_estado_wf_aux
                                          ,id_estado_anterior_aux
                                          ,id_tipo_estado_aux
                                          ,id_funcionario_aux
                                          ,id_depto_aux
                                          ,obs_aux
                                          ,codigo_aux
                                          ,nombre_estado_aux
          )values(
                   v_record.id_proceso_wf
                 ,v_record.fecha_reg
                 ,v_record.estado_reg
                 ,v_record.id_estado_wf
                 ,v_record.id_estado_anterior
                 ,v_record.id_tipo_estado
                 ,v_record.id_funcionario
                 ,v_record.id_depto
                 ,v_record.obs
                 ,v_record.codigo
                 ,v_record.nombre_estado
                 );

          v_id_proceso_wf = v_record.id_proceso_wf;
          --v_bandera = true;
          --raise EXCEPTION 'llega';

        end if;

      end;

    end if;


  end loop;

  --ETURN QUERY  select * from tmp_estado_auditoria;
  RETURN QUERY SELECT
                 id_proceso_wf_aux
                    ,fecha_reg_aux
                    ,estado_reg_aux
                    ,id_estado_wf_aux
                    ,id_estado_anterior_aux
                    ,id_tipo_estado_aux
                    ,id_funcionario_aux
                    ,id_depto_aux
                    ,obs_aux
                    ,codigo_aux
                    ,nombre_estado_aux
               FROM tmp_estado_auditoria;


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