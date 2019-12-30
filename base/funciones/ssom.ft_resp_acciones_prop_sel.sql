CREATE OR REPLACE FUNCTION ssom.ft_resp_acciones_prop_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_resp_acciones_prop_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tresp_acciones_prop'
 AUTOR: 		 (szambrana)
 FECHA:	        17-09-2019 14:35:45
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-09-2019 14:35:45								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tresp_acciones_prop'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_resp_acciones_prop_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_RESAP_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		17-09-2019 14:35:45
	***********************************/

	if(p_transaccion='SSOM_RESAP_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						resap.id_respap,
						resap.estado_reg,
						resap.id_ap,
						resap.id_funcionario,
						resap.id_usuario_reg,
						resap.fecha_reg,
						resap.id_usuario_ai,
						resap.usuario_ai,
						resap.id_usuario_mod,
						resap.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        vfu.desc_funcionario1	
						from ssom.tresp_acciones_prop resap
						inner join segu.tusuario usu1 on usu1.id_usuario = resap.id_usuario_reg
                        inner join orga.vfuncionario_cargo vfu on vfu.id_funcionario = resap.id_funcionario                        
						left join segu.tusuario usu2 on usu2.id_usuario = resap.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_RESAP_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		17-09-2019 14:35:45
	***********************************/

	elsif(p_transaccion='SSOM_RESAP_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_respap)
					    from ssom.tresp_acciones_prop resap
						inner join segu.tusuario usu1 on usu1.id_usuario = resap.id_usuario_reg
                        inner join orga.vfuncionario_cargo vfu on vfu.id_funcionario = resap.id_funcionario                        
						left join segu.tusuario usu2 on usu2.id_usuario = resap.id_usuario_mod
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