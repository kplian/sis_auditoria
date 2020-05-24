CREATE OR REPLACE FUNCTION ssom.ft_tipo_auditoria_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_tipo_auditoria_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_auditoria'
   AUTOR: 		 (max.camacho)
   FECHA:	        17-07-2019 13:23:26
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				17-07-2019 13:23:26								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_auditoria'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_tipo_auditoria_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_TAU_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		17-07-2019 13:23:26
	***********************************/

	if(p_transaccion='SSOM_TAU_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						tau.id_tipo_auditoria,
						tau.descrip_tauditoria,
						tau.estado_reg,
						tau.tipo_auditoria,
                        tau.codigo_tpo_aom,
						tau.id_usuario_ai,
						tau.id_usuario_reg,
						tau.usuario_ai,
						tau.fecha_reg,
						tau.id_usuario_mod,
						tau.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
						from ssom.ttipo_auditoria tau
						inner join segu.tusuario usu1 on usu1.id_usuario = tau.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tau.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_TAU_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		17-07-2019 13:23:26
    ***********************************/

	elsif(p_transaccion='SSOM_TAU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_auditoria)
					    from ssom.ttipo_auditoria tau
					    inner join segu.tusuario usu1 on usu1.id_usuario = tau.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tau.id_usuario_mod
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

ALTER FUNCTION ssom.ft_tipo_auditoria_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;