--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_riesgo_oportunidad_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_riesgo_oportunidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.triesgo_oportunidad''
 AUTOR: 		 (max.camacho)
 FECHA:	        16-12-2019 17:57:34
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 17:57:34								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.triesgo_oportunidad''
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = ''ssom.ft_riesgo_oportunidad_sel'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_RIOP_SEL''
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:57:34
	***********************************/

	if(p_transaccion=''SSOM_RIOP_SEL'')then

    	begin
    		--Sentencia de la consulta
			v_consulta:=''select
						riop.id_ro,
						riop.id_tipo_ro,
						riop.nombre_ro,
                        riop.codigo_ro,
						riop.estado_reg,
						riop.id_usuario_ai,
						riop.usuario_ai,
						riop.fecha_reg,
						riop.id_usuario_reg,
						riop.fecha_mod,
						riop.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        tro.tipo_ro,
                        tro.desc_tipo_ro::varchar
						from ssom.triesgo_oportunidad riop
						inner join segu.tusuario usu1 on usu1.id_usuario = riop.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = riop.id_usuario_mod
                        join ssom.ttipo_ro tro on riop.id_tipo_ro = tro.id_tipo_ro
				        where  '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_RIOP_CONT''
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 17:57:34
	***********************************/

	elsif(p_transaccion=''SSOM_RIOP_CONT'')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:=''select count(id_ro)
					    from ssom.triesgo_oportunidad riop
					    inner join segu.tusuario usu1 on usu1.id_usuario = riop.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = riop.id_usuario_mod
                        join ssom.ttipo_ro tro on riop.id_tipo_ro = tro.id_tipo_ro
					    where '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	else

		raise exception ''Transaccion inexistente'';

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
 COST 100;