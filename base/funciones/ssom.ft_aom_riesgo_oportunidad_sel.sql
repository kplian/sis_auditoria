CREATE OR REPLACE FUNCTION ssom.ft_aom_riesgo_oportunidad_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_aom_riesgo_oportunidad_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.taom_riesgo_oportunidad'
   AUTOR: 		 (max.camacho)
   FECHA:	        16-12-2019 20:00:49
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				16-12-2019 20:00:49								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.taom_riesgo_oportunidad'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_aom_riesgo_oportunidad_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_AURO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		16-12-2019 20:00:49
	***********************************/

	if(p_transaccion='SSOM_AURO_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						auro.id_aom_ro,
						auro.estado_reg,
						auro.id_impacto,
						auro.id_probabilidad,
						auro.id_tipo_ro,
						auro.id_ro,
                        auro.otro_nombre_ro,
						auro.id_aom,
						auro.criticidad,
						auro.id_usuario_reg,
						auro.usuario_ai,
						auro.fecha_reg,
						auro.id_usuario_ai,
						auro.id_usuario_mod,
						auro.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,

                        rop.nombre_ro,
                        tro.desc_tipo_ro::varchar,
                        prb.nombre_prob,
                        imp.nombre_imp

						from ssom.taom_riesgo_oportunidad auro
						inner join segu.tusuario usu1 on usu1.id_usuario = auro.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = auro.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on auro.id_aom = aom.id_aom
                        join ssom.triesgo_oportunidad rop on auro.id_ro = rop.id_ro
                        join ssom.ttipo_ro tro on auro.id_tipo_ro = tro.id_tipo_ro
                        join ssom.tprobabilidad prb on auro.id_probabilidad = prb.id_probabilidad
                        join ssom.timpacto imp on auro.id_impacto = imp.id_impacto
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_AURO_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		16-12-2019 20:00:49
    ***********************************/

	elsif(p_transaccion='SSOM_AURO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_aom_ro)
					    from ssom.taom_riesgo_oportunidad auro
					    inner join segu.tusuario usu1 on usu1.id_usuario = auro.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = auro.id_usuario_mod
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