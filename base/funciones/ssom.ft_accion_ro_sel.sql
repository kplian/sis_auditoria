--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_accion_ro_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_accion_ro_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.taccion_ro''
 AUTOR: 		 (max.camacho)
 FECHA:	        16-12-2019 19:41:57
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				16-12-2019 19:41:57								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.taccion_ro''
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = ''ssom.ft_accion_ro_sel'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_ARO_SEL''
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 19:41:57
	***********************************/

	if(p_transaccion=''SSOM_ARO_SEL'')then

    	begin
    		--Sentencia de la consulta
			v_consulta:=''select
						aro.id_accion_ro,
						aro.id_aom_ro,
						aro.accion_ro,
						aro.estado_reg,
						aro.desc_accion_ro,
						aro.id_usuario_ai,
						aro.id_usuario_reg,
						aro.fecha_reg,
						aro.usuario_ai,
						aro.fecha_mod,
						aro.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
						from ssom.taccion_ro aro
						inner join segu.tusuario usu1 on usu1.id_usuario = aro.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aro.id_usuario_mod
            join ssom.taom_riesgo_oportunidad arop on aro.id_aom_ro = arop.id_aom_ro
				    where  '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_ARO_CONT''
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 19:41:57
	***********************************/

	elsif(p_transaccion=''SSOM_ARO_CONT'')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:=''select count(aro.id_accion_ro)
					    from ssom.taccion_ro aro
					    inner join segu.tusuario usu1 on usu1.id_usuario = aro.id_usuario_reg
							left join segu.tusuario usu2 on usu2.id_usuario = aro.id_usuario_mod
              join ssom.taom_riesgo_oportunidad arop on aro.id_aom_ro = arop.id_aom_ro
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