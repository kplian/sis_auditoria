--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_auditoria_npnpg_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_auditoria_npnpg_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tauditoria_npnpg''
 AUTOR: 		 (max.camacho)
 FECHA:	        25-07-2019 21:34:47
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				25-07-2019 21:34:47								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tauditoria_npnpg''
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = ''ssom.ft_auditoria_npnpg_sel'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_APNP_SEL''
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 21:34:47
	***********************************/

	if(p_transaccion=''SSOM_APNP_SEL'')then

    	begin
    		--Sentencia de la consulta
			v_consulta:=''select
						apnp.id_anpnpg,
						apnp.pg_valoracion,
						apnp.obs_pg,
						apnp.id_pregunta,
						apnp.estado_reg,
						apnp.id_anpn,
						apnp.id_usuario_ai,
						apnp.fecha_reg,
						apnp.usuario_ai,
						apnp.id_usuario_reg,
						apnp.id_usuario_mod,
						apnp.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						pnor.nombre_pn,
						pnor.id_pn,
						preg.descrip_pregunta
						from ssom.tauditoria_npnpg apnp
						inner join segu.tusuario usu1 on usu1.id_usuario = apnp.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = apnp.id_usuario_mod
						join ssom.tpregunta preg on apnp.id_pregunta = preg.id_pregunta
						join ssom.tauditoria_npn anpn on apnp.id_anpn = anpn.id_anpn
						join ssom.tpunto_norma pnor on anpn.id_pn = pnor.id_pn
				    where  '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_APNP_CONT''
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 21:34:47
	***********************************/

	elsif(p_transaccion=''SSOM_APNP_CONT'')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:=''select count(id_anpnpg)
					    from ssom.tauditoria_npnpg apnp
					    inner join segu.tusuario usu1 on usu1.id_usuario = apnp.id_usuario_reg
							left join segu.tusuario usu2 on usu2.id_usuario = apnp.id_usuario_mod
							join ssom.tpregunta preg on apnp.id_pregunta = preg.id_pregunta
							join ssom.tauditoria_npn anpn on apnp.id_anpn = anpn.id_anpn
							join ssom.tpunto_norma pnor on anpn.id_pn = pnor.id_pn
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