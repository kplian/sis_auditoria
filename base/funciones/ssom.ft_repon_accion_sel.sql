CREATE OR REPLACE FUNCTION ssom.ft_repon_accion_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_repon_accion_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.trepon_accion'
 AUTOR: 		 (admin.miguel)
 FECHA:	        06-10-2020 15:21:07
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				06-10-2020 15:21:07								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.trepon_accion'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_repon_accion_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_RAN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin.miguel
 	#FECHA:		06-10-2020 15:21:07
	***********************************/

	if(p_transaccion='SSOM_RAN_SEL')then
     				a
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						ran.id_repon_accion,
						ran.estado_reg,
						ran.obs_dba,
						ran.id_ap,
						ran.id_funcionario,
						ran.id_usuario_reg,
						ran.fecha_reg,
						ran.id_usuario_ai,
						ran.usuario_ai,
						ran.id_usuario_mod,
						ran.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        fu.desc_funcionario1 as desc_funcionario
						from ssom.trepon_accion ran
						inner join segu.tusuario usu1 on usu1.id_usuario = ran.id_usuario_reg
                        inner join orga.vfuncionario fu on fu.id_funcionario = ran.id_funcionario
						left join segu.tusuario usu2 on usu2.id_usuario = ran.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_RAN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin.miguel
 	#FECHA:		06-10-2020 15:21:07
	***********************************/

	elsif(p_transaccion='SSOM_RAN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_repon_accion)
					    from ssom.trepon_accion ran
					    inner join segu.tusuario usu1 on usu1.id_usuario = ran.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ran.id_usuario_mod
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

ALTER FUNCTION ssom.ft_repon_accion_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;