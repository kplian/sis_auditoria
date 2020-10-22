CREATE OR REPLACE FUNCTION ssom.ft_pnorma_noconformidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_pnorma_noconformidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpnorma_noconformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        19-07-2019 15:25:54
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				19-07-2019 15:25:54								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpnorma_noconformidad'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_pnorma_noconformidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PNNC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

	if(p_transaccion='SSOM_PNNC_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pnnc.id_pnnc,
						pnnc.id_nc,
						pnnc.estado_reg,
						pnnc.id_pn,
						pnnc.id_norma,
						pnnc.usuario_ai,
						pnnc.fecha_reg,
						pnnc.id_usuario_reg,
						pnnc.id_usuario_ai,
						pnnc.fecha_mod,
						pnnc.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        norm.nombre_norma as desc_norma,
                        norm.sigla_norma,
                        initcap(pnorm.nombre_pn)::varchar as  nombre_pn,
                        no.id_aom,
                        pnorm.codigo_pn,
                        ''(''||pnorm.codigo_pn||'') ''|| pnorm.nombre_pn as nombre_descrip
						from ssom.tpnorma_noconformidad pnnc
						inner join segu.tusuario usu1 on usu1.id_usuario = pnnc.id_usuario_reg
                        inner join ssom.tno_conformidad no on no.id_nc = pnnc.id_nc
						left join segu.tusuario usu2 on usu2.id_usuario = pnnc.id_usuario_mod
                        left join ssom.tnorma norm on norm.id_norma = pnnc.id_norma
                        left join ssom.tpunto_norma pnorm on pnorm.id_pn = pnnc.id_pn
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_PNNC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana
 	#FECHA:		19-07-2019 15:25:54
	***********************************/

	elsif(p_transaccion='SSOM_PNNC_CONT')then
		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pnnc)
					  from ssom.tpnorma_noconformidad pnnc
						inner join segu.tusuario usu1 on usu1.id_usuario = pnnc.id_usuario_reg
                         inner join ssom.tno_conformidad no on no.id_nc = pnnc.id_nc
						left join segu.tusuario usu2 on usu2.id_usuario = pnnc.id_usuario_mod
                        left join ssom.tnorma norm on norm.id_norma = pnnc.id_norma
                        left join ssom.tpunto_norma pnorm on pnorm.id_pn = pnnc.id_pn
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

ALTER FUNCTION ssom.ft_pnorma_noconformidad_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;