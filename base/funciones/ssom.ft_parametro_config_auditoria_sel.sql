CREATE OR REPLACE FUNCTION "ssom"."ft_parametro_config_auditoria_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_parametro_config_auditoria_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tparametro_config_auditoria'
 AUTOR: 		 (max.camacho)
 FECHA:	        20-08-2019 16:16:47
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				20-08-2019 16:16:47								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tparametro_config_auditoria'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_parametro_config_auditoria_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_PCAOM_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho	
 	#FECHA:		20-08-2019 16:16:47
	***********************************/

	if(p_transaccion='SSOM_PCAOM_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pcaom.id_param_config_aom,
						pcaom.estado_reg,
						pcaom.param_gestion,
						pcaom.param_fecha_a,
						pcaom.param_fecha_b,
						pcaom.param_serie,
						pcaom.param_estado_config,
						pcaom.id_usuario_reg,
						pcaom.fecha_reg,
						pcaom.id_usuario_ai,
						pcaom.usuario_ai,
						pcaom.id_usuario_mod,
						pcaom.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ssom.tparametro_config_auditoria pcaom
						inner join segu.tusuario usu1 on usu1.id_usuario = pcaom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pcaom.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PCAOM_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho	
 	#FECHA:		20-08-2019 16:16:47
	***********************************/

	elsif(p_transaccion='SSOM_PCAOM_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_param_config_aom)
					    from ssom.tparametro_config_auditoria pcaom
					    inner join segu.tusuario usu1 on usu1.id_usuario = pcaom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pcaom.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ssom"."ft_parametro_config_auditoria_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
