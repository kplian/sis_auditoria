/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_tipo_norma_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_norma'
 AUTOR: 		 (szambrana)
 FECHA:	        02-07-2019 20:54:21
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				02-07-2019 20:54:21								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.ttipo_norma'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_tipo_norma_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_TIPNOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 20:54:21
	***********************************/

	if(p_transaccion='SSOM_TIPNOR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tipnor.id_tipo_norma,
						tipnor.descrip_tipo_norma,
						tipnor.estado_reg,
						tipnor.nombre_tipo_norma,
						tipnor.id_usuario_ai,
						tipnor.id_usuario_reg,
						tipnor.fecha_reg,
						tipnor.usuario_ai,
						tipnor.id_usuario_mod,
						tipnor.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ssom.ttipo_norma tipnor
						inner join segu.tusuario usu1 on usu1.id_usuario = tipnor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tipnor.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_TIPNOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		02-07-2019 20:54:21
	***********************************/

	elsif(p_transaccion='SSOM_TIPNOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_norma)
					    from ssom.ttipo_norma tipnor
					    inner join segu.tusuario usu1 on usu1.id_usuario = tipnor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tipnor.id_usuario_mod
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