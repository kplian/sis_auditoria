CREATE OR REPLACE FUNCTION ssom.ft_sistema_integrado_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_sistema_integrado_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tsistema_integrado'
 AUTOR: 		 (szambrana)
 FECHA:	        24-07-2019 21:09:26
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-07-2019 21:09:26								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tsistema_integrado'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_sistema_integrado_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_SISINT_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		24-07-2019 21:09:26
	***********************************/

	if(p_transaccion='SSOM_SISINT_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						sisint.id_si,
						sisint.estado_reg,
						sisint.nombre_si,
						sisint.descrip_si,
						sisint.id_usuario_reg,
						sisint.fecha_reg,
						sisint.id_usuario_ai,
						sisint.usuario_ai,
						sisint.id_usuario_mod,
						sisint.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ssom.tsistema_integrado sisint
						inner join segu.tusuario usu1 on usu1.id_usuario = sisint.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sisint.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SISINT_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		24-07-2019 21:09:26
	***********************************/

	elsif(p_transaccion='SSOM_SISINT_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_si)
					    from ssom.tsistema_integrado sisint
					    inner join segu.tusuario usu1 on usu1.id_usuario = sisint.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sisint.id_usuario_mod
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