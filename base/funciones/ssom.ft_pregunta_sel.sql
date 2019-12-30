CREATE OR REPLACE FUNCTION ssom.ft_pregunta_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_pregunta_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpregunta'
 AUTOR: 		 (szambrana)
 FECHA:	        01-07-2019 19:04:06
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				01-07-2019 19:04:06								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tpregunta'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_pregunta_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_PRPTNOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		01-07-2019 19:04:06
	***********************************/

	if(p_transaccion='SSOM_PRPTNOR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						prptnor.id_pregunta,
						prptnor.nro_pregunta,
						prptnor.descrip_pregunta,
						prptnor.estado_reg,
						prptnor.id_pn,
						prptnor.id_usuario_ai,
						prptnor.id_usuario_reg,
						prptnor.usuario_ai,
						prptnor.fecha_reg,
						prptnor.id_usuario_mod,
						prptnor.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ssom.tpregunta prptnor
						inner join segu.tusuario usu1 on usu1.id_usuario = prptnor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = prptnor.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_PRPTNOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		01-07-2019 19:04:06
	***********************************/

	elsif(p_transaccion='SSOM_PRPTNOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pregunta)
					    from ssom.tpregunta prptnor
					    inner join segu.tusuario usu1 on usu1.id_usuario = prptnor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = prptnor.id_usuario_mod
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