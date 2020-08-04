CREATE OR REPLACE FUNCTION ssom.ft_norma_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$CREATE OR REPLACE FUNCTION ssom.ft_norma_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_norma_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tnorma'
 AUTOR: 		 (szambrana)
 FECHA:	        02-07-2019 19:11:48
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-07-2019 19:11:48								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tnorma'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

    v_parametro_filtro  varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_norma_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_NOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	if(p_transaccion='SSOM_NOR_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
                        nor.id_norma,
                        nor.id_parametro,
                        nor.estado_reg,
                        nor.nombre_norma,
                        nor.sigla_norma,
                        nor.descrip_norma,
                        nor.fecha_reg,
                        nor.usuario_ai,
                        nor.id_usuario_reg,
                        nor.id_usuario_ai,
                        nor.fecha_mod,
                        nor.id_usuario_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                       	param.valor_parametro as desc_tn
                        from ssom.tnorma nor
                        inner join segu.tusuario usu1 on usu1.id_usuario = nor.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = nor.id_usuario_mod
                        join ssom.tparametro param on param.id_parametro = nor.id_parametro
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_NOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	elsif(p_transaccion='SSOM_NOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_norma)
                        from ssom.tnorma nor
                        inner join segu.tusuario usu1 on usu1.id_usuario = nor.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = nor.id_usuario_mod
                        join ssom.tparametro param on param.id_parametro = nor.id_parametro
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

ALTER FUNCTION ssom.ft_norma_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_norma_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tnorma'
 AUTOR: 		 (szambrana)
 FECHA:	        02-07-2019 19:11:48
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-07-2019 19:11:48								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tnorma'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    
    v_parametro_filtro  varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_norma_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_NOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	if(p_transaccion='SSOM_NOR_SEL')then
     				
    	begin
    		--Sentencia de la consulta            
			v_consulta:='select
                        nor.id_norma,
                        nor.id_parametro,
                        nor.estado_reg,
                        nor.nombre_norma,
                        nor.sigla_norma,
                        nor.descrip_norma,
                        nor.fecha_reg,
                        nor.usuario_ai,
                        nor.id_usuario_reg,
                        nor.id_usuario_ai,
                        nor.fecha_mod,
                        nor.id_usuario_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                       	param.valor_parametro as desc_tn	
                        from ssom.tnorma nor
                        inner join segu.tusuario usu1 on usu1.id_usuario = nor.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = nor.id_usuario_mod
                        join ssom.tparametro param on param.id_parametro = nor.id_parametro
				        where  ';
			
			--Definicion de la respuesta            
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_NOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 19:11:48
	***********************************/

	elsif(p_transaccion='SSOM_NOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_norma)
                        from ssom.tnorma nor
                        inner join segu.tusuario usu1 on usu1.id_usuario = nor.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = nor.id_usuario_mod
                        join ssom.tparametro param on param.id_parametro = nor.id_parametro
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