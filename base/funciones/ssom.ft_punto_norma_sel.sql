CREATE OR REPLACE FUNCTION ssom.ft_punto_norma_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_punto_norma_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpunto_norma'
 AUTOR: 		 (szambrana)
 FECHA:	        01-07-2019 18:45:10
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				01-07-2019 18:45:10								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpunto_norma'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_punto_norma_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PTONOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		01-07-2019 18:45:10
	***********************************/

	if(p_transaccion='SSOM_PTONOR_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						ptonor.id_pn,
						ptonor.id_norma,
						ptonor.nombre_pn,
						ptonor.codigo_pn,
						ptonor.descrip_pn,
						ptonor.estado_reg,
						ptonor.id_usuario_ai,
						ptonor.usuario_ai,
						ptonor.fecha_reg,
						ptonor.id_usuario_reg,
						ptonor.fecha_mod,
						ptonor.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        nr.sigla_norma
						from ssom.tpunto_norma ptonor
						inner join segu.tusuario usu1 on usu1.id_usuario = ptonor.id_usuario_reg
                        inner join ssom.tnorma nr on nr.id_norma = ptonor.id_norma
						left join segu.tusuario usu2 on usu2.id_usuario = ptonor.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PTONOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana
 	#FECHA:		01-07-2019 18:45:10
	***********************************/

	elsif(p_transaccion='SSOM_PTONOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pn)
					    from ssom.tpunto_norma ptonor
					    inner join segu.tusuario usu1 on usu1.id_usuario = ptonor.id_usuario_reg
                        inner join ssom.tnorma nr on nr.id_norma = ptonor.id_norma
						left join segu.tusuario usu2 on usu2.id_usuario = ptonor.id_usuario_mod
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
    	/*********************************
 	#TRANSACCION:  'SSOM_PTOM_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

    elseif (p_transaccion='SSOM_PTOM_SEL') then

    	begin
            --listado para multiselec
			v_consulta:='select
						ptonor.id_pn,
						ptonor.id_norma,
						ptonor.nombre_pn,
						ptonor.codigo_pn,
						ptonor.descrip_pn,
						ptonor.estado_reg,
						ptonor.id_usuario_ai,
						ptonor.usuario_ai,
						ptonor.fecha_reg,
						ptonor.id_usuario_reg,
						ptonor.fecha_mod,
						ptonor.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                         ''(''||ptonor.codigo_pn||'') ''|| ptonor.nombre_pn as nombre_descrip
						from ssom.tpunto_norma ptonor
						inner join segu.tusuario usu1 on usu1.id_usuario = ptonor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ptonor.id_usuario_mod
                        where ';

           	--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
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

ALTER FUNCTION ssom.ft_punto_norma_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;