CREATE OR REPLACE FUNCTION ssom.ft_accion_propuesta_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_accion_propuesta_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.taccion_propuesta'
 AUTOR: 		 (szambrana)
 FECHA:	        04-07-2019 22:32:50
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 22:32:50								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.taccion_propuesta'
 #3				04-08-2020 19:53:16								Refactorización No Conformidad
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_accion_propuesta_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_ACCPRO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 22:32:50
	***********************************/

	if(p_transaccion='SSOM_ACCPRO_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						accpro.id_ap,
						accpro.obs_resp_area,
						accpro.descripcion_ap,
						accpro.id_parametro,
						accpro.id_funcionario,
						accpro.descrip_causa_nc,
						accpro.estado_reg,
						accpro.efectividad_cumpl_ap,
						accpro.fecha_fin_ap,
						accpro.obs_auditor_consultor,
						accpro.id_nc,
						accpro.fecha_inicio_ap,
						accpro.id_usuario_ai,
						accpro.id_usuario_reg,
						accpro.usuario_ai,
						accpro.fecha_reg,
						accpro.id_usuario_mod,
						accpro.fecha_mod,
			    		accpro.id_proceso_wf,	--integrar con wf new
						accpro.id_estado_wf, 	--integrar con wf new
						accpro.nro_tramite, 	--integrar con wf new
						accpro.estado_wf, 		--integrar con wf new
                        accpro.codigo_ap,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        param.valor_parametro,
                        ofunc.desc_funcionario1 as funcionario_name,
                        (select count(*)
                               from unnest(id_tipo_estado_wfs) elemento
                               where elemento = ew.id_tipo_estado)::integer  as contador_estados,
                        accpro.revisar,
                        accpro.rechazar,
                        accpro.implementar,
                        noc.nro_tramite as nro_tramite_no,
                        noc.descrip_nc,
                        uon.nombre_unidad as area_noc,
						funn.desc_funcionario1 as funcionario_noc,
                        om.id_aom,
                        om.nombre_aom1 ||'' ''|| om.nro_tramite_wf as auditoria,
                        tp.etapa as nombre_estado
						from ssom.taccion_propuesta accpro
						inner join segu.tusuario usu1 on usu1.id_usuario = accpro.id_usuario_reg
                        inner join ssom.tno_conformidad noc on noc.id_nc = accpro.id_nc
                        inner join ssom.tauditoria_oportunidad_mejora om on om.id_aom = noc.id_aom
                         inner join wf.testado_wf es on es.id_estado_wf = accpro.id_estado_wf
                        inner join wf.ttipo_estado tp on tp.id_tipo_estado = es.id_tipo_estado
						left join segu.tusuario usu2 on usu2.id_usuario = accpro.id_usuario_mod
                        left join ssom.tparametro param on param.id_parametro = accpro.id_parametro
                        left join orga.vfuncionario_cargo ofunc on ofunc.id_funcionario = accpro.id_funcionario
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = accpro.id_proceso_wf  	--borrar
                        left join wf.testado_wf ew on ew.id_estado_wf = accpro.id_estado_wf 		--para integrar con nuevo wf
				        left join orga.tuo uon on uon.id_uo = noc.id_uo
                        left join orga.vfuncionario funn on funn.id_funcionario = noc.id_funcionario_nc
                        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
            raise notice '%',v_consulta;
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_ACCPRO_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 22:32:50
	***********************************/

	elsif(p_transaccion='SSOM_ACCPRO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_ap)
					    from ssom.taccion_propuesta accpro
					    inner join segu.tusuario usu1 on usu1.id_usuario = accpro.id_usuario_reg
                        inner join ssom.tno_conformidad noc on noc.id_nc = accpro.id_nc
                        inner join ssom.tauditoria_oportunidad_mejora om on om.id_aom = noc.id_aom
                         inner join wf.testado_wf es on es.id_estado_wf = accpro.id_estado_wf
                        inner join wf.ttipo_estado tp on tp.id_tipo_estado = es.id_tipo_estado
						left join segu.tusuario usu2 on usu2.id_usuario = accpro.id_usuario_mod
                        left join ssom.tparametro param on param.id_parametro = accpro.id_parametro
                        join orga.vfuncionario_cargo ofunc on ofunc.id_funcionario = accpro.id_funcionario
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = accpro.id_proceso_wf  	--borrar
                        left join wf.testado_wf ew on ew.id_estado_wf = accpro.id_estado_wf 		--para integrar con nuevo wf
                        left join orga.tuo uon on uon.id_uo = noc.id_uo
                        left join orga.vfuncionario funn on funn.id_funcionario = noc.id_funcionario_nc
                        where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	else

		raise exception 'Transaccion inexistente';

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
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.ft_accion_propuesta_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;