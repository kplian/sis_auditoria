CREATE OR REPLACE FUNCTION ssom.ft_auditoria_proceso_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_proceso_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_proceso'
   AUTOR: 		 (max.camacho)
   FECHA:	        25-07-2019 15:51:56
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				25-07-2019 15:51:56								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_proceso'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_proceso_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_AUPC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 15:51:56
	***********************************/

	if(p_transaccion='SSOM_AUPC_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						aupc.id_aproceso,
						aupc.estado_reg,
						aupc.id_aom,
						aupc.id_proceso,
						aupc.ap_valoracion,
						aupc.obs_pcs,
						aupc.id_usuario_reg,
						aupc.fecha_reg,
						aupc.id_usuario_ai,
						aupc.usuario_ai,
						aupc.id_usuario_mod,
						aupc.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        initcap(fu.desc_funcionario1) as desc_funcionario,
                        pcs.proceso
						from ssom.tauditoria_proceso aupc
						inner join segu.tusuario usu1 on usu1.id_usuario = aupc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aupc.id_usuario_mod
                        inner join ssom.tproceso pcs on aupc.id_proceso = pcs.id_proceso
                        inner join orga.vfuncionario fu on fu.id_funcionario = pcs.id_responsable
            			where  ';
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_AUPC_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 15:51:56
    ***********************************/

	elsif(p_transaccion='SSOM_AUPC_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_aproceso)
					    from ssom.tauditoria_proceso aupc
					    inner join segu.tusuario usu1 on usu1.id_usuario = aupc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aupc.id_usuario_mod
                        inner join ssom.tproceso pcs on aupc.id_proceso = pcs.id_proceso
                        inner join orga.vfuncionario fu on fu.id_funcionario = pcs.id_responsable
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

ALTER FUNCTION ssom.ft_auditoria_proceso_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;