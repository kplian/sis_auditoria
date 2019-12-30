CREATE OR REPLACE FUNCTION ssom.ft_auditoria_npn_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_npn_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_npn'
   AUTOR: 		 (max.camacho)
   FECHA:	        25-07-2019 21:19:37
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				25-07-2019 21:19:37								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_npn'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_npn_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_ANPN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		25-07-2019 21:19:37
	***********************************/

	if(p_transaccion='SSOM_ANPN_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						anpn.id_anpn,
						anpn.estado_reg,
						anpn.id_aom,---
						anpn.id_pn,
						anpn.id_norma,
                        anpn.obs_apn,---
						anpn.fecha_reg,
						anpn.usuario_ai,
						anpn.id_usuario_reg,
						anpn.id_usuario_ai,
						anpn.id_usuario_mod,
						anpn.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        nor.sigla_norma,
                        nor.nombre_norma,
                        ''[''||pnor.codigo_pn::varchar||'']''||''.-''||'' ''||pnor.nombre_pn as desc_punto_norma
						from ssom.tauditoria_npn anpn
						inner join segu.tusuario usu1 on usu1.id_usuario = anpn.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = anpn.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on anpn.id_aom = aom.id_aom
                        join ssom.tnorma nor on anpn.id_norma = nor.id_norma
                        join ssom.tpunto_norma pnor on anpn.id_pn = pnor.id_pn
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice 'v_consulta %',v_consulta;
			--Devuelve la respuesta
			--raise EXCEPTION 'resultado de la consulta %', v_consulta;
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_ANPN_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		25-07-2019 21:19:37
    ***********************************/

	elsif(p_transaccion='SSOM_ANPN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(anpn.id_anpn)
					    from ssom.tauditoria_npn anpn
					    inner join segu.tusuario usu1 on usu1.id_usuario = anpn.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = anpn.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on anpn.id_aom = aom.id_aom
                        join ssom.tnorma nor on anpn.id_norma = nor.id_norma
                        join ssom.tpunto_norma pnor on anpn.id_pn = pnor.id_pn
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