CREATE OR REPLACE FUNCTION ssom.ft_equipo_auditores_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_equipo_auditores_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tequipo_auditores'
 AUTOR: 		 (admin.miguel)
 FECHA:	        03-09-2020 16:11:03
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:03								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tequipo_auditores'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_equipo_auditores_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_EUS_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin.miguel
 	#FECHA:		03-09-2020 16:11:03
	***********************************/

	if(p_transaccion='SSOM_EUS_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select  eus.id_equipo_auditores,
                                  eus.estado_reg,
                                  eus.obs_dba,
                                  eus.id_funcionario,
                                  eus.id_tipo_participacion,
                                  eus.id_usuario_reg,
                                  eus.fecha_reg,
                                  eus.id_usuario_ai,
                                  eus.usuario_ai,
                                  eus.id_usuario_mod,
                                  eus.fecha_mod,
                                  usu1.cuenta as usr_reg,
                                  usu2.cuenta as usr_mod,
                                  fun.desc_funcionario1,
                                  fun.descripcion_cargo,
                                  fun.email_empresa,
                                  pa.valor_parametro as desc_tipo
                                  from ssom.tequipo_auditores eus
                                  inner join segu.tusuario usu1 on usu1.id_usuario = eus.id_usuario_reg
                                  inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                                  inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                                  left join segu.tusuario usu2 on usu2.id_usuario = eus.id_usuario_mod
                                  where (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date) and';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_EUS_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin.miguel
 	#FECHA:		03-09-2020 16:11:03
	***********************************/

	elsif(p_transaccion='SSOM_EUS_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_equipo_auditores)
					    from ssom.tequipo_auditores eus
					    inner join segu.tusuario usu1 on usu1.id_usuario = eus.id_usuario_reg
                        inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                        inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                        left join segu.tusuario usu2 on usu2.id_usuario = eus.id_usuario_mod
                        where (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date) and ';

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

ALTER FUNCTION ssom.ft_equipo_auditores_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;