CREATE OR REPLACE FUNCTION ssom.ft_tipo_ro_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_tipo_ro_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_ro'
   AUTOR: 		 (max.camacho)
   FECHA:	        16-12-2019 17:36:24
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				16-12-2019 17:36:24								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_ro'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_tipo_ro_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_TRO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:36:24
	***********************************/

	if(p_transaccion='SSOM_TRO_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						tro.id_tipo_ro,
						tro.tipo_ro,
						tro.estado_reg,
						tro.desc_tipo_ro,
						tro.id_usuario_reg,
						tro.fecha_reg,
						tro.usuario_ai,
						tro.id_usuario_ai,
						tro.fecha_mod,
						tro.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
						from ssom.ttipo_ro tro
						inner join segu.tusuario usu1 on usu1.id_usuario = tro.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tro.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_TRO_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 17:36:24
    ***********************************/

	elsif(p_transaccion='SSOM_TRO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_ro)
					    from ssom.ttipo_ro tro
					    inner join segu.tusuario usu1 on usu1.id_usuario = tro.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tro.id_usuario_mod
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
	COST 100;