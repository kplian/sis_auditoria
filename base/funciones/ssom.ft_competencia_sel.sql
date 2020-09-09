CREATE OR REPLACE FUNCTION ssom.ft_competencia_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_competencia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcompetencia'
 AUTOR: 		 (admin.miguel)
 FECHA:	        03-09-2020 16:11:08
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:08								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcompetencia'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_competencia_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_COA_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin.miguel
 	#FECHA:		03-09-2020 16:11:08
	***********************************/

	if(p_transaccion='SSOM_COA_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select   coa.id_competencia,
                                  coa.estado_reg,
                                  coa.obs_dba,
                                  coa.id_equipo_auditores,
                                  coa.id_norma,
                                  coa.nro_auditorias,
                                  coa.hras_formacion,
                                  coa.meses_actualizacion,
                                  coa.calificacion,
                                  coa.id_usuario_reg,
                                  coa.fecha_reg,
                                  coa.id_usuario_ai,
                                  coa.usuario_ai,
                                  coa.id_usuario_mod,
                                  coa.fecha_mod,
                                  usu1.cuenta as usr_reg,
                                  usu2.cuenta as usr_mod,
                                  no.sigla_norma as desc_sigla_norma,
                                  no.nombre_norma
                                  from ssom.tcompetencia coa
                                  inner join segu.tusuario usu1 on usu1.id_usuario = coa.id_usuario_reg
                                  inner join ssom.tnorma  no on no.id_norma = coa.id_norma
                                  left join segu.tusuario usu2 on usu2.id_usuario = coa.id_usuario_mod
                                  where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_COA_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin.miguel
 	#FECHA:		03-09-2020 16:11:08
	***********************************/

	elsif(p_transaccion='SSOM_COA_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_competencia)
					    from ssom.tcompetencia coa
					    inner join segu.tusuario usu1 on usu1.id_usuario = coa.id_usuario_reg
                        inner join ssom.tnorma  no on no.id_norma = coa.id_norma
                        left join segu.tusuario usu2 on usu2.id_usuario = coa.id_usuario_mod
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

ALTER FUNCTION ssom.ft_competencia_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;